<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    public function index()
    {
        $missions = Mission::orderBy('nomor')->get();

        return view(
            'admin.missions.index',
            compact('missions')
        );
    }

    public function create()
    {
        $nextNumber = Mission::max('nomor') + 1;

        return view(
            'admin.missions.create',
            compact('nextNumber')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor' => 'required|integer|min:1',
            'isi' => 'required|string',
        ]);

        $validated['aktif'] = $request->boolean('aktif');

        Mission::create($validated);

        return redirect()
            ->route('admin.missions.index')
            ->with('success', 'Misi berhasil ditambahkan.');
    }

    public function edit(Mission $mission)
    {
        return view(
            'admin.missions.edit',
            compact('mission')
        );
    }

    public function update(
        Request $request,
        Mission $mission
    ) {
        $validated = $request->validate([
            'nomor' => 'required|integer|min:1',
            'isi' => 'required|string',
        ]);

        $validated['aktif'] = $request->boolean('aktif');

        $mission->update($validated);

        return redirect()
            ->route('admin.missions.index')
            ->with('success', 'Misi berhasil diperbarui.');
    }

    public function destroy(Mission $mission)
    {
        $mission->delete();

        return back()->with(
            'success',
            'Misi berhasil dihapus.'
        );
    }
}