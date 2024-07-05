<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $resetUrl = url('/fpassword?token=' . $this->token . '&email=' . urlencode($this->email));
    
        return $this->subject('Reset Password Notification')
                    ->from('example@example.com', config('app.name'))
                    ->to($this->email)
                    ->html(
                        "<p>You are receiving this email because we received a password reset request for your account.</p>" .
                        "<p>Click the link below to reset your password:</p>" .
                        "<p><a href='{$resetUrl}'>Reset Password</a></p>" .
                        "<p>If the link above doesn't work, use the token below to reset your password:</p>" .
                        "<p>Token: {$this->token}</p>" .
                        "<p>If you did not request a password reset, no further action is required.</p>"
                    );
    }
    
}
