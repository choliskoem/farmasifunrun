<?php

namespace App\Mail;

use App\Models\FunRunRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FunRunPaymentVerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    public FunRunRegistration $registration;

    public function __construct(
        FunRunRegistration $registration
    ) {
        $this->registration = $registration;
    }

    public function build()
    {
        return $this
            ->subject(
                'Pembayaran Berhasil Diverifikasi - ' .
                $this->registration->registration_code
            )
            ->view('emails.fun-run.payment-verified');
    }
}