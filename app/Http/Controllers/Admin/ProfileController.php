<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HimafaProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = HimafaProfile::first();

        if (!$profile) {
            $profile = HimafaProfile::create([
                'nama_organisasi' => 'Himpunan Mahasiswa Jurusan Farmasi',
                'tagline' => 'HIMAFA Meracik Sinergi, Menghasilkan Prestasi',
            ]);
        }

        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_organisasi' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'tahun_berdiri' => 'nullable|integer|min:1900|max:2100',
            'sejarah_awal' => 'nullable|string',
            'sejarah_perjalanan' => 'nullable|string',
            'sejarah_kini' => 'nullable|string',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $profile = HimafaProfile::firstOrFail();

        if ($request->hasFile('hero_image')) {

            if ($profile->hero_image) {
                Storage::disk('public')->delete($profile->hero_image);
            }

            $validated['hero_image'] =
                $request->file('hero_image')->store(
                    'himafa',
                    'public'
                );
        }

        $profile->update($validated);

        return back()->with(
            'success',
            'Profil HIMAFA berhasil diperbarui.'
        );
    }
}