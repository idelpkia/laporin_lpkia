<?php

namespace App\Http\Controllers;

use App\Http\Requests\ViolationTypeRequest;
use App\Models\ViolationType;
use Illuminate\Http\Request;

class ViolationTypeController extends Controller
{
    // Daftar semua jenis pelanggaran
    public function index()
    {
        $violationTypes = ViolationType::paginate(10);
        return view('violation_types.index', compact('violationTypes'));
    }

    // Form tambah jenis pelanggaran
    public function create()
    {
        return view('violation_types.create');
    }

    // Simpan data baru
    public function store(ViolationTypeRequest $request)
    {
        $data = $request->validated();
        $violationType = ViolationType::create($data);

        return redirect()->route('violation-types.show', $violationType)->with('success', 'Jenis pelanggaran berhasil ditambah.');
    }

    // Tampilkan detail
    public function show(ViolationType $violationType)
    {
        return view('violation_types.show', compact('violationType'));
    }

    // Form edit
    public function edit(ViolationType $violationType)
    {
        return view('violation_types.edit', compact('violationType'));
    }

    // Update data
    public function update(ViolationTypeRequest $request, ViolationType $violationType)
    {
        $data = $request->validated();
        $violationType->update($data);

        return redirect()->route('violation-types.show', $violationType)->with('success', 'Jenis pelanggaran berhasil diupdate.');
    }

    // Hapus data (softdelete, jika model pakai SoftDeletes)
    public function destroy(ViolationType $violationType)
    {
        $violationType->delete();
        return redirect()->route('violation-types.index')->with('success', 'Jenis pelanggaran berhasil dihapus.');
    }
}
