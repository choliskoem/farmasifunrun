<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManagementPeriod;
use Illuminate\Http\Request;

class ManagementPeriodController extends Controller
{
    public function index()
    {
        $periods = ManagementPeriod::latest()->get();

        return view(
            'admin.management.periods.index',
            compact('periods')
        );
    }

    public function create()
    {
        return view('admin.management.periods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:100',
            'tahun_mulai' => 'required|integer',
            'tahun_selesai' => 'nullable|integer',
        ]);

        $aktif = $request->boolean('aktif');

        if ($aktif) {
            ManagementPeriod::query()
                ->update(['aktif' => false]);
        }

        $validated['aktif'] = $aktif;

        ManagementPeriod::create($validated);

        return redirect()
            ->route('admin.management-periods.index')
            ->with('success', 'Periode berhasil ditambahkan.');
    }

    public function edit(ManagementPeriod $managementPeriod)
    {
        return view(
            'admin.management.periods.edit',
            compact('managementPeriod')
        );
    }

   public function update(
    Request $request,
    ManagementPeriod $managementPeriod
) {
    $validated = $request->validate([
        'nama_periode' => 'required|string|max:100',
        'tahun_mulai' => 'required|integer',
        'tahun_selesai' => 'nullable|integer',
    ]);

    $aktif = $request->boolean('aktif');

    if ($aktif) {
        ManagementPeriod::where('id', '!=', $managementPeriod->id)
            ->update(['aktif' => false]);
    }

    $validated['aktif'] = $aktif;

    $managementPeriod->update($validated);

    return redirect()
        ->route('admin.management-periods.index')
        ->with('success', 'Periode berhasil diperbarui.');
}
    public function destroy(
        ManagementPeriod $managementPeriod
    ) {
        $managementPeriod->delete();

        return back()->with(
            'success',
            'Periode berhasil dihapus.'
        );
    }
}