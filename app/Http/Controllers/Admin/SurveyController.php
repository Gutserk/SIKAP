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
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->filled('status') && $request->status !== 'Semua Status' && $request->status !== 'Filter Status') {
            $statusMap = [
                'Aktif' => 'active',
                'Draft' => 'draft',
                'Ditutup' => 'closed'
            ];
            $dbStatus = $statusMap[$request->status] ?? 'draft';
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
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'status' => 'required|in:draft,active,closed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:essay,multiple_choice',
            'questions.*.is_required' => 'required|boolean',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*' => 'required|string',
        ], [
            'questions.required' => 'Survei harus memiliki minimal satu pertanyaan.',
            'questions.min' => 'Survei harus memiliki minimal satu pertanyaan.',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated) {
            $validated['admin_id'] = auth('admin')->id();

            $survey = Survey::create([
                'admin_id' => $validated['admin_id'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
                'start_date' => $validated['start_date'] ?? null,
                'end_date' => $validated['end_date'] ?? null,
            ]);

            if (!empty($validated['questions'])) {
                foreach ($validated['questions'] as $index => $qData) {
                    $question = $survey->questions()->create([
                        'question_text' => $qData['question_text'],
                        'question_type' => $qData['question_type'],
                        'is_required' => $qData['is_required'],
                        'order' => $index + 1,
                    ]);

                    if ($qData['question_type'] === 'multiple_choice' && !empty($qData['options'])) {
                        foreach ($qData['options'] as $optIndex => $optText) {
                            $question->options()->create([
                                'option_text' => $optText,
                                'order' => $optIndex + 1,
                            ]);
                        }
                    }
                }
            }

            Log::channel('audit')->info('Survey created', [
                'survey_id'    => $survey->id,
                'title'        => $survey->title,
                'admin_id'     => auth('admin')->id(),
                'admin_email'  => auth('admin')->user()->email,
                'ip'           => request()->ip(),
            ]);
        });

        return redirect()->route('admin.surveys.index')->with('success', 'Survei berhasil dibuat beserta pertanyaannya.');
    }

    public function show(Survey $survey)
    {
        $this->authorizeOwner($survey);

        $survey->loadCount(['questions', 'submissions']);
        $survey->load(['questions' => function($q) { $q->withCount('answers')->with('options'); }, 'submissions.answers']);

        $submissions = $survey->submissions()->with('respondent')->latest('submitted_at')->paginate(15);

        return view('admin.surveys.show', compact('survey', 'submissions'));
    }

    public function showSubmission(Survey $survey, \App\Models\Submission $submission)
    {
        $this->authorizeOwner($survey);

        if ($submission->survey_id !== $survey->id) {
            abort(404);
        }

        $submission->load(['respondent', 'answers.question.options', 'answers.option']);
        $survey->load(['questions' => function($q) { $q->orderBy('order'); }]);

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

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'status' => 'required|in:draft,active,closed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'nullable|exists:questions,id',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:essay,multiple_choice',
            'questions.*.is_required' => 'required|boolean',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*' => 'required|string',
        ], [
            'questions.required' => 'Survei harus memiliki minimal satu pertanyaan.',
            'questions.min' => 'Survei harus memiliki minimal satu pertanyaan.',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $survey) {
            $survey->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
                'start_date' => $validated['start_date'] ?? null,
                'end_date' => $validated['end_date'] ?? null,
            ]);

            $existingQuestionIds = $survey->questions()->pluck('id')->toArray();
            $submittedQuestionIds = [];

            if (!empty($validated['questions'])) {
                foreach ($validated['questions'] as $index => $qData) {
                    if (isset($qData['id']) && in_array($qData['id'], $existingQuestionIds)) {
                        $question = $survey->questions()->find($qData['id']);
                        $question->update([
                            'question_text' => $qData['question_text'],
                            'question_type' => $qData['question_type'],
                            'is_required' => $qData['is_required'],
                            'order' => $index + 1,
                        ]);
                        $submittedQuestionIds[] = $question->id;
                    } else {
                        $question = $survey->questions()->create([
                            'question_text' => $qData['question_text'],
                            'question_type' => $qData['question_type'],
                            'is_required' => $qData['is_required'],
                            'order' => $index + 1,
                        ]);
                        $submittedQuestionIds[] = $question->id;
                    }

                    $question->options()->delete();

                    if ($qData['question_type'] === 'multiple_choice' && !empty($qData['options'])) {
                        foreach ($qData['options'] as $optIndex => $optText) {
                            $question->options()->create([
                                'option_text' => $optText,
                                'order' => $optIndex + 1,
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
                'title'       => $survey->title,
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
            'title'       => $survey->title,
            'admin_id'    => auth('admin')->id(),
            'admin_email' => auth('admin')->user()->email,
            'ip'          => request()->ip(),
        ]);

        $survey->delete();
        return redirect()->route('admin.surveys.index')->with('success', 'Survei berhasil dihapus secara permanen.');
    }
}
