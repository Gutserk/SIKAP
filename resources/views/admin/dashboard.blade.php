@extends('layouts.admin')

@section('header_title', 'Dashboard')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Welcome Banner -->
    <div class="bg-primary text-on-primary p-6 rounded-2xl shadow-lg shadow-primary/20 flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold">Selamat datang kembali, {{ Auth::guard('admin')->user()->name ?? 'Admin' }}! </h2>
            <p class="text-primary-container mt-1">Berikut adalah ringkasan sistem survei Anda hari ini.</p>
        </div>
        <div class="hidden md:block">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                <line x1="12" y1="22.08" x2="12" y2="12"></line>
            </svg>
        </div>
    </div>


    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Stat Card 1: Total Survei -->
        <div class="card bg-surface-container-high border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="card-body p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-on-surface-variant mb-1">Total Survei</p>
                        <h3 class="text-3xl font-bold text-on-surface">{{ $totalSurveys }}</h3>
                    </div>
                    <div class="bg-primary/10 text-primary p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                </div>
                <div class="mt-2 text-sm flex items-center font-medium {{ $surveysThisMonth > 0 ? 'text-success' : 'text-on-surface-variant' }}">
                    @if($surveysThisMonth > 0)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        +{{ $surveysThisMonth }} bulan ini
                    @else
                        Tidak ada survei baru bulan ini
                    @endif
                </div>
            </div>
        </div>

        <!-- Stat Card 2: Total Responden -->
        <div class="card bg-surface-container-high border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="card-body p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-on-surface-variant mb-1">Total Responden</p>
                        <h3 class="text-3xl font-bold text-on-surface">{{ number_format($totalRespondents) }}</h3>
                    </div>
                    <div class="bg-secondary/10 text-secondary p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                </div>
                <div class="mt-2 text-sm flex items-center font-medium {{ $respondentsThisWeek > 0 ? 'text-success' : 'text-on-surface-variant' }}">
                    @if($respondentsThisWeek > 0)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        +{{ $respondentsThisWeek }} minggu ini
                    @else
                        Tidak ada responden baru minggu ini
                    @endif
                </div>
            </div>
        </div>

        <!-- Stat Card 3: Survei Aktif -->
        <div class="card bg-surface-container-high border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="card-body p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-on-surface-variant mb-1">Survei Aktif</p>
                        <h3 class="text-3xl font-bold text-on-surface">{{ $activeSurveys }}</h3>
                    </div>
                    <div class="bg-success/10 text-success p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-on-surface-variant flex items-center">
                    Sedang berjalan
                </div>
            </div>
        </div>

        <!-- Stat Card 4: Survei Ditutup -->
        <div class="card bg-surface-container-high border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="card-body p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-on-surface-variant mb-1">Survei Ditutup</p>
                        <h3 class="text-3xl font-bold text-on-surface">{{ $closedSurveys }}</h3>
                    </div>
                    <div class="bg-warning/10 text-warning p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-on-surface-variant flex items-center">
                    Selesai
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Grid: Chart + Recent Surveys -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Chart: Tren Respons 7 Hari Terakhir -->
        <div class="lg:col-span-2 bg-surface-container-high rounded-2xl shadow-sm border border-outline-variant overflow-hidden">
            <div class="p-5 lg:px-6 border-b border-outline-variant flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-on-surface">Tren Respons Survei</h3>
                    <p class="text-sm text-on-surface-variant mt-0.5">Jumlah responden masuk dalam 7 hari terakhir</p>
                </div>
                <div class="px-3 py-1 bg-primary/10 text-primary font-bold text-xs rounded-full border border-primary/20">
                    7 Hari Terakhir
                </div>
            </div>
            <div class="p-5 lg:p-6">
                <canvas id="responseTrendChart" height="120"></canvas>
            </div>
        </div>

        <!-- Recent Surveys Table -->
        <div class="bg-surface-container-high rounded-2xl shadow-sm border border-outline-variant overflow-hidden">
            <div class="p-5 border-b border-outline-variant flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-on-surface">Survei Terbaru</h3>
                    <p class="text-sm text-on-surface-variant mt-0.5">5 survei paling baru</p>
                </div>
                <a href="{{ route('admin.surveys.index') }}" class="btn btn-xs bg-surface hover:bg-surface-container border border-outline-variant text-on-surface rounded-lg no-animation shadow-none font-semibold">
                    Semua
                </a>
            </div>

            @if($recentSurveys->isEmpty())
                <div class="p-8 flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <p class="text-on-surface font-semibold text-sm">Belum ada survei</p>
                    <a href="{{ route('admin.surveys.create') }}" class="btn btn-primary btn-xs rounded-lg no-animation shadow-none mt-3">Buat Survei</a>
                </div>
            @else
                <div class="divide-y divide-outline-variant/40">
                    @foreach($recentSurveys as $survey)
                        <a href="{{ route('admin.surveys.show', $survey) }}" class="flex items-start gap-3 p-4 hover:bg-surface-container/50 transition-colors group">
                            <div class="w-9 h-9 shrink-0 bg-primary/10 text-primary rounded-lg flex items-center justify-center mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-on-surface text-sm truncate group-hover:text-primary transition-colors">{{ $survey->title }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    @php
                                        $s = match($survey->status) {
                                            'active' => ['label' => 'Aktif', 'class' => 'text-success'],
                                            'draft'  => ['label' => 'Draft', 'class' => 'text-on-surface-variant'],
                                            'closed' => ['label' => 'Ditutup', 'class' => 'text-warning'],
                                            default  => ['label' => $survey->status, 'class' => 'text-on-surface-variant'],
                                        };
                                    @endphp
                                    <span class="text-xs font-bold {{ $s['class'] }}">{{ $s['label'] }}</span>
                                    <span class="text-on-surface-variant/40 text-xs">•</span>
                                    <span class="text-xs text-on-surface-variant">{{ $survey->respondents_count }} responden</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

    </div>


</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = @json($chartLabels);
    const data   = @json($chartData);

    const ctx = document.getElementById('responseTrendChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(20, 184, 166, 0.25)');
    gradient.addColorStop(1, 'rgba(20, 184, 166, 0.00)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Responden',
                data: data,
                fill: true,
                backgroundColor: gradient,
                borderColor: '#14b8a6',
                borderWidth: 2.5,
                pointBackgroundColor: '#14b8a6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#94a3b8',
                    bodyColor: '#f0fdfa',
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} responden`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#0f766e', font: { size: 12 } },
                    border: { display: false },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(20, 184, 166, 0.1)', drawBorder: false },
                    ticks: {
                        color: '#0f766e',
                        font: { size: 12 },
                        stepSize: 1,
                        precision: 0,
                    },
                    border: { display: false },
                }
            }
        }
    });
});
</script>
@endpush
