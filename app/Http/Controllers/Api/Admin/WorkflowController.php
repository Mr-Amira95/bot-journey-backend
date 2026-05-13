<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workflow;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 'success', 'data' => Workflow::orderBy('order')->get()]);
    }

    public function show($id)
    {
        return response()->json(['status' => 'success', 'data' => Workflow::findOrFail($id)]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'subtitle' => 'nullable|array',
            'order' => 'nullable|integer',
            'icon' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('icons', 'public');
        }

        $workflow = Workflow::create($data);
        return response()->json(['status' => 'success', 'data' => $workflow], 201);
    }

    public function update(Request $request, $id)
    {
        $workflow = Workflow::findOrFail($id);
        $data = $request->validate([
            'title' => 'nullable|array',
            'subtitle' => 'nullable|array',
            'order' => 'nullable|integer',
            'icon' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('icon')) {
            if ($workflow->icon) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($workflow->icon);
            }
            $data['icon'] = $request->file('icon')->store('icons', 'public');
        } else {
            unset($data['icon']);
        }

        $workflow->update($data);
        return response()->json(['status' => 'success', 'data' => $workflow]);
    }

    public function destroy($id)
    {
        $workflow = Workflow::findOrFail($id);
        if ($workflow->icon) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($workflow->icon);
        }
        $workflow->delete();
        return response()->json(['status' => 'success', 'message' => 'Workflow deleted']);
    }
}
