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

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'subtitle' => 'nullable|array',
            'order' => 'nullable|integer',
        ]);

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
        ]);

        $workflow->update($data);
        return response()->json(['status' => 'success', 'data' => $workflow]);
    }

    public function destroy($id)
    {
        Workflow::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Workflow deleted']);
    }
}
