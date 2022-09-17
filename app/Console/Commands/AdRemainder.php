<?php

namespace App\Console\Commands;

use App\Mail\AdRemainderMail;
use App\Models\Ad;
use App\Models\Advertiser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AdRemainder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ad:remainder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        This command for schedule a daily email at 08:00 PM
        that will be sent to advertisers
        who have ads the next day as a remainder
    ";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Advertiser::whereHas('ads', function ($adsQuery) {
            $adsQuery->where("start_date", now()->addDay()->format("Y-m-d"));
        })
        ->whereNotNull('email')
        ->with('tomorrowAds')
        ->lazy()
        ->each(function ($advertiser) {
            Mail::to($advertiser->email)->send(new AdRemainderMail($advertiser));
        });
        return 0;
    }
}
