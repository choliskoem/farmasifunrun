<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\VisionController;
use App\Http\Controllers\Admin\MissionController;
use App\Http\Controllers\Admin\ManagementPeriodController;
use App\Http\Controllers\Admin\ManagementMemberController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\UserManagementController;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\Admin\FunRunController as AdminFunRunController;
use App\Http\Controllers\Admin\FunRunSettingsController;
use App\Http\Controllers\Admin\FunRunManualRegistrationController;
use App\Http\Controllers\FunRunController;


/*
|--------------------------------------------------------------------------
| WEBSITE PUBLIK HIMAFA
|--------------------------------------------------------------------------
*/

Route::get('/', [
    HomeController::class,
    'index'
])->name('home');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/login', [
    AuthController::class,
    'showLogin'
])->name('login');

Route::post('/login', [
    AuthController::class,
    'login'
])->name('login.process');


/*
|--------------------------------------------------------------------------
| ADMIN HIMAFA
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/', [
            DashboardController::class,
            'index'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | LOGOUT
        |--------------------------------------------------------------------------
        */

        Route::post('/logout', [
            AuthController::class,
            'logout'
        ])->name('logout');


        /*
        |--------------------------------------------------------------------------
        | PROFIL HIMAFA
        |--------------------------------------------------------------------------
        */

        Route::get('/profil', [
            ProfileController::class,
            'edit'
        ])->name('profile.edit');

        Route::put('/profil', [
            ProfileController::class,
            'update'
        ])->name('profile.update');


        /*
        |--------------------------------------------------------------------------
        | VISI
        |--------------------------------------------------------------------------
        */

        Route::get('/visi', [
            VisionController::class,
            'edit'
        ])->name('vision.edit');

        Route::put('/visi', [
            VisionController::class,
            'update'
        ])->name('vision.update');


        /*
        |--------------------------------------------------------------------------
        | MISI
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'missions',
            MissionController::class
        )->except([
            'show'
        ]);


        /*
        |--------------------------------------------------------------------------
        | PERIODE KEPENGURUSAN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'management-periods',
            ManagementPeriodController::class
        )->except([
            'show'
        ]);


        /*
        |--------------------------------------------------------------------------
        | ANGGOTA KEPENGURUSAN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'management-members',
            ManagementMemberController::class
        )->except([
            'show'
        ]);


        /*
        |--------------------------------------------------------------------------
        | DEPARTEMEN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'departments',
            DepartmentController::class
        )->except([
            'show'
        ]);


        /*
        |--------------------------------------------------------------------------
        | GALERI
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'galleries',
            GalleryController::class
        )->except([
            'show'
        ]);


        /*
        |--------------------------------------------------------------------------
        | EVENT HIMAFA
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'events',
            EventController::class
        )->except([
            'show'
        ]);


        /*
        |--------------------------------------------------------------------------
        | SOCIAL MEDIA
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'social-links',
            SocialLinkController::class
        )->except([
            'show'
        ]);


        /*
        |--------------------------------------------------------------------------
        | KELOLA ADMIN (KHUSUS SUPER ADMIN)
        |--------------------------------------------------------------------------
        |
        | Ditumpuk middleware 'super_admin' di atas middleware 'admin'
        | yang sudah ada di grup ini -- jadi tetap wajib login +
        | is_admin dulu, BARU dicek lagi apakah role-nya super_admin.
        |
        */

        Route::middleware(['super_admin'])->group(function () {

            Route::resource(
                'users',
                UserManagementController::class
            )->except([
                'show'
            ]);

        });


        /*
        |--------------------------------------------------------------------------
        | FUN RUN ADMIN
        |--------------------------------------------------------------------------
        |
        | URL:
        | /admin/fun-run/registrations
        |
        | Name:
        | admin.fun-run.registrations
        |
        */

        Route::prefix('fun-run')
            ->name('fun-run.')
            ->group(function () {

                /*
                |--------------------------------------------------------------------------
                | DAFTAR PESERTA
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/registrations',
                    [
                        AdminFunRunController::class,
                        'registrations'
                    ]
                )->name('registrations');


                /*
                |--------------------------------------------------------------------------
                | EXPORT PESERTA (CSV)
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/registrations/export',
                    [
                        AdminFunRunController::class,
                        'exportRegistrations'
                    ]
                )->name('registrations.export');


                /*
                |--------------------------------------------------------------------------
                | DETAIL PESERTA
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/registrations/{registration}',
                    [
                        AdminFunRunController::class,
                        'show'
                    ]
                )->name('registrations.show');


                /*
                |--------------------------------------------------------------------------
                | VERIFIKASI PEMBAYARAN
                |--------------------------------------------------------------------------
                */

                Route::post(
                    '/registrations/{registration}/verify',
                    [
                        AdminFunRunController::class,
                        'verify'
                    ]
                )->name('registrations.verify');


                /*
                |--------------------------------------------------------------------------
                | TOLAK PEMBAYARAN
                |--------------------------------------------------------------------------
                */

                Route::post(
                    '/registrations/{registration}/reject',
                    [
                        AdminFunRunController::class,
                        'reject'
                    ]
                )->name('registrations.reject');


                /*
                |--------------------------------------------------------------------------
                | VERIFIKASI EMAIL & KIRIM LINK PEMBAYARAN
                |--------------------------------------------------------------------------
                */

                Route::post(
                    '/registrations/{registration}/verify-email',
                    [
                        AdminFunRunController::class,
                        'verifyEmail'
                    ]
                )->name('registrations.verify-email');

            });

        /*
        |--------------------------------------------------------------------------
        | PENGATURAN FUN RUN (PERIODE & STOK TIKET)
        |--------------------------------------------------------------------------
        |
        | URL:
        | /admin/fun-run/settings
        |
        | Name:
        | admin.fun-run.settings.*
        |
        */

        Route::prefix('fun-run/settings')
            ->name('fun-run.settings.')
            ->group(function () {

                Route::get(
                    '/',
                    [
                        FunRunSettingsController::class,
                        'index'
                    ]
                )->name('index');

                Route::put(
                    '/event/{event}/bank',
                    [
                        FunRunSettingsController::class,
                        'updateEventBank'
                    ]
                )->name('event.bank');

                Route::put(
                    '/event/{event}/contact',
                    [
                        FunRunSettingsController::class,
                        'updateEventContact'
                    ]
                )->name('event.contact');

                Route::put(
                    '/event/{event}/maintenance',
                    [
                        FunRunSettingsController::class,
                        'toggleMaintenance'
                    ]
                )->name('event.maintenance');

                Route::post(
                    '/periods',
                    [
                        FunRunSettingsController::class,
                        'storePeriod'
                    ]
                )->name('periods.store');

                Route::post(
                    '/periods/{period}/toggle',
                    [
                        FunRunSettingsController::class,
                        'togglePeriod'
                    ]
                )->name('periods.toggle');

                Route::put(
                    '/periods/{period}',
                    [
                        FunRunSettingsController::class,
                        'updatePeriod'
                    ]
                )->name('periods.update');

                Route::post(
                    '/prices/{price}/quota',
                    [
                        FunRunSettingsController::class,
                        'updateQuota'
                    ]
                )->name('prices.quota');

                Route::put(
                    '/prices/{price}/price',
                    [
                        FunRunSettingsController::class,
                        'updatePrice'
                    ]
                )->name('prices.price');

            });


        /*
        |--------------------------------------------------------------------------
        | REGISTRASI MANUAL (JALUR UNDANGAN / SPESIAL)
        |--------------------------------------------------------------------------
        |
        | URL:
        | /admin/fun-run/manual
        |
        | Name:
        | admin.fun-run.manual.*
        |
        */

        Route::prefix('fun-run/manual')
            ->name('fun-run.manual.')
            ->group(function () {

                Route::get(
                    '/',
                    [
                        FunRunManualRegistrationController::class,
                        'create'
                    ]
                )->name('create');

                Route::post(
                    '/',
                    [
                        FunRunManualRegistrationController::class,
                        'store'
                    ]
                )->name('store');

            });

    });


/*
|--------------------------------------------------------------------------
| FUN RUN MICROSITE
|--------------------------------------------------------------------------
|
| URL:
| /fun-run
|
| Name:
| fun-run.*
|
*/

Route::prefix('fun-run')
    ->name('fun-run.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | LANDING
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/',
            [
                FunRunController::class,
                'index'
            ]
        )->name('index');


        /*
        |--------------------------------------------------------------------------
        | FORM INPUT EMAIL
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/register',
            [
                FunRunController::class,
                'registerEmail'
            ]
        )->name('register.email');


        /*
        |--------------------------------------------------------------------------
        | LANJUT REGISTRASI
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/register/email',
            [
                FunRunController::class,
                'continueRegister'
            ]
        )->name('register.email.continue');


        /*
        |--------------------------------------------------------------------------
        | FORM DATA PESERTA
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/register/form',
            [
                FunRunController::class,
                'register'
            ]
        )->name('register.form');


        /*
        |--------------------------------------------------------------------------
        | SIMPAN REGISTRASI
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/register',
            [
                FunRunController::class,
                'store'
            ]
        )->name('register.store');


        /*
        |--------------------------------------------------------------------------
        | REGISTRASI MENUNGGU
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/register/pending/{registrationCode}',
            [
                FunRunController::class,
                'registerPending'
            ]
        )->name('register.pending');


        /*
        |--------------------------------------------------------------------------
        | PAYMENT
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/payment/{token}',
            [
                FunRunController::class,
                'payment'
            ]
        )->name('payment');


        /*
        |--------------------------------------------------------------------------
        | SUBMIT BUKTI PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/payment/{token}',
            [
                FunRunController::class,
                'submitPayment'
            ]
        )->name('payment.submit');


        /*
        |--------------------------------------------------------------------------
        | STATUS PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/payment/{token}/status',
            [
                FunRunController::class,
                'paymentStatus'
            ]
        )->name('payment.status');


        /*
        |--------------------------------------------------------------------------
        | SUKSES
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/success/{registrationCode}',
            [
                FunRunController::class,
                'success'
            ]
        )->name('success');


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD TIKET
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/ticket/{registrationCode}',
            [
                FunRunController::class,
                'downloadTicket'
            ]
        )->name('ticket.download');


        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI TIKET (SCAN QR)
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/verify/{registrationCode}',
            [
                FunRunController::class,
                'verifyTicket'
            ]
        )->name('verify');

    });