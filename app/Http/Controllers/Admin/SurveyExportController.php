<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Exports\SurveyExport;
use Maatwebsite\Excel\Facades\Excel;

class SurveyExportController extends Controller
{
    private function authorizeOwner(Survey $survey): void
    {
        if ($survey->admin_id !== auth('admin')->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengekspor survei ini.');
        }
    }

    public function exportExcel(Survey $survey)
    {
        $this->authorizeOwner($survey);

        Log::channel('audit')->info('Survey exported as Excel', [
            'survey_id'   => $survey->id,
            'title'       => $survey->title,
            'admin_id'    => auth('admin')->id(),
            'admin_email' => auth('admin')->user()->email,
            'ip'          => request()->ip(),
        ]);

        return Excel::download(new SurveyExport($survey->id), 'hasil_survei_' . $survey->id . '.xlsx');
    }

    public function exportPdf(Survey $survey)
    {
        $this->authorizeOwner($survey);

        Log::channel('audit')->info('Survey exported as PDF', [
            'survey_id'   => $survey->id,
            'title'       => $survey->title,
            'admin_id'    => auth('admin')->id(),
            'admin_email' => auth('admin')->user()->email,
            'ip'          => request()->ip(),
        ]);

        $survey->load(['questions.options', 'submissions.answers']);

        $pdf = Pdf::loadView('admin.surveys.export_pdf', compact('survey'));

        return $pdf->download('laporan_survei_' . $survey->id . '.pdf');
    }
}
