@extends('layouts.app')

@section('title', 'Jenis Pelanggaran')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Jenis Pelanggaran</h1>
                <div class="section-header-button ml-auto">
                    <a href="{{ route('violation-types.create') }}" class="btn btn-primary">Tambah Jenis</a>
                </div>
            </div>
            <div class="section-body">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Jenis Pelanggaran</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center" width="160">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($violationTypes as $vt)
                                        <tr>
                                            <td>{{ $vt->code }}</td>
                                            <td>{{ $vt->name }}</td>
                                            <td>{{ ucfirst($vt->category) }}</td>
                                            <td>{{ $vt->description }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('violation-types.edit', $vt) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('violation-types.destroy', $vt) }}" method="POST"
                                                    style="display:inline;"
                                                    onsubmit="return confirm('Yakin hapus data ini?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"><i
                                                            class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    {{ $violationTypes->links() }}
                </div>
            </div>
        </section>
    </div>
@endsection
