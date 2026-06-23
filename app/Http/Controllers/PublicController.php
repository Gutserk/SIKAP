<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Respondent;
use App\Models\Submission;
use App\Models\Answer;
use App\Models\SentimentResult;
use App\Services\SentimentService;

class PublicController extends Controller
{
    public function __construct(private SentimentService $sentimentService)
    {
    }

    public function home()
    {
        $activeSurveys = Survey::withCount('questions')
            ->where('status', 'aktif')
            ->latest()
            ->take(6)
            ->get();

        return view('public.home', compact('activeSurveys'));
    }

    public function surveys()
    {
        $surveys = Survey::withCount('questions')
            ->where('status', 'aktif')
            ->latest()
            ->get();

        return view('public.surveys.index', compact('surveys'));
    }

    public function show($id)
    {
        $survey = Survey::with(['questions' => function($q) {
            $q->orderBy('urutan')->with('options');
        }])->where('status', 'aktif')->findOrFail($id);

        return view('public.surveys.show', compact('survey'));
    }

    public function submit(Request $request, $id)
    {
        $survey = Survey::with(['questions.options'])->where('status', 'aktif')->findOrFail($id);

        $today = now()->startOfDay();
        if ($survey->tanggal_mulai && $today->lt($survey->tanggal_mulai)) {
            return back()->with('error', 'Survei ini belum dibuka untuk pengisian.')->withInput();
        }
        if ($survey->tanggal_selesai && $today->gt($survey->tanggal_selesai)) {
            return back()->with('error', 'Survei ini sudah berakhir dan tidak dapat diisi lagi.')->withInput();
        }

        $request->validate([
            'name'      => 'required|string|max:100',
            'gender'    => 'required|in:L,P',
            'age'       => 'required|integer|min:1|max:120',
            'education' => 'required|in:SD,SMP,SMA,D3,S1,S2,S3',
            'email'     => 'required|email|max:150',
        ]);

        $answerRules = [];
        foreach ($survey->questions as $question) {
            if ($question->wajib_diisi) {
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

        $respondent = Respondent::firstOrCreate(
            ['email' => $request->email],
            [
                'nama'          => $request->name,
                'jenis_kelamin' => $request->gender,
                'usia'          => $request->age,
                'pendidikan'    => $request->education,
                'dibuat_pada'   => now(),
            ]
        );

        if (Submission::where('survei_id', $survey->id)->where('responden_id', $respondent->id)->exists()) {
            return back()->with('error', 'Anda sudah pernah mengisi survei ini sebelumnya.')->withInput();
        }

        $submission = Submission::create([
            'survei_id'    => $survey->id,
            'responden_id' => $respondent->id,
            'dikirim_pada' => now(),
        ]);

        foreach ($survey->questions as $question) {
            $answerValue = $request->input('answers.' . $question->id);
            if ($answerValue !== null && $answerValue !== '') {
                $answerData = [
                    'pengisian_id'  => $submission->id,
                    'pertanyaan_id' => $question->id,
                    'teks_jawaban'  => is_array($answerValue) ? implode(', ', $answerValue) : $answerValue,
                ];

                if ($question->tipe_pertanyaan === 'pilihan_ganda') {
                    $option = $question->options->firstWhere('teks_pilihan', $answerValue);
                    if ($option) {
                        $answerData['pilihan_id'] = $option->id;
                    }
                }

                $answer = Answer::create($answerData);

                if ($question->tipe_pertanyaan === 'esai' && !is_array($answerValue)) {
                    $result = $this->sentimentService->analyze($answerValue);
                    if ($result !== null) {
                        SentimentResult::create([
                            'jawaban_id'      => $answer->id,
                            'sentimen'        => $result['sentimen'],
                            'skor'            => $result['skor'],
                            'dianalisis_pada' => now(),
                        ]);
                    }
                }
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
