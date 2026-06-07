<?php

namespace App\Exports;

use App\Models\Survey;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SurveyExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $surveyId;
    protected $questions;

    public function __construct(int $surveyId)
    {
        $this->surveyId = $surveyId;
        $survey = Survey::with('questions')->findOrFail($surveyId);
        $this->questions = $survey->questions()->orderBy('order')->get();
    }

    public function collection()
    {
        return Survey::findOrFail($this->surveyId)
            ->submissions()
            ->with(['respondent', 'answers'])
            ->get();
    }

    public function headings(): array
    {
        $headers = [
            'No',
            'Waktu Pengisian',
        ];

        foreach ($this->questions as $question) {
            $headers[] = $question->question_text;
        }

        return $headers;
    }

    public function map($submission): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        $row = [
            $rowNumber,
            $submission->submitted_at ? \Carbon\Carbon::parse($submission->submitted_at)->format('Y-m-d H:i:s') : '-',
        ];

        // Map answers to the correct columns based on questions
        foreach ($this->questions as $question) {
            $answer = $submission->answers->where('question_id', $question->id)->first();
            
            if ($answer) {
                if ($question->question_type == 'multiple_choice' && $answer->option_id) {
                    $row[] = $answer->option->option_text ?? '-';
                } else {
                    $row[] = $answer->answer_text ?? '-';
                }
            } else {
                $row[] = '-';
            }
        }

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
