<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppealRequest;
use App\Models\Appeal;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    // Daftar semua banding (opsional: filter by user/role)
    public function index()
    {
        $appeals = Appeal::with('report', 'appellant', 'reviewer')->latest()->paginate(10);
        return view('appeals.index', compact('appeals'));
    }

    // Form pengajuan banding
    public function create()
    {
        // Ambil hanya report yang bisa dibanding (misal: milik user, status tertentu)
        $reports = Report::where('status', 'completed')->get();
        return view('appeals.create', compact('reports'));
    }

    // Simpan banding baru
    public function store(AppealRequest $request)
    {
        $data = $request->validated();
        $data['appellant_id'] = auth()->id();
        $data['appeal_status'] = 'submitted';

        $appeal = Appeal::create($data);

        return redirect()->route('appeals.show', $appeal)->with('success', 'Banding berhasil diajukan.');
    }

    // Tampilkan detail banding
    public function show(Appeal $appeal)
    {
        $appeal->load('report', 'appellant', 'reviewer');
        return view('appeals.show', compact('appeal'));
    }

    // Form review (untuk dewan etik/admin)
    public function edit(Appeal $appeal)
    {
        $users = User::all(); // Untuk pilihan reviewer
        return view('appeals.edit', compact('appeal', 'users'));
    }

    // Proses review/update banding
    public function update(AppealRequest $request, Appeal $appeal)
    {
        $data = $request->validated();
        $data['reviewed_by'] = auth()->id();
        $data['review_date'] = now();
        $appeal->update($data);

        return redirect()->route('appeals.show', $appeal)->with('success', 'Banding berhasil direview.');
    }

    // (Opsional) Hapus banding
    public function destroy(Appeal $appeal)
    {
        $appeal->delete();
        return redirect()->route('appeals.index')->with('success', 'Banding berhasil dihapus.');
    }
}
