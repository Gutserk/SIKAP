<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Respondent;
use App\Models\Submission;
use App\Models\Answer;

class PublicController extends Controller
{
    public function home()
    {
        $activeSurveys = Survey::withCount('questions')
            ->where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        return view('public.home', compact('activeSurveys'));
    }

    public function surveys()
    {
        $surveys = Survey::withCount('questions')
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('public.surveys.index', compact('surveys'));
    }

    public function show($id)
    {
        $survey = Survey::with(['questions' => function($q) {
            $q->orderBy('order')->with('options');
        }])->where('status', 'active')->findOrFail($id);

        return view('public.surveys.show', compact('survey'));
    }

    public function submit(Request $request, $id)
    {
        $survey = Survey::with(['questions.options'])->where('status', 'active')->findOrFail($id);

        // Cek rentang tanggal survei
        $today = now()->startOfDay();
        if ($survey->start_date && $today->lt($survey->start_date)) {
            return back()->with('error', 'Survei ini belum dibuka untuk pengisian.')->withInput();
        }
        if ($survey->end_date && $today->gt($survey->end_date)) {
            return back()->with('error', 'Survei ini sudah berakhir dan tidak dapat diisi lagi.')->withInput();
        }

        // Validasi identitas responden
        $request->validate([
            'name'        => 'required|string|max:100',
            'gender'      => 'required|in:M,F',
            'age'         => 'required|integer|min:1|max:120',
            'education'   => 'required|in:SD,SMP,SMA,D3,S1,S2,S3',
            'email'       => 'required|email|max:150',
        ]);

        // Validasi pertanyaan wajib
        $answerRules = [];
        foreach ($survey->questions as $question) {
            if ($question->is_required) {
                $answerRules['answers.' . $question->id] = 'required';
            }
        }
        if (!empty($answerRules)) {
            $messages = array_fill_keys(
                array_map(fn($k) => $k . '.required', array_keys($answerRules)),
                'Pertanyaan ini wajib diisi.'
            );
            $request->validate($answerRules, $messages);
        }

        // Cari atau buat respondent berdasarkan email (hindari duplikat)
        $respondent = Respondent::firstOrCreate(
            ['email' => $request->email],
            [
                'name'       => $request->name,
                'gender'     => $request->gender,
                'age'        => $request->age,
                'education'  => $request->education,
                'created_at' => now(),
            ]
        );

        // Cegah submit survei yang sama dua kali
        if (Submission::where('survey_id', $survey->id)->where('respondent_id', $respondent->id)->exists()) {
            return back()->with('error', 'Anda sudah pernah mengisi survei ini sebelumnya.')->withInput();
        }

        // Buat submission
        $submission = Submission::create([
            'survey_id'      => $survey->id,
            'respondent_id'  => $respondent->id,
            'submitted_at'   => now(),
        ]);

        // Simpan jawaban
        foreach ($survey->questions as $question) {
            $answerValue = $request->input('answers.' . $question->id);
            if ($answerValue !== null && $answerValue !== '') {
                $answerData = [
                    'submission_id' => $submission->id,
                    'question_id'   => $question->id,
                    'answer_text'   => is_array($answerValue) ? implode(', ', $answerValue) : $answerValue,
                ];

                // Simpan option_id untuk pilihan ganda agar analitik berfungsi
                if ($question->question_type === 'multiple_choice') {
                    $option = $question->options->firstWhere('option_text', $answerValue);
                    if ($option) {
                        $answerData['option_id'] = $option->id;
                    }
                }

                Answer::create($answerData);
            }
        }

        return redirect()->route('surveys.thanks')->with('success', 'Terima kasih! Jawaban Anda telah berhasil dikirim.');
    }

    public function thanks()
    {
        if (!session('success')) {
            return redirect()->route('surveys.index');
        }
        return view('public.surveys.thanks');
    }
}
