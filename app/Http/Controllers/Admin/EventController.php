<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();

        return view(
            'admin.events.index',
            compact('events')
        );
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:flyer,full',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'tahun' => 'nullable|integer',
            'link' => 'nullable|url',
            'gambar' => [
                Rule::requiredIf($request->input('tipe') === 'flyer'),
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'status' => 'required|in:draft,aktif,selesai',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] =
                $request->file('gambar')->store(
                    'events',
                    'public'
                );
        }

        Event::create($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        return view(
            'admin.events.edit',
            compact('event')
        );
    }

    public function update(
        Request $request,
        Event $event
    ) {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:flyer,full',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'tahun' => 'nullable|integer',
            'link' => 'nullable|url',
            'gambar' => [
                Rule::requiredIf(
                    $request->input('tipe') === 'flyer' && !$event->gambar
                ),
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'status' => 'required|in:draft,aktif,selesai',
        ]);

        if ($request->hasFile('gambar')) {

            if ($event->gambar) {
                Storage::disk('public')->delete(
                    $event->gambar
                );
            }

            $validated['gambar'] =
                $request->file('gambar')->store(
                    'events',
                    'public'
                );
        }

        $event->update($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->gambar) {
            Storage::disk('public')->delete(
                $event->gambar
            );
        }

        $event->delete();

        return back()->with(
            'success',
            'Event berhasil dihapus.'
        );
    }
}