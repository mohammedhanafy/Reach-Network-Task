<?php

namespace App\Console\Commands;

use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Jobs\SendMailReminderJob;

class DailyReminderAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyreminder:ads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ads = Ad::with('user')->where('start_date', Carbon::now()->addDays(1)->format('Y-m-d'))->get();
        foreach($ads as $ad) {
            SendMailReminderJob::dispatch($ad->user->email);
        }
    }
}
