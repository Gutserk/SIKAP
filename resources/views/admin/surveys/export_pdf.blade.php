<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Survei - {{ $survey->judul }}</title>
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
            <td>: {{ $survey->judul }}</td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>: {{ $survey->deskripsi ?? '-' }}</td>
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
            <td>: {{ $survey->tanggal_mulai ? \Carbon\Carbon::parse($survey->tanggal_mulai)->format('d M Y') : '-' }} s/d {{ $survey->tanggal_selesai ? \Carbon\Carbon::parse($survey->tanggal_selesai)->format('d M Y') : '-' }}</td>
        </tr>
    </table>

    @if($survey->submissions->count() > 0)
        @php
            $respondents = $survey->submissions->pluck('respondent')->filter();
            $totalRespondents = $respondents->count();

            $genderCount = $respondents->groupBy('jenis_kelamin')->map->count();
            $educationCount = $respondents->groupBy('pendidikan')->map->count()->sortDesc();
        @endphp
        <h2 class="section-title">Profil Responden</h2>
        <table class="stats-table">
            <thead>
                <tr>
                    <th>Jenis Kelamin</th>
                    <th width="100">Jumlah</th>
                    <th width="100">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Laki-laki</td>
                    <td>{{ $genderCount['L'] ?? 0 }}</td>
                    <td>{{ $totalRespondents > 0 ? round((($genderCount['L'] ?? 0) / $totalRespondents) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Perempuan</td>
                    <td>{{ $genderCount['P'] ?? 0 }}</td>
                    <td>{{ $totalRespondents > 0 ? round((($genderCount['P'] ?? 0) / $totalRespondents) * 100, 1) : 0 }}%</td>
                </tr>
            </tbody>
        </table>

        <table class="stats-table">
            <thead>
                <tr>
                    <th>Tingkat Pendidikan</th>
                    <th width="100">Jumlah</th>
                    <th width="100">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($educationCount as $education => $count)
                    <tr>
                        <td>{{ $education }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ $totalRespondents > 0 ? round(($count / $totalRespondents) * 100, 1) : 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2 class="section-title">Hasil Jawaban Responden</h2>

    @if($survey->questions->count() > 0)
        @foreach($survey->questions()->orderBy('urutan')->get() as $index => $question)
            <div class="question-block">
                <div class="question-text">{{ $index + 1 }}. {{ $question->teks_pertanyaan }}</div>

                @if($question->tipe_pertanyaan == 'pilihan_ganda')
                    @php
                        $optionsCount = [];
                        foreach($question->options as $opt) {
                            $optionsCount[$opt->id] = ['text' => $opt->teks_pilihan, 'count' => 0];
                        }

                        $totalAnswers = 0;
                        foreach($survey->submissions as $submission) {
                            $ans = $submission->answers->where('pertanyaan_id', $question->id)->first();
                            if($ans && $ans->pilihan_id && isset($optionsCount[$ans->pilihan_id])) {
                                $optionsCount[$ans->pilihan_id]['count']++;
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
                @elseif($question->tipe_pertanyaan == 'skala_linear')
                    @php
                        $sMin = $question->skala_min ?? 1;
                        $sMax = $question->skala_max ?? 10;
                        $scaleCount = [];
                        for ($i = $sMin; $i <= $sMax; $i++) {
                            $scaleCount[$i] = 0;
                        }

                        $numericAnswers = [];
                        foreach ($survey->submissions as $submission) {
                            $ans = $submission->answers->where('pertanyaan_id', $question->id)->first();
                            if ($ans && is_numeric($ans->teks_jawaban) && isset($scaleCount[(int) $ans->teks_jawaban])) {
                                $scaleCount[(int) $ans->teks_jawaban]++;
                                $numericAnswers[] = (int) $ans->teks_jawaban;
                            }
                        }

                        $avgScore = count($numericAnswers) > 0 ? round(array_sum($numericAnswers) / count($numericAnswers), 2) : null;
                        $totalScaleAnswers = count($numericAnswers);
                    @endphp

                    @if($avgScore !== null)
                        <p><strong>Rata-rata Skor:</strong> {{ $avgScore }} (dari skala {{ $sMin }}–{{ $sMax }})</p>
                    @endif

                    <table class="stats-table">
                        <thead>
                            <tr>
                                <th>Skor</th>
                                <th width="100">Jumlah</th>
                                <th width="100">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($scaleCount as $score => $count)
                                <tr>
                                    <td>{{ $score }}</td>
                                    <td>{{ $count }}</td>
                                    <td>{{ $totalScaleAnswers > 0 ? round(($count / $totalScaleAnswers) * 100, 1) : 0 }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    @php
                        $sentimentCounts = ['positif' => 0, 'netral' => 0, 'negatif' => 0];
                        $totalSentiment = 0;
                    @endphp
                    <ul class="answers-list">
                        @php $hasAnswers = false; @endphp
                        @foreach($survey->submissions as $submission)
                            @php
                                $ans = $submission->answers->where('pertanyaan_id', $question->id)->first();
                            @endphp
                            @if($ans && !empty($ans->teks_jawaban))
                                <li>
                                    {{ $ans->teks_jawaban }}
                                    @if($ans->sentimentResult)
                                        <em>({{ ucfirst($ans->sentimentResult->sentimen) }}, {{ round($ans->sentimentResult->skor * 100, 1) }}%)</em>
                                        @php
                                            $sentimentCounts[$ans->sentimentResult->sentimen]++;
                                            $totalSentiment++;
                                        @endphp
                                    @endif
                                </li>
                                @php $hasAnswers = true; @endphp
                            @endif
                        @endforeach

                        @if(!$hasAnswers)
                            <li><em>Belum ada jawaban esai.</em></li>
                        @endif
                    </ul>

                    @if($totalSentiment > 0)
                        <table class="stats-table">
                            <thead>
                                <tr>
                                    <th>Sentimen</th>
                                    <th width="100">Jumlah</th>
                                    <th width="100">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Positif</td>
                                    <td>{{ $sentimentCounts['positif'] }}</td>
                                    <td>{{ round($sentimentCounts['positif'] / $totalSentiment * 100, 1) }}%</td>
                                </tr>
                                <tr>
                                    <td>Netral</td>
                                    <td>{{ $sentimentCounts['netral'] }}</td>
                                    <td>{{ round($sentimentCounts['netral'] / $totalSentiment * 100, 1) }}%</td>
                                </tr>
                                <tr>
                                    <td>Negatif</td>
                                    <td>{{ $sentimentCounts['negatif'] }}</td>
                                    <td>{{ round($sentimentCounts['negatif'] / $totalSentiment * 100, 1) }}%</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                @endif
            </div>
        @endforeach
    @else
        <p>Belum ada pertanyaan pada survei ini.</p>
    @endif

</body>
</html>
