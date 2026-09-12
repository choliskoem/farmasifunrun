<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Event;
use App\Models\HimafaProfile;
use App\Models\ManagementMember;
use App\Models\ManagementPeriod;
use App\Models\Mission;
use App\Models\SocialLink;
use App\Models\User;
use App\Models\Vision;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HimafaSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | AKUN CONTOH -- SUPER ADMIN, ADMIN (SUPERUSER), USER BIASA
        |--------------------------------------------------------------------------
        |
        | 3 akun buat testing tiap level akses:
        | - Super Admin  -> akses penuh, termasuk Kelola Admin.
        | - Admin        -> akses panel admin standar.
        | - User biasa   -> is_admin = false, TIDAK bisa masuk panel
        |   admin sama sekali (ke-block sama AdminMiddleware).
        |
        | Password semuanya "password" -- WAJIB diganti kalau
        | project ini bakal dipakai beneran (bukan cuma testing).
        |
        */

        User::updateOrCreate(
            [
                'email' => 'super',
            ],
            [
                'name' => 'Administrator HIMAFA',
                'password' => Hash::make('super'),
                'is_admin' => true,
                'role' => 'super_admin',
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'superuser',
            ],
            [
                'name' => 'Superuser HIMAFA',
                'password' => Hash::make('superuser'),
                'is_admin' => true,
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'user',
            ],
            [
                'name' => 'User Biasa',
                'password' => Hash::make('user'),
                'is_admin' => false,
                'role' => 'user',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | PROFIL
        |--------------------------------------------------------------------------
        */

        HimafaProfile::updateOrCreate(
            ['id' => 1],
            [
                'nama_organisasi' =>
                    'Himpunan Mahasiswa Jurusan Farmasi',

                'tagline' =>
                    'HIMAFA Meracik Sinergi, Menghasilkan Prestasi',

                'deskripsi' =>
                    'HIMAFA hadir sebagai wadah mahasiswa Farmasi untuk menyatukan potensi, membangun kolaborasi, dan mengembangkan diri dalam semangat kebersamaan demi menciptakan karya, prestasi, serta kontribusi nyata bagi Farmasi dan masyarakat.',

                'tahun_berdiri' => 2007,

                'sejarah_awal' =>
                    'Himpunan Mahasiswa Farmasi (HIMAFA) Universitas Negeri Gorontalo telah menjadi bagian dari perjalanan mahasiswa Farmasi sejak sekitar tahun 2007. Kehadirannya tumbuh seiring perkembangan Jurusan Farmasi sebagai wadah yang menyatukan mahasiswa dalam semangat kebersamaan, aspirasi, keilmuan, dan pengembangan potensi.',

                'sejarah_perjalanan' =>
                    'Selama kurang lebih 19 tahun perjalanannya hingga tahun 2026, HIMAFA terus tumbuh dari generasi ke generasi. Berbagai dinamika, gagasan, karya, dan prestasi telah mewarnai perjalanan organisasi serta membentuk HIMAFA menjadi ruang bagi mahasiswa Farmasi untuk belajar, berkolaborasi, mengembangkan kepemimpinan, dan memberikan kontribusi kepada lingkungan kampus maupun masyarakat.',

                'sejarah_kini' =>
                    'Setelah hampir dua dekade perjalanan, HIMAFA terus membawa semangat yang sama: merawat kebersamaan, meracik sinergi, dan menghasilkan prestasi — sekaligus menjadi rumah bagi setiap generasi mahasiswa Farmasi Universitas Negeri Gorontalo.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | VISI
        |--------------------------------------------------------------------------
        */

        Vision::updateOrCreate(
            ['id' => 1],
            [
                'isi' =>
                    'Revitalisasi HIMAFA sebagai organisasi mahasiswa farmasi yang adaptif, inovatif, dan berdaya saing melalui tata kelola transparan dan profesional.',

                'aktif' => true,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | MISI
        |--------------------------------------------------------------------------
        */

        $missions = [
            'Menguatkan pengembangan akademik dan keilmuan farmasi berbasis inovasi dan teknologi guna mencetak mahasiswa yang unggul.',
            'Mendorong peningkatan kapasitas mahasiswa melalui riset, kompetisi ilmiah, dan kegiatan yang berorientasi pada daya saing.',
            'Mengoptimalkan peran mahasiswa dalam pengabdian masyarakat sebagai kontribusi nyata di bidang kesehatan.',
            'Memperluas kolaborasi strategis dengan civitas akademika dan mitra eksternal untuk mendukung pertumbuhan organisasi.',
            'Mewujudkan tata kelola organisasi yang adaptif, efektif, transparan, dan akuntabel secara berkelanjutan.',
        ];

        foreach ($missions as $index => $mission) {

            Mission::updateOrCreate(
                ['nomor' => $index + 1],
                [
                    'isi' => $mission,
                    'aktif' => true,
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | PERIODE
        |--------------------------------------------------------------------------
        */

        $period = ManagementPeriod::updateOrCreate(
            [
                'tahun_mulai' => 2026,
            ],
            [
                'nama_periode' => 'HIMAFA Periode 2026',
                'tahun_mulai' => 2026,
                'tahun_selesai' => null,
                'aktif' => true,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | PENGURUS INTI
        |--------------------------------------------------------------------------
        */

        $members = [
            [
                'jabatan' => 'Ketua Umum',
                'nama' => 'Rayyan Zulfanafilah Lasanudin',
                'urutan' => 1,
            ],
            [
                'jabatan' => 'Sekretaris Umum',
                'nama' => 'Faizal Eyato',
                'urutan' => 2,
            ],
            [
                'jabatan' => 'Bendahara Umum',
                'nama' => 'Rafiqa S. K Mamonto',
                'urutan' => 3,
            ],
        ];

        foreach ($members as $member) {

            ManagementMember::updateOrCreate(
                [
                    'management_period_id' => $period->id,
                    'jabatan' => $member['jabatan'],
                ],
                [
                    'nama' => $member['nama'],
                    'urutan' => $member['urutan'],
                    'aktif' => true,
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | BIDANG
        |--------------------------------------------------------------------------
        */

        $departments = [
            [
                'nama' => 'BP3AO',
                'ketua' => 'Soraya Azahra Alaydrus',
                'sekretaris' => 'Diva Meilani',
                'deskripsi' =>
                    'Bidang yang mendukung pengembangan dan pengelolaan organisasi secara terarah.',
                'urutan' => 1,
            ],
            [
                'nama' => 'Humas',
                'ketua' => 'Qurota Aini Az-Zahra Anda',
                'sekretaris' => 'Nurul Najwalya J. Puhi',
                'deskripsi' =>
                    'Membangun komunikasi dan hubungan strategis HIMAFA dengan berbagai pihak.',
                'urutan' => 2,
            ],
            [
                'nama' => 'Minat & Bakat',
                'ketua' => 'Natasya Talango',
                'sekretaris' => 'Aulia Nisfatuzzahra Biki',
                'deskripsi' =>
                    'Mewadahi potensi, kreativitas, minat, bakat, dan prestasi mahasiswa.',
                'urutan' => 3,
            ],
            [
                'nama' => 'PIK',
                'ketua' => 'Dirga Anugrah Mokoginta',
                'sekretaris' => 'Fildzah Syaputri Mamonto',
                'deskripsi' =>
                    'Mendukung kegiatan informasi, edukasi, dan pengembangan mahasiswa.',
                'urutan' => 4,
            ],
            [
                'nama' => 'Kewirausahaan',
                'ketua' => 'Nurindah Yuliyani Usman',
                'sekretaris' => 'Feby Adinda Malik',
                'deskripsi' =>
                    'Mendorong jiwa kewirausahaan dan kemandirian mahasiswa Farmasi.',
                'urutan' => 5,
            ],
            [
                'nama' => 'TIK',
                'ketua' => 'Karim Putra Dunggio',
                'sekretaris' => 'Deswita Faradila Sango',
                'deskripsi' =>
                    'Mengoptimalkan teknologi informasi dan komunikasi dalam organisasi.',
                'urutan' => 6,
            ],
            [
                'nama' => 'Kerohanian',
                'ketua' => 'Rahmat Aprianto Tamalero',
                'sekretaris' => 'Hariyanto Suronoto',
                'deskripsi' =>
                    'Membangun nilai spiritual, moral, dan kebersamaan dalam organisasi.',
                'urutan' => 7,
            ],
        ];

        foreach ($departments as $department) {

            Department::updateOrCreate(
                [
                    'management_period_id' => $period->id,
                    'nama' => $department['nama'],
                ],
                [
                    'deskripsi' => $department['deskripsi'],
                    'ketua' => $department['ketua'],
                    'sekretaris' => $department['sekretaris'],
                    'urutan' => $department['urutan'],
                    'aktif' => true,
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SOCIAL MEDIA
        |--------------------------------------------------------------------------
        */

        $socials = [
            'Instagram',
            'Facebook',
            'YouTube',
            'Email',
        ];

        foreach ($socials as $social) {

            SocialLink::firstOrCreate(
                [
                    'platform' => $social,
                ],
                [
                    'url' => '#',
                    'aktif' => true,
                ]
            );
        }
    }
}