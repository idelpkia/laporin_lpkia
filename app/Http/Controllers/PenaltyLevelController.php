<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenaltyLevelRequest;
use App\Models\PenaltyLevel;
use Illuminate\Http\Request;

class PenaltyLevelController extends Controller
{
    // Daftar semua tingkat sanksi
    public function index()
    {
        $penaltyLevels = PenaltyLevel::paginate(10);
        return view('pages.penalty_levels.index', compact('penaltyLevels'));
    }

    // Form tambah tingkat sanksi
    public function create()
    {
        return view('penalty_levels.create');
    }

    // Simpan data baru
    public function store(PenaltyLevelRequest $request)
    {
        $data = $request->validated();
        $penaltyLevel = PenaltyLevel::create($data);

        return redirect()->route('penalty-levels.show', $penaltyLevel)->with('success', 'Tingkat sanksi berhasil ditambah.');
    }

    // Tampilkan detail
    public function show(PenaltyLevel $penaltyLevel)
    {
        return view('penalty_levels.show', compact('penaltyLevel'));
    }

    // Form edit
    public function edit(PenaltyLevel $penaltyLevel)
    {
        return view('penalty_levels.edit', compact('penaltyLevel'));
    }

    // Update data
    public function update(PenaltyLevelRequest $request, PenaltyLevel $penaltyLevel)
    {
        $data = $request->validated();
        $penaltyLevel->update($data);

        return redirect()->route('penalty-levels.show', $penaltyLevel)->with('success', 'Tingkat sanksi berhasil diupdate.');
    }

    // Hapus data (softdelete, jika model pakai SoftDeletes)
    public function destroy(PenaltyLevel $penaltyLevel)
    {
        $penaltyLevel->delete();
        return redirect()->route('penalty-levels.index')->with('success', 'Tingkat sanksi berhasil dihapus.');
    }
}
