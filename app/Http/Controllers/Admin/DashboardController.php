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

        // Stat Cards
        $totalSurveys    = Survey::count();
        $totalRespondents = Submission::count();
        $activeSurveys   = Survey::where('status', 'active')->count();
        $closedSurveys   = Survey::where('status', 'closed')->count();

        // Growth: surveys created this month vs last month
        $surveysThisMonth = Survey::whereMonth('created_at', $now->month)
                                  ->whereYear('created_at', $now->year)
                                  ->count();
        $surveysLastMonth = Survey::whereMonth('created_at', $now->copy()->subMonth()->month)
                                  ->whereYear('created_at', $now->copy()->subMonth()->year)
                                  ->count();

        // Growth: submissions this week
        $respondentsThisWeek = Submission::whereBetween('submitted_at', [
            $now->copy()->startOfWeek(),
            $now->copy()->endOfWeek(),
        ])->count();

        // Recent surveys (5 latest)
        $recentSurveys = Survey::withCount('submissions as respondents_count')
                               ->latest()
                               ->take(5)
                               ->get();

        // Chart: submission trend for last 7 days
        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $chartLabels[] = $day->translatedFormat('D, d M');
            $chartData[] = Submission::whereDate('submitted_at', $day->toDateString())->count();
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
