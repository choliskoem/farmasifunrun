<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('photos')
            ->orderBy('urutan')
            ->get();

        return view(
            'admin.galleries.index',
            compact('galleries')
        );
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',

            'foto_1' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_3' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $gallery = Gallery::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'urutan' => $validated['urutan'] ?? null,
            'aktif' => $request->boolean('aktif'),
        ]);

        foreach ([1, 2, 3] as $slot) {

            if ($request->hasFile("foto_{$slot}")) {

                $path = $request
                    ->file("foto_{$slot}")
                    ->store('gallery', 'public');

                $gallery->photos()->create([
                    'foto' => $path,
                    'urutan' => $slot,
                ]);
            }
        }

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Kegiatan & foto berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load('photos');

        return view(
            'admin.galleries.edit',
            compact('gallery')
        );
    }

    public function update(
        Request $request,
        Gallery $gallery
    ) {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',

            'foto_1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_3' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $gallery->update([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'urutan' => $validated['urutan'] ?? null,
            'aktif' => $request->boolean('aktif'),
        ]);

        $existingPhotos = $gallery->photos->keyBy('urutan');

        foreach ([1, 2, 3] as $slot) {

            $existingPhoto = $existingPhotos->get($slot);

            /*
            |--------------------------------------------------------------------------
            | HAPUS SLOT
            |--------------------------------------------------------------------------
            */

            if ($request->boolean("hapus_foto_{$slot}") && $existingPhoto) {

                Storage::disk('public')->delete($existingPhoto->foto);
                $existingPhoto->delete();

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | GANTI / TAMBAH SLOT
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile("foto_{$slot}")) {

                $path = $request
                    ->file("foto_{$slot}")
                    ->store('gallery', 'public');

                if ($existingPhoto) {

                    Storage::disk('public')->delete($existingPhoto->foto);

                    $existingPhoto->update([
                        'foto' => $path,
                    ]);

                } else {

                    $gallery->photos()->create([
                        'foto' => $path,
                        'urutan' => $slot,
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        foreach ($gallery->photos as $photo) {
            Storage::disk('public')->delete($photo->foto);
        }

        $gallery->delete();

        return back()->with(
            'success',
            'Kegiatan & seluruh fotonya berhasil dihapus.'
        );
    }
}