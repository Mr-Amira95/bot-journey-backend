<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Get all settings as key-value pairs.
     */
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return response()->json([
            'status' => 'success',
            'data' => $settings,
        ]);
    }
}
