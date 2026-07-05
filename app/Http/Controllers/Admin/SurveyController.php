<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Survey;

class SurveyController extends Controller
{
    private function authorizeOwner(Survey $survey): void
    {
        if ($survey->admin_id !== auth('admin')->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengelola survei ini.');
        }
    }

    public function index(Request $request)
    {
        $query = Survey::withCount('submissions as respondents_count');

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        if ($request->filled('status') && $request->status !== 'Semua Status' && $request->status !== 'Filter Status') {
            $statusMap = [
                'Aktif'   => 'aktif',
                'Draft'   => 'draf',
                'Ditutup' => 'ditutup',
            ];
            $dbStatus = $statusMap[$request->status] ?? 'draf';
            $query->where('status', $dbStatus);
        }
        $surveys = $query->latest()->paginate(12)->withQueryString();

        return view('admin.surveys.index', compact('surveys'));
    }

    public function create()
    {
        return view('admin.surveys.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'                        => 'required|string|max:200',
            'description'                  => 'required|string',
            'status'                       => 'required|in:draf,aktif,ditutup',
            'start_date'                   => 'nullable|date|after_or_equal:today',
            'end_date'                     => 'nullable|date|after_or_equal:start_date',
            'questions'                    => 'required|array|min:1',
            'questions.*.question_text'    => 'required|string',
            'questions.*.question_type'    => 'required|in:esai,pilihan_ganda,skala_linear',
            'questions.*.is_required'      => 'required|boolean',
            'questions.*.options'          => 'nullable|array',
            'questions.*.options.*'        => 'required|string',
            'questions.*.scale_min'        => 'nullable|integer|min:0|max:10',
            'questions.*.scale_max'        => 'nullable|integer|min:1|max:10',
            'questions.*.scale_min_label'  => 'nullable|string|max:100',
            'questions.*.scale_max_label'  => 'nullable|string|max:100',
        ], [
            'questions.required'        => 'Survei harus memiliki minimal satu pertanyaan.',
            'questions.min'             => 'Survei harus memiliki minimal satu pertanyaan.',
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini.',
            'end_date.after_or_equal'   => 'Tanggal berakhir harus setelah atau sama dengan tanggal mulai.',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated) {
            $validated['admin_id'] = auth('admin')->id();

            $survey = Survey::create([
                'admin_id'       => $validated['admin_id'],
                'judul'          => $validated['title'],
                'deskripsi'      => $validated['description'] ?? null,
                'status'         => $validated['status'],
                'tanggal_mulai'  => $validated['start_date'] ?? null,
                'tanggal_selesai' => $validated['end_date'] ?? null,
            ]);

            if (!empty($validated['questions'])) {
                foreach ($validated['questions'] as $index => $qData) {
                    $isScale = $qData['question_type'] === 'skala_linear';
                    $question = $survey->questions()->create([
                        'teks_pertanyaan' => $qData['question_text'],
                        'tipe_pertanyaan' => $qData['question_type'],
                        'wajib_diisi'     => $qData['is_required'],
                        'urutan'          => $index + 1,
                        'skala_min'       => $isScale ? ($qData['scale_min'] ?? 1) : null,
                        'skala_max'       => $isScale ? ($qData['scale_max'] ?? 5) : null,
                        'skala_min_label' => $isScale ? ($qData['scale_min_label'] ?? null) : null,
                        'skala_max_label' => $isScale ? ($qData['scale_max_label'] ?? null) : null,
                    ]);

                    if ($qData['question_type'] === 'pilihan_ganda' && !empty($qData['options'])) {
                        foreach ($qData['options'] as $optIndex => $optText) {
                            $question->options()->create([
                                'teks_pilihan' => $optText,
                                'urutan'       => $optIndex + 1,
                            ]);
                        }
                    }
                }
            }

            Log::channel('audit')->info('Survey created', [
                'survey_id'   => $survey->id,
                'judul'       => $survey->judul,
                'admin_id'    => auth('admin')->id(),
                'admin_email' => auth('admin')->user()->email,
                'ip'          => request()->ip(),
            ]);
        });

        return redirect()->route('admin.surveys.index')->with('success', 'Survei berhasil dibuat beserta pertanyaannya.');
    }

    public function show(Survey $survey)
    {
        $this->authorizeOwner($survey);

        $survey->loadCount(['questions', 'submissions']);
        $survey->load(['questions' => function($q) { $q->withCount('answers')->with('options', 'answers.sentimentResult'); }, 'submissions.answers']);

        $submissions = $survey->submissions()->with('respondent')->latest('dikirim_pada')->paginate(15);

        return view('admin.surveys.show', compact('survey', 'submissions'));
    }

    public function showSubmission(Survey $survey, \App\Models\Submission $submission)
    {
        $this->authorizeOwner($survey);

        if ($submission->survei_id !== $survey->id) {
            abort(404);
        }

        $submission->load(['respondent', 'answers.question.options', 'answers.option', 'answers.sentimentResult']);
        $survey->load(['questions' => function($q) { $q->orderBy('urutan'); }]);

        return view('admin.surveys.submissions.show', compact('survey', 'submission'));
    }

    public function edit(Survey $survey)
    {
        $this->authorizeOwner($survey);

        return view('admin.surveys.edit', compact('survey'));
    }

    public function update(Request $request, Survey $survey)
    {
        $this->authorizeOwner($survey);

        $surveyAlreadyStarted = $survey->tanggal_mulai && $survey->tanggal_mulai->lt(now()->startOfDay());

        $startDateRule = ['nullable', 'date'];
        if (!$surveyAlreadyStarted) {
            $startDateRule[] = 'after_or_equal:today';
        }

        $validated = $request->validate([
            'title'                        => 'required|string|max:200',
            'description'                  => 'required|string',
            'status'                       => 'required|in:draf,aktif,ditutup',
            'start_date'                   => $startDateRule,
            'end_date'                     => 'nullable|date|after_or_equal:start_date',
            'questions'                    => 'required|array|min:1',
            'questions.*.id'               => 'nullable|exists:pertanyaan,id',
            'questions.*.question_text'    => 'required|string',
            'questions.*.question_type'    => 'required|in:esai,pilihan_ganda,skala_linear',
            'questions.*.is_required'      => 'required|boolean',
            'questions.*.options'          => 'nullable|array',
            'questions.*.options.*'        => 'required|string',
            'questions.*.scale_min'        => 'nullable|integer|min:0|max:10',
            'questions.*.scale_max'        => 'nullable|integer|min:1|max:10',
            'questions.*.scale_min_label'  => 'nullable|string|max:100',
            'questions.*.scale_max_label'  => 'nullable|string|max:100',
        ], [
            'questions.required'        => 'Survei harus memiliki minimal satu pertanyaan.',
            'questions.min'             => 'Survei harus memiliki minimal satu pertanyaan.',
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini.',
            'end_date.after_or_equal'   => 'Tanggal berakhir harus setelah atau sama dengan tanggal mulai.',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $survey) {
            $survey->update([
                'judul'          => $validated['title'],
                'deskripsi'      => $validated['description'] ?? null,
                'status'         => $validated['status'],
                'tanggal_mulai'  => $validated['start_date'] ?? null,
                'tanggal_selesai' => $validated['end_date'] ?? null,
            ]);

            $existingQuestionIds = $survey->questions()->pluck('id')->toArray();
            $submittedQuestionIds = [];

            if (!empty($validated['questions'])) {
                foreach ($validated['questions'] as $index => $qData) {
                    $isScale = $qData['question_type'] === 'skala_linear';
                    $scaleFields = [
                        'skala_min'       => $isScale ? ($qData['scale_min'] ?? 1) : null,
                        'skala_max'       => $isScale ? ($qData['scale_max'] ?? 5) : null,
                        'skala_min_label' => $isScale ? ($qData['scale_min_label'] ?? null) : null,
                        'skala_max_label' => $isScale ? ($qData['scale_max_label'] ?? null) : null,
                    ];

                    if (isset($qData['id']) && in_array($qData['id'], $existingQuestionIds)) {
                        $question = $survey->questions()->find($qData['id']);
                        $question->update(array_merge([
                            'teks_pertanyaan' => $qData['question_text'],
                            'tipe_pertanyaan' => $qData['question_type'],
                            'wajib_diisi'     => $qData['is_required'],
                            'urutan'          => $index + 1,
                        ], $scaleFields));
                        $submittedQuestionIds[] = $question->id;
                    } else {
                        $question = $survey->questions()->create(array_merge([
                            'teks_pertanyaan' => $qData['question_text'],
                            'tipe_pertanyaan' => $qData['question_type'],
                            'wajib_diisi'     => $qData['is_required'],
                            'urutan'          => $index + 1,
                        ], $scaleFields));
                        $submittedQuestionIds[] = $question->id;
                    }

                    $question->options()->delete();

                    if ($qData['question_type'] === 'pilihan_ganda' && !empty($qData['options'])) {
                        foreach ($qData['options'] as $optIndex => $optText) {
                            $question->options()->create([
                                'teks_pilihan' => $optText,
                                'urutan'       => $optIndex + 1,
                            ]);
                        }
                    }
                }
            }

            $toDelete = array_diff($existingQuestionIds, $submittedQuestionIds);
            if (!empty($toDelete)) {
                $survey->questions()->whereIn('id', $toDelete)->delete();
            }

            Log::channel('audit')->info('Survey updated', [
                'survey_id'   => $survey->id,
                'judul'       => $survey->judul,
                'admin_id'    => auth('admin')->id(),
                'admin_email' => auth('admin')->user()->email,
                'ip'          => request()->ip(),
            ]);
        });

        return redirect()->route('admin.surveys.show', $survey)->with('success', 'Survei berhasil diperbarui.');
    }

    public function destroy(Survey $survey)
    {
        $this->authorizeOwner($survey);

        Log::channel('audit')->warning('Survey deleted', [
            'survey_id'   => $survey->id,
            'judul'       => $survey->judul,
            'admin_id'    => auth('admin')->id(),
            'admin_email' => auth('admin')->user()->email,
            'ip'          => request()->ip(),
        ]);

        $survey->delete();
        return redirect()->route('admin.surveys.index')->with('success', 'Survei berhasil dihapus secara permanen.');
    }
}
