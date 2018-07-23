<?php

namespace App\Jobs;

use App\Mail\EmailConfirmationMailer;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendEmailConfirmationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    private $user_id;


    /**
     * @param int   $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id              = $user_id;
    }


    public function handle()
    {
        $user                           = User::find($this->user_id);
        Mail::to($user)->send(new EmailConfirmationMailer($user->createConfirmationToken()));
    }
}
