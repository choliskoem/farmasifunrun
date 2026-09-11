<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        $links = SocialLink::orderBy('platform')->get();

        return view(
            'admin.social-links.index',
            compact('links')
        );
    }

    public function create()
    {
        return view('admin.social-links.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:100',
            'url' => 'required|url|max:500',
        ]);

        $validated['aktif'] = $request->boolean('aktif');

        SocialLink::create($validated);

        return redirect()
            ->route('admin.social-links.index')
            ->with('success', 'Link berhasil ditambahkan.');
    }

    public function edit(SocialLink $socialLink)
    {
        return view(
            'admin.social-links.edit',
            compact('socialLink')
        );
    }

    public function update(
        Request $request,
        SocialLink $socialLink
    ) {
        $validated = $request->validate([
            'platform' => 'required|string|max:100',
            'url' => 'required|url|max:500',
        ]);

        $validated['aktif'] = $request->boolean('aktif');

        $socialLink->update($validated);

        return redirect()
            ->route('admin.social-links.index')
            ->with('success', 'Link berhasil diperbarui.');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();

        return back()->with(
            'success',
            'Link berhasil dihapus.'
        );
    }
}