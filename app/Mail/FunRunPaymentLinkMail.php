<?php

namespace App\Mail;

use App\Models\FunRunRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FunRunPaymentLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public FunRunRegistration $registration;

    public string $paymentToken;

    public function __construct(
        FunRunRegistration $registration,
        string $paymentToken
    ) {
        $this->registration = $registration;
        $this->paymentToken = $paymentToken;
    }

    public function build()
    {
        return $this
            ->subject(
                'Link Pembayaran - ' .
                $this->registration->event->name
            )
            ->view(
                'emails.fun-run.payment-link'
            );
    }
}