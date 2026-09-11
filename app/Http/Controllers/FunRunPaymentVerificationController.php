<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FunRunPaymentVerified;
use App\Models\FunRunPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FunRunPaymentVerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = FunRunPayment::with([
            'registration.event',
            'registration.category',
            'verifier',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Filter status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas(
                'registration',
                function ($q) use ($search) {

                    $q->where(
                        'registration_code',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'name',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'email',
                        'like',
                        "%{$search}%"
                    );
                }
            );
        }

        $payments = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view(
            'admin.fun-run.payments.index',
            compact('payments')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */

    public function show(FunRunPayment $payment)
    {
        $payment->load([
            'registration.event',
            'registration.category',
            'registration.price.period',
            'verifier',
        ]);

        return view(
            'admin.fun-run.payments.show',
            compact('payment')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI
    |--------------------------------------------------------------------------
    */

    public function verify(
        Request $request,
        FunRunPayment $payment
    ) {
        if ($payment->status === 'verified') {

            return back()->with(
                'error',
                'Pembayaran sudah diverifikasi.'
            );
        }

        $request->validate([
            'admin_note' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use (
            $payment,
            $request
        ) {

            $payment->update([
                'status' => 'verified',

                'admin_note' =>
                    $request->admin_note,

                'verified_by' =>
                    auth()->id(),

                'verified_at' =>
                    now(),
            ]);

            $payment->registration->update([
                'status' => 'paid',
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Email
        |--------------------------------------------------------------------------
        */

        $payment->load([
            'registration.event',
            'registration.category',
            'registration.price.period',
        ]);

        Mail::to(
            $payment->registration->email
        )->send(
            new FunRunPaymentVerified(
                $payment->registration
            )
        );

        return redirect()
            ->route(
                'admin.fun-run.payments.show',
                $payment->id
            )
            ->with(
                'success',
                'Pembayaran berhasil diverifikasi dan email konfirmasi telah dikirim.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | TOLAK
    |--------------------------------------------------------------------------
    */

    public function reject(
        Request $request,
        FunRunPayment $payment
    ) {
        $validated = $request->validate([
            'admin_note' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $payment->update([
            'status' => 'rejected',

            'admin_note' =>
                $validated['admin_note'],

            'verified_by' =>
                auth()->id(),

            'verified_at' =>
                now(),
        ]);

        $payment->registration->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route(
                'admin.fun-run.payments.show',
                $payment->id
            )
            ->with(
                'success',
                'Pembayaran ditolak.'
            );
    }
}