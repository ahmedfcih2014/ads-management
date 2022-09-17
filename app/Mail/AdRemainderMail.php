<?php

namespace App\Mail;

use App\Models\Advertiser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdRemainderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $advertiser;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Advertiser $advertiser)
    {
        $this->advertiser = $advertiser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@ads-management.com')
            ->markdown('emails.ads.remainder', [
                'ads' => $this->advertiser->tomorrowAds,
            ]);
    }
}
