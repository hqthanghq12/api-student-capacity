<?php

namespace App\Jobs;

use App\Mail\ImportAccountMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotificationChangePassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $password;
    public function __construct(
        $email, $password
    )
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(
            $this->email
        )->send(new ImportAccountMail(
            $this->email, $this->password, 'Notification Change Password'
        ));
        
    }
}
