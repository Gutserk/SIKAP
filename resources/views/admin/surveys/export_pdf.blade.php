<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Survei - {{ $survey->title }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.5; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 20px; margin-bottom: 30px; }
        .title { font-size: 24px; font-weight: bold; margin: 0; text-transform: uppercase; }
        .subtitle { font-size: 16px; margin-top: 5px; color: #666; }
        .info-table { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .info-table th { text-align: left; width: 150px; padding: 5px 0; color: #555; }
        .info-table td { padding: 5px 0; font-weight: bold; }
        .section-title { font-size: 18px; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px; }
        .question-block { margin-bottom: 20px; page-break-inside: avoid; }
        .question-text { font-weight: bold; margin-bottom: 10px; font-size: 15px; }
        .answers-list { margin: 0; padding-left: 20px; }
        .answers-list li { margin-bottom: 5px; }
        .stats-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .stats-table th, .stats-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .stats-table th { background-color: #f5f5f5; }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="title">Laporan Hasil Survei</h1>
        <p class="subtitle">Aplikasi Survei Diskominfo Kota Batam</p>
    </div>

    <table class="info-table">
        <tr>
            <th>Judul Survei</th>
            <td>: {{ $survey->title }}</td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>: {{ $survey->description ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>: {{ ucfirst($survey->status) }}</td>
        </tr>
        <tr>
            <th>Total Responden</th>
            <td>: {{ $survey->submissions->count() }} Orang</td>
        </tr>
        <tr>
            <th>Periode Pelaksanaan</th>
            <td>: {{ $survey->start_date ? \Carbon\Carbon::parse($survey->start_date)->format('d M Y') : '-' }} s/d {{ $survey->end_date ? \Carbon\Carbon::parse($survey->end_date)->format('d M Y') : '-' }}</td>
        </tr>
    </table>

    <h2 class="section-title">Hasil Jawaban Responden</h2>

    @if($survey->questions->count() > 0)
        @foreach($survey->questions()->orderBy('order')->get() as $index => $question)
            <div class="question-block">
                <div class="question-text">{{ $index + 1 }}. {{ $question->question_text }}</div>
                
                @if($question->question_type == 'multiple_choice')
                    @php
                        // Calculate stats
                        $optionsCount = [];
                        foreach($question->options as $opt) {
                            $optionsCount[$opt->id] = ['text' => $opt->option_text, 'count' => 0];
                        }
                        
                        $totalAnswers = 0;
                        foreach($survey->submissions as $submission) {
                            $ans = $submission->answers->where('question_id', $question->id)->first();
                            if($ans && $ans->option_id && isset($optionsCount[$ans->option_id])) {
                                $optionsCount[$ans->option_id]['count']++;
                                $totalAnswers++;
                            }
                        }
                    @endphp
                    
                    <table class="stats-table">
                        <thead>
                            <tr>
                                <th>Opsi Jawaban</th>
                                <th width="100">Jumlah</th>
                                <th width="100">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($optionsCount as $optStats)
                                <tr>
                                    <td>{{ $optStats['text'] }}</td>
                                    <td>{{ $optStats['count'] }}</td>
                                    <td>{{ $totalAnswers > 0 ? round(($optStats['count'] / $totalAnswers) * 100, 1) : 0 }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <ul class="answers-list">
                        @php $hasAnswers = false; @endphp
                        @foreach($survey->submissions as $submission)
                            @php
                                $ans = $submission->answers->where('question_id', $question->id)->first();
                            @endphp
                            @if($ans && !empty($ans->answer_text))
                                <li>{{ $ans->answer_text }}</li>
                                @php $hasAnswers = true; @endphp
                            @endif
                        @endforeach
                        
                        @if(!$hasAnswers)
                            <li><em>Belum ada jawaban esai.</em></li>
                        @endif
                    </ul>
                @endif
            </div>
        @endforeach
    @else
        <p>Belum ada pertanyaan pada survei ini.</p>
    @endif

</body>
</html>
