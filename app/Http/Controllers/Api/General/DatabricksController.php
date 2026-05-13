<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\DatabricksSection;
use App\Models\DatabricksService;
use App\Models\DatabricksUseCase;
use App\Models\DatabricksStat;
use App\Models\DatabricksPartnerPoint;
use App\Models\DatabricksTrustSignal;
use Illuminate\Http\Request;

class DatabricksController extends Controller
{
    /**
     * Get all aggregated Databricks page content.
     */
    public function getPageContent()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'sections' => DatabricksSection::all()->keyBy('section_key'),
                'services' => DatabricksService::orderBy('order')->get(),
                'use_cases' => DatabricksUseCase::orderBy('order')->get(),
                'stats' => DatabricksStat::orderBy('order')->get(),
                'partner_points' => DatabricksPartnerPoint::orderBy('order')->get(),
                'trust_signals' => DatabricksTrustSignal::orderBy('order')->get(),
            ]
        ]);
    }
}
