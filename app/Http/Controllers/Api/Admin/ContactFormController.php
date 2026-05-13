<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function index()
    {
        $contacts = \App\Models\ContactForm::latest()->get();
        return response()->json(['status' => 'success', 'data' => $contacts]);
    }

    public function destroy($id)
    {
        $contact = \App\Models\ContactForm::find($id);
        if (!$contact) {
            return response()->json(['status' => 'error', 'message' => 'Contact not found'], 404);
        }
        $contact->delete();
        return response()->json(['status' => 'success', 'message' => 'Contact deleted successfully']);
    }
}
