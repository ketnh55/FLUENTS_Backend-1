<?php

namespace App\Jobs;

use App\Mail\ActiveEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $link;
    protected $emailAddress;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($link, $emailAddress)
    {
        //
        $this->link = $link;
        $this->emailAddress = $emailAddress;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        Mail::to($this->emailAddress)->send(new ActiveEmail($this->link));
    }
}
