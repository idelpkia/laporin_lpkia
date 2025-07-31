<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommitteeMemberRequest;
use App\Models\CommitteeMember;
use App\Models\User;
use Illuminate\Http\Request;

class CommitteeMemberController extends Controller
{
    // Daftar semua anggota KIA
    public function index()
    {
        $committeeMembers = CommitteeMember::with('user')->paginate(10);
        return view('pages.committee_members.index', compact('committeeMembers'));
    }

    // Form tambah anggota
    public function create()
    {
        $users = User::all();
        return view('pages.committee_members.create', compact('users'));
    }

    // Simpan data baru
    public function store(CommitteeMemberRequest $request)
    {
        $data = $request->validated();
        $committeeMember = CommitteeMember::create($data);

        return redirect()->route('committee-members.show', $committeeMember)->with('success', 'Anggota KIA berhasil ditambah.');
    }

    // Detail anggota
    public function show(CommitteeMember $committeeMember)
    {
        $committeeMember->load('user');
        return view('pages.committee_members.show', compact('committeeMember'));
    }

    // Form edit
    public function edit(CommitteeMember $committeeMember)
    {
        $users = User::all();
        return view('pages.committee_members.edit', compact('committeeMember', 'users'));
    }

    // Update data
    public function update(CommitteeMemberRequest $request, CommitteeMember $committeeMember)
    {
        $data = $request->validated();
        $committeeMember->update($data);

        return redirect()->route('committee-members.show', $committeeMember)->with('success', 'Anggota KIA berhasil diupdate.');
    }

    // Hapus data (softdelete, jika model pakai SoftDeletes)
    public function destroy(CommitteeMember $committeeMember)
    {
        $committeeMember->delete();
        return redirect()->route('committee-members.index')->with('success', 'Anggota KIA berhasil dihapus.');
    }
}
