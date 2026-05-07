<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\AdminPasswordResetCode;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    /**
     * Step 1: Send verification code to email
     */
    public function sendCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:admins,email']);

        $email = $request->email;
        $code = rand(100000, 999999);

        // Store or update the code in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($code),
                'created_at' => Carbon::now()
            ]
        );

        // Send the email
        Mail::to($email)->send(new AdminPasswordResetCode($code));

        return response()->json([
            'message' => 'Verification code sent to your email.',
        ]);
    }

    /**
     * Step 2: Verify the code
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'code' => 'required|numeric',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record) {
            throw ValidationException::withMessages(['code' => ['Invalid or expired code.']]);
        }

        // Check if expired (e.g., 15 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            throw ValidationException::withMessages(['code' => ['Verification code has expired.']]);
        }

        if (!Hash::check($request->code, $record->token)) {
            throw ValidationException::withMessages(['code' => ['The verification code is incorrect.']]);
        }

        return response()->json([
            'message' => 'Code verified successfully.',
        ]);
    }

    /**
     * Step 3: Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'code' => 'required|numeric',
            'password' => 'required|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->code, $record->token)) {
            throw ValidationException::withMessages(['code' => ['Invalid or expired code.']]);
        }

        if (Carbon::parse($record->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            throw ValidationException::withMessages(['code' => ['Verification code has expired.']]);
        }

        // Update admin password
        $admin = Admin::where('email', $request->email)->first();
        $admin->password = Hash::make($request->password);
        $admin->save();

        // Delete the token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'message' => 'Password has been reset successfully.',
        ]);
    }
}
