<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vision;
use Illuminate\Http\Request;

class VisionController extends Controller
{
    public function edit()
    {
        $vision = Vision::first();

        if (!$vision) {
            $vision = Vision::create([
                'isi' => '',
                'aktif' => true,
            ]);
        }

        return view('admin.vision.edit', compact('vision'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'isi' => 'required|string',
        ]);

        $vision = Vision::first();

        if (!$vision) {
            Vision::create([
                'isi' => $request->isi,
                'aktif' => true,
            ]);
        } else {
            $vision->update([
                'isi' => $request->isi,
                'aktif' => $request->boolean('aktif'),
            ]);
        }

        return back()->with(
            'success',
            'Visi berhasil diperbarui.'
        );
    }
}