<?php

namespace App\Console\Commands;

use App\Models\Survey;
use Illuminate\Console\Command;

class CloseExpiredSurveys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:close-expired-surveys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set status to ditutup for active surveys whose tanggal_selesai has passed';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $count = Survey::where('status', 'aktif')
            ->whereNotNull('tanggal_selesai')
            ->whereDate('tanggal_selesai', '<', now()->startOfDay())
            ->update(['status' => 'ditutup']);

        $this->info("{$count} survei ditutup otomatis karena sudah melewati tanggal selesai.");
    }
}
