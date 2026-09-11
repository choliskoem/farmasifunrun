<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\ManagementPeriod;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('period')
            ->orderBy('urutan')
            ->get();

        return view(
            'admin.departments.index',
            compact('departments')
        );
    }

    public function create()
    {
        $periods = ManagementPeriod::orderByDesc('tahun_mulai')->get();

        return view(
            'admin.departments.create',
            compact('periods')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'management_period_id' => 'required|exists:management_periods,id',
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'ketua' => 'required|string|max:255',
            'sekretaris' => 'required|string|max:255',
            'urutan' => 'nullable|integer',
        ]);

        $validated['aktif'] = $request->boolean('aktif');

        Department::create($validated);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Bidang berhasil ditambahkan.');
    }

    public function edit(Department $department)
    {
        $periods = ManagementPeriod::orderByDesc('tahun_mulai')->get();

        return view(
            'admin.departments.edit',
            compact('department', 'periods')
        );
    }

    public function update(
        Request $request,
        Department $department
    ) {
        $validated = $request->validate([
            'management_period_id' => 'required|exists:management_periods,id',
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'ketua' => 'required|string|max:255',
            'sekretaris' => 'required|string|max:255',
            'urutan' => 'nullable|integer',
        ]);

        $validated['aktif'] = $request->boolean('aktif');

        $department->update($validated);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Bidang berhasil diperbarui.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return back()->with(
            'success',
            'Bidang berhasil dihapus.'
        );
    }
}