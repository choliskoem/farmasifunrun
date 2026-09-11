<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManagementMember;
use App\Models\ManagementPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagementMemberController extends Controller
{
    public function index()
    {
        $members = ManagementMember::with('period')
            ->orderBy('urutan')
            ->get();

        return view(
            'admin.management.members.index',
            compact('members')
        );
    }

    public function create()
    {
        $periods = ManagementPeriod::orderByDesc('tahun_mulai')->get();

        return view(
            'admin.management.members.create',
            compact('periods')
        );
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'management_period_id' => 'required|exists:management_periods,id',
        'jabatan' => 'required|string|max:100',
        'nama' => 'required|string|max:255',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        'urutan' => 'nullable|integer',
    ]);

    $validated['aktif'] = $request->boolean('aktif');

    if ($request->hasFile('foto')) {

        $validated['foto'] = $request->file('foto')
            ->store('pengurus', 'public');
    }

    ManagementMember::create($validated);

    return redirect()
        ->route('admin.management-members.index')
        ->with('success', 'Pengurus berhasil ditambahkan.');
}

    public function edit(ManagementMember $managementMember)
    {
        $periods = ManagementPeriod::orderByDesc('tahun_mulai')->get();

        return view(
            'admin.management.members.edit',
            compact('managementMember', 'periods')
        );
    }

    public function update(
        Request $request,
        ManagementMember $managementMember
    ) {
        $validated = $request->validate([
            'management_period_id' => 'required|exists:management_periods,id',
            'jabatan' => 'required|string|max:100',
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'urutan' => 'nullable|integer',
        ]);

        if ($request->hasFile('foto')) {

            if ($managementMember->foto) {
                Storage::disk('public')->delete(
                    $managementMember->foto
                );
            }

            $validated['foto'] =
                $request->file('foto')->store(
                    'pengurus',
                    'public'
                );
        }

        $managementMember->update($validated);

        return redirect()
            ->route('admin.management-members.index')
            ->with('success', 'Pengurus berhasil diperbarui.');
    }

    public function destroy(
        ManagementMember $managementMember
    ) {
        if ($managementMember->foto) {
            Storage::disk('public')->delete(
                $managementMember->foto
            );
        }

        $managementMember->delete();

        return back()->with(
            'success',
            'Pengurus berhasil dihapus.'
        );
    }
}