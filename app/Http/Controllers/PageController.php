<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function beranda(): View
    {
        return view('pages.beranda');
    }

    public function sejarah(): View
    {
        return view('pages.sejarah');
    }

    public function visiMisi(): View
    {
        $misi = [
            'Menguatkan pengembangan akademik dan keilmuan farmasi berbasis inovasi dan teknologi guna mencetak mahasiswa yang unggul.',
            'Mendorong peningkatan kapasitas mahasiswa melalui riset, kompetisi ilmiah, dan kegiatan yang berorientasi pada daya saing.',
            'Mengoptimalkan peran mahasiswa dalam pengabdian masyarakat sebagai kontribusi nyata di bidang kesehatan.',
            'Memperluas kolaborasi strategis dengan civitas akademika dan mitra eksternal untuk mendukung pertumbuhan organisasi.',
            'Mewujudkan tata kelola organisasi yang adaptif, efektif, transparan, dan akuntabel secara berkelanjutan.',
        ];

        return view('pages.visi-misi', compact('misi'));
    }

    public function struktur(): View
    {
        // Data struktur kepengurusan HIMAFA 2026
        $pengurusInti = [
            ['jabatan' => 'Ketua Umum', 'nama' => 'Rayyan Zulfanafilah Lasanudin'],
            ['jabatan' => 'Sekretaris Umum', 'nama' => 'Faizal Eyato'],
            ['jabatan' => 'Bendahara Umum', 'nama' => 'Rafiqa S. K Mamonto'],
        ];

        $bidang = [
            [
                'nama' => 'BP3AO',
                'ketua' => 'Soraya Azahra Alaydrus',
                'sekretaris' => 'Diva Meilani',
            ],
            [
                'nama' => 'Humas',
                'ketua' => 'Qurota Aini Az-Zahra Anda',
                'sekretaris' => 'Nurul Najwalya J. Puhi',
            ],
            [
                'nama' => 'Minat & Bakat',
                'ketua' => 'Natasya Talango',
                'sekretaris' => 'Aulia Nisfatuzzahra Biki',
            ],
            [
                'nama' => 'PIK',
                'ketua' => 'Dirga Anugrah Mokoginta',
                'sekretaris' => 'Fildzah Syaputri Mamonto',
            ],
            [
                'nama' => 'Kewirausahaan',
                'ketua' => 'Nurindah Yuliyani Usman',
                'sekretaris' => 'Feby Adinda Malik',
            ],
            [
                'nama' => 'TIK',
                'ketua' => 'Karim Putra Dunggio',
                'sekretaris' => 'Deswita Faradila Sango',
            ],
            [
                'nama' => 'Kerohanian',
                'ketua' => 'Rahmat Aprianto Tamalero',
                'sekretaris' => 'Hariyanto Suronoto',
            ],
        ];

        return view('pages.struktur', compact('pengurusInti', 'bidang'));
    }

    public function galeri(): View
    {
        return view('pages.galeri');
    }

    public function eventFunRun(): View
    {
        return view('pages.event-fun-run');
    }

    public function eventDiesNatalis(): View
    {
        return view('pages.event-dies-natalis');
    }
}
