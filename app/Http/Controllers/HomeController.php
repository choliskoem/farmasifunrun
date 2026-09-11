<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\HimafaProfile;
use App\Models\ManagementMember;
use App\Models\ManagementPeriod;
use App\Models\Mission;
use App\Models\SocialLink;
use App\Models\Vision;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | PROFILE HIMAFA
        |--------------------------------------------------------------------------
        */

        $profile = HimafaProfile::first();


        /*
        |--------------------------------------------------------------------------
        | PERIODE AKTIF
        |--------------------------------------------------------------------------
        */

        $activePeriod = ManagementPeriod::where('aktif', true)
            ->orderByDesc('tahun_mulai')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | FALLBACK PERIODE
        |--------------------------------------------------------------------------
        | Jika belum ada periode yang diberi status aktif,
        | ambil periode terbaru.
        */

        if (!$activePeriod) {
            $activePeriod = ManagementPeriod::orderByDesc('tahun_mulai')
                ->first();
        }


        /*
        |--------------------------------------------------------------------------
        | PENGURUS
        |--------------------------------------------------------------------------
        */

        $members = collect();

        if ($activePeriod) {
            $members = ManagementMember::where(
                    'management_period_id',
                    $activePeriod->id
                )
                ->where('aktif', true)
                ->orderBy('urutan')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | BIDANG
        |--------------------------------------------------------------------------
        */

        $departments = collect();

        if ($activePeriod) {
            $departments = Department::where(
                    'management_period_id',
                    $activePeriod->id
                )
                ->where('aktif', true)
                ->orderBy('urutan')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | VISI
        |--------------------------------------------------------------------------
        */

        $vision = Vision::where('aktif', true)
            ->first();


        /*
        |--------------------------------------------------------------------------
        | MISI
        |--------------------------------------------------------------------------
        */

        $missions = Mission::where('aktif', true)
            ->orderBy('nomor')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | GALERI
        |--------------------------------------------------------------------------
        */

        $galleries = Gallery::with('photos')
            ->where('aktif', true)
            ->whereHas('photos')
            ->orderBy('urutan')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        */

        $events = Event::whereIn('status', ['aktif', 'selesai'])
            ->orderByDesc('tanggal')
            ->orderByDesc('tahun')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | SOCIAL MEDIA
        |--------------------------------------------------------------------------
        */

        $socialLinks = SocialLink::where('aktif', true)
            ->orderBy('platform')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view('home', [
            'title' => 'HIMAFA — Himpunan Mahasiswa Jurusan Farmasi',

            'profile' => $profile,

            'activePeriod' => $activePeriod,

            'members' => $members,

            'departments' => $departments,

            'vision' => $vision,

            'missions' => $missions,

            'galleries' => $galleries,

            'events' => $events,

            'socialLinks' => $socialLinks,
        ]);
    }

    /**
     * Halaman Galeri Kegiatan (terpisah dari beranda).
     */
    public function galeri(): View
    {
        $galleries = Gallery::with('photos')
            ->where('aktif', true)
            ->whereHas('photos')
            ->orderBy('urutan')
            ->get();

        return view('galeri', [
            'title' => 'Galeri Kegiatan — HIMAFA',
            'galleries' => $galleries,
        ]);
    }
}