<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = \App\Models\ContactForm::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Your message has been sent successfully.',
            'data' => $contact
        ], 201);
    }
}
