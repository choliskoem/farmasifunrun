<?php

/*
|--------------------------------------------------------------------------
| DAFTAR MENU ADMIN YANG BISA DIATUR AKSESNYA
|--------------------------------------------------------------------------
|
| Key di sini dipakai di 2 tempat:
| 1. Middleware route: ->middleware('menu:KEY')
| 2. Sidebar admin.blade.php: @if (auth()->user()->canAccessMenu('KEY'))
|
| Kalau nambah menu baru di masa depan, tinggal tambah baris di sini +
| pasang middleware-nya di route, otomatis muncul juga di halaman
| "Atur Akses Menu".
|
*/

return [

    'profile' => [
        'label' => 'Profil HIMAFA',
        'group' => 'Konten Website',
    ],

    'vision' => [
        'label' => 'Visi',
        'group' => 'Konten Website',
    ],

    'missions' => [
        'label' => 'Misi',
        'group' => 'Konten Website',
    ],

    'management-periods' => [
        'label' => 'Periode Kepengurusan',
        'group' => 'Konten Website',
    ],

    'management-members' => [
        'label' => 'Pengurus',
        'group' => 'Konten Website',
    ],

    'departments' => [
        'label' => 'Departemen',
        'group' => 'Konten Website',
    ],

    'galleries' => [
        'label' => 'Galeri',
        'group' => 'Konten Website',
    ],

    'events' => [
        'label' => 'Event',
        'group' => 'Konten Website',
    ],

    'social-links' => [
        'label' => 'Social Media',
        'group' => 'Konten Website',
    ],

    'fun-run-registrations' => [
        'label' => 'Peserta Fun Run',
        'group' => 'Fun Run',
    ],

    'fun-run-settings' => [
        'label' => 'Pengaturan Fun Run',
        'group' => 'Fun Run',
    ],

    'fun-run-manual' => [
        'label' => 'Registrasi Manual',
        'group' => 'Fun Run',
    ],

];