<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenaltyRequest;
use App\Models\Penalty;
use App\Models\PenaltyLevel;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    // Daftar sanksi
    public function index()
    {
        $penalties = Penalty::with('report', 'penaltyLevel', 'decider')->paginate(10);
        return view('penalties.index', compact('penalties'));
    }

    // Detail sanksi
    public function show(Penalty $penalty)
    {
        $penalty->load('report', 'penaltyLevel', 'decider');
        return view('penalties.show', compact('penalty'));
    }

    // Form buat sanksi
    public function create()
    {
        $reports = Report::all();
        $penaltyLevels = PenaltyLevel::all();
        $users = User::all();
        return view('penalties.create', compact('reports', 'penaltyLevels', 'users'));
    }

    // Simpan sanksi baru
    public function store(PenaltyRequest $request)
    {
        $data = $request->validated();
        $penalty = Penalty::create($data);

        return redirect()->route('penalties.show', $penalty)->with('success', 'Sanksi berhasil dibuat.');
    }

    // Form edit sanksi
    public function edit(Penalty $penalty)
    {
        $reports = Report::all();
        $penaltyLevels = PenaltyLevel::all();
        $users = User::all();
        return view('penalties.edit', compact('penalty', 'reports', 'penaltyLevels', 'users'));
    }

    // Update sanksi
    public function update(PenaltyRequest $request, Penalty $penalty)
    {
        $data = $request->validated();
        $penalty->update($data);

        return redirect()->route('penalties.show', $penalty)->with('success', 'Sanksi berhasil diperbarui.');
    }

    // Hapus sanksi (soft delete)
    public function destroy(Penalty $penalty)
    {
        $penalty->delete();
        return redirect()->route('penalties.index')->with('success', 'Sanksi berhasil dihapus.');
    }
}
