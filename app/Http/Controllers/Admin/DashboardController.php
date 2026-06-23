<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Submission;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $totalSurveys     = Survey::count();
        $totalRespondents = Submission::count();
        $activeSurveys    = Survey::where('status', 'aktif')->count();
        $closedSurveys    = Survey::where('status', 'ditutup')->count();

        $surveysThisMonth = Survey::whereMonth('created_at', $now->month)
                                  ->whereYear('created_at', $now->year)
                                  ->count();
        $surveysLastMonth = Survey::whereMonth('created_at', $now->copy()->subMonth()->month)
                                  ->whereYear('created_at', $now->copy()->subMonth()->year)
                                  ->count();

        $respondentsThisWeek = Submission::whereBetween('dikirim_pada', [
            $now->copy()->startOfWeek(),
            $now->copy()->endOfWeek(),
        ])->count();

        $recentSurveys = Survey::withCount('submissions as respondents_count')
                               ->latest()
                               ->take(5)
                               ->get();

        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $chartLabels[] = $day->translatedFormat('D, d M');
            $chartData[] = Submission::whereDate('dikirim_pada', $day->toDateString())->count();
        }

        return view('admin.dashboard', compact(
            'totalSurveys',
            'totalRespondents',
            'activeSurveys',
            'closedSurveys',
            'surveysThisMonth',
            'surveysLastMonth',
            'respondentsThisWeek',
            'recentSurveys',
            'chartLabels',
            'chartData',
        ));
    }
}
