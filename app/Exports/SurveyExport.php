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
        $this->questions = $survey->questions()->orderBy('urutan')->get();
    }

    public function collection()
    {
        return Survey::findOrFail($this->surveyId)
            ->submissions()
            ->with(['respondent', 'answers.option', 'answers.sentimentResult'])
            ->get();
    }

    public function headings(): array
    {
        $headers = [
            'No',
            'Waktu Pengisian',
            'Nama Responden',
            'Email',
            'Jenis Kelamin',
            'Usia',
            'Pendidikan',
        ];

        foreach ($this->questions as $question) {
            $headers[] = $question->teks_pertanyaan;

            if ($question->tipe_pertanyaan === 'esai') {
                $headers[] = $question->teks_pertanyaan . ' - Sentimen';
                $headers[] = $question->teks_pertanyaan . ' - Confidence';
            }
        }

        return $headers;
    }

    public function map($submission): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        $row = [
            $rowNumber,
            $submission->dikirim_pada
                ? \Carbon\Carbon::parse($submission->dikirim_pada)->format('Y-m-d H:i:s')
                : '-',
            $submission->respondent->nama ?? '-',
            $submission->respondent->email ?? '-',
            $submission->respondent->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            $submission->respondent->usia ?? '-',
            $submission->respondent->pendidikan ?? '-',
        ];

        foreach ($this->questions as $question) {
            $answer = $submission->answers->where('pertanyaan_id', $question->id)->first();

            if ($answer) {
                if ($question->tipe_pertanyaan == 'pilihan_ganda' && $answer->pilihan_id) {
                    $row[] = $answer->option->teks_pilihan ?? '-';
                } else {
                    $row[] = $answer->teks_jawaban ?? '-';
                }
            } else {
                $row[] = '-';
            }

            if ($question->tipe_pertanyaan === 'esai') {
                if ($answer && $answer->sentimentResult) {
                    $row[] = ucfirst($answer->sentimentResult->sentimen);
                    $row[] = round($answer->sentimentResult->skor * 100, 1) . '%';
                } else {
                    $row[] = '-';
                    $row[] = '-';
                }
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
