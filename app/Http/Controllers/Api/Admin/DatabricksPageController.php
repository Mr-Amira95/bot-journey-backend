<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\DatabricksSection;
use App\Models\DatabricksService;
use App\Models\DatabricksUseCase;
use App\Models\DatabricksStat;
use App\Models\DatabricksPartnerPoint;
use App\Models\DatabricksTrustSignal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DatabricksPageController extends Controller
{
    // ==========================================
    // SECTIONS MANAGEMENT
    // ==========================================
    public function getSections()
    {
        $sections = DatabricksSection::all()->keyBy('section_key');
        return response()->json(['status' => 'success', 'data' => $sections]);
    }

    public function updateSections(Request $request)
    {
        $data = $request->validate([
            'sections' => 'required|array',
            'sections.*.title' => 'nullable|array',
            'sections.*.subtitle' => 'nullable|array',
            'sections.*.extra_data' => 'nullable|array',
        ]);

        foreach ($data['sections'] as $key => $values) {
            DatabricksSection::updateOrCreate(
                ['section_key' => $key],
                [
                    'title' => $values['title'] ?? null,
                    'subtitle' => $values['subtitle'] ?? null,
                    'extra_data' => $values['extra_data'] ?? null,
                ]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Sections updated successfully',
            'data' => DatabricksSection::all()->keyBy('section_key')
        ]);
    }

    // ==========================================
    // SERVICES MANAGEMENT
    // ==========================================
    public function getServices()
    {
        $services = DatabricksService::orderBy('order')->get();
        return response()->json(['status' => 'success', 'data' => $services]);
    }

    public function storeService(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'description' => 'required|array',
            'icon' => 'nullable',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('databricks/icons', 'public');
        }

        $service = DatabricksService::create($data);
        return response()->json(['status' => 'success', 'data' => $service], 201);
    }

    public function updateService(Request $request, $id)
    {
        $service = DatabricksService::findOrFail($id);
        $data = $request->validate([
            'title' => 'nullable|array',
            'description' => 'nullable|array',
            'icon' => 'nullable',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('icon')) {
            if ($service->icon && !str_contains($service->icon, 'lucide')) {
                Storage::disk('public')->delete($service->icon);
            }
            $data['icon'] = $request->file('icon')->store('databricks/icons', 'public');
        } elseif ($request->has('icon') && is_string($request->icon)) {
            // allows keeping existing string icon keys or lucide names
            $data['icon'] = $request->icon;
        } else {
            unset($data['icon']);
        }

        $service->update($data);
        return response()->json(['status' => 'success', 'data' => $service]);
    }

    public function destroyService($id)
    {
        $service = DatabricksService::findOrFail($id);
        if ($service->icon && !str_contains($service->icon, 'lucide')) {
            Storage::disk('public')->delete($service->icon);
        }
        $service->delete();
        return response()->json(['status' => 'success', 'message' => 'Service deleted successfully']);
    }

    // ==========================================
    // USE CASES MANAGEMENT
    // ==========================================
    public function getUseCases()
    {
        $useCases = DatabricksUseCase::orderBy('order')->get();
        return response()->json(['status' => 'success', 'data' => $useCases]);
    }

    public function storeUseCase(Request $request)
    {
        $data = $request->validate([
            'industry' => 'required|array',
            'headline' => 'required|array',
            'description' => 'required|array',
            'order' => 'nullable|integer',
        ]);

        $useCase = DatabricksUseCase::create($data);
        return response()->json(['status' => 'success', 'data' => $useCase], 201);
    }

    public function updateUseCase(Request $request, $id)
    {
        $useCase = DatabricksUseCase::findOrFail($id);
        $data = $request->validate([
            'industry' => 'nullable|array',
            'headline' => 'nullable|array',
            'description' => 'nullable|array',
            'order' => 'nullable|integer',
        ]);

        $useCase->update($data);
        return response()->json(['status' => 'success', 'data' => $useCase]);
    }

    public function destroyUseCase($id)
    {
        $useCase = DatabricksUseCase::findOrFail($id);
        $useCase->delete();
        return response()->json(['status' => 'success', 'message' => 'Use case deleted successfully']);
    }

    // ==========================================
    // STATS MANAGEMENT
    // ==========================================
    public function getStats()
    {
        $stats = DatabricksStat::orderBy('order')->get();
        return response()->json(['status' => 'success', 'data' => $stats]);
    }

    public function storeStat(Request $request)
    {
        $data = $request->validate([
            'value' => 'required|string',
            'label' => 'required|array',
            'color' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $stat = DatabricksStat::create($data);
        return response()->json(['status' => 'success', 'data' => $stat], 201);
    }

    public function updateStat(Request $request, $id)
    {
        $stat = DatabricksStat::findOrFail($id);
        $data = $request->validate([
            'value' => 'nullable|string',
            'label' => 'nullable|array',
            'color' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $stat->update($data);
        return response()->json(['status' => 'success', 'data' => $stat]);
    }

    public function destroyStat($id)
    {
        $stat = DatabricksStat::findOrFail($id);
        $stat->delete();
        return response()->json(['status' => 'success', 'message' => 'Stat deleted successfully']);
    }

    // ==========================================
    // PARTNER POINTS MANAGEMENT
    // ==========================================
    public function getPartnerPoints()
    {
        $points = DatabricksPartnerPoint::orderBy('order')->get();
        return response()->json(['status' => 'success', 'data' => $points]);
    }

    public function storePartnerPoint(Request $request)
    {
        $data = $request->validate([
            'text' => 'required|array',
            'order' => 'nullable|integer',
        ]);

        $point = DatabricksPartnerPoint::create($data);
        return response()->json(['status' => 'success', 'data' => $point], 201);
    }

    public function updatePartnerPoint(Request $request, $id)
    {
        $point = DatabricksPartnerPoint::findOrFail($id);
        $data = $request->validate([
            'text' => 'nullable|array',
            'order' => 'nullable|integer',
        ]);

        $point->update($data);
        return response()->json(['status' => 'success', 'data' => $point]);
    }

    public function destroyPartnerPoint($id)
    {
        $point = DatabricksPartnerPoint::findOrFail($id);
        $point->delete();
        return response()->json(['status' => 'success', 'message' => 'Partner point deleted successfully']);
    }

    // ==========================================
    // TRUST SIGNALS MANAGEMENT
    // ==========================================
    public function getTrustSignals()
    {
        $signals = DatabricksTrustSignal::orderBy('order')->get();
        return response()->json(['status' => 'success', 'data' => $signals]);
    }

    public function storeTrustSignal(Request $request)
    {
        $data = $request->validate([
            'text' => 'required|array',
            'order' => 'nullable|integer',
        ]);

        $signal = DatabricksTrustSignal::create($data);
        return response()->json(['status' => 'success', 'data' => $signal], 201);
    }

    public function updateTrustSignal(Request $request, $id)
    {
        $signal = DatabricksTrustSignal::findOrFail($id);
        $data = $request->validate([
            'text' => 'nullable|array',
            'order' => 'nullable|integer',
        ]);

        $signal->update($data);
        return response()->json(['status' => 'success', 'data' => $signal]);
    }

    public function destroyTrustSignal($id)
    {
        $signal = DatabricksTrustSignal::findOrFail($id);
        $signal->delete();
        return response()->json(['status' => 'success', 'message' => 'Trust signal deleted successfully']);
    }
}
