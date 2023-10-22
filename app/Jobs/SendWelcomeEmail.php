<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;

    public $tries = 3;
    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = $this->user->email;
        $name = $this->user->name;
        $subject = 'Chào mừng bạn ' . $name . ' đến với TMT Viet Nam';
        $content = '<p> Chào:' . $name . ' </p>';
        $content .= '<p> Chúc mừng đã đăng ký thành công tài khoản </p>';
        Mail::raw($content, function ($message) use ($email, $subject) {

            $message->to($email);

            $message->subject($subject);
        });
    }
}
