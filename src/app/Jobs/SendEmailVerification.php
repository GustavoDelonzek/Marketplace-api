<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailVerification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    public function onQueue($queue)
    {
        return 'emails';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!$this->user->hasVerifiedEmail() && $this->user instanceof MustVerifyEmail) {
            $this->user->sendEmailVerificationNotification();
        }
    }
}
