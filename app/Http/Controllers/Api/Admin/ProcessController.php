<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Process;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 'success', 'data' => Process::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'description' => 'nullable|array',
        ]);

        $process = Process::create($data);
        return response()->json(['status' => 'success', 'data' => $process], 201);
    }

    public function update(Request $request, $id)
    {
        $process = Process::findOrFail($id);
        $data = $request->validate([
            'title' => 'nullable|array',
            'description' => 'nullable|array',
        ]);

        $process->update($data);
        return response()->json(['status' => 'success', 'data' => $process]);
    }

    public function destroy($id)
    {
        Process::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Process deleted']);
    }
}
