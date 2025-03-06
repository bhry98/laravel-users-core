<?php

namespace Bhry98\LaravelUsersCore\Notifications;

use Illuminate\Mail\Mailable;

class SendResetPasswordOtpViaEmail extends Mailable
{
    public $otp;
    public $user;

    public function __construct($otp, $user)
    {
        $this->otp = $otp;
        $this->user = $user;
    }
    public function build(): SendResetPasswordOtpViaEmail
    {
        return $this->from(address: config("bhry98-users-core.smtp.username"))
            ->to(address: $this->user->email)
            ->subject(subject: "Reset Password Code")
            ->view('Bhry98::reset-password-otp')
            ->with(['code' => $this->otp->verify_code]);
    }
}
