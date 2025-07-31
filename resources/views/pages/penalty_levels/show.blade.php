@extends('layouts.app')

@section('title', 'Detail Tingkat Sanksi')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Tingkat Sanksi</h1>
                <div class="section-header-button">
                    <a href="{{ route('penalty-levels.edit', $penaltyLevel) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('penalty-levels.index') }}">Tingkat Sanksi</a>
                    </div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Tingkat Sanksi</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Level Sanksi:</label>
                                            <div class="mt-2">
                                                @if ($penaltyLevel->level == 'light')
                                                    <span class="badge badge-success badge-lg">
                                                        <i class="fas fa-check-circle"></i> Ringan
                                                    </span>
                                                @elseif($penaltyLevel->level == 'medium')
                                                    <span class="badge badge-warning badge-lg">
                                                        <i class="fas fa-exclamation-triangle"></i> Sedang
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger badge-lg">
                                                        <i class="fas fa-times-circle"></i> Berat
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Tanggal Dibuat:</label>
                                            <p class="text-muted">{{ $penaltyLevel->created_at->format('d F Y, H:i') }} WIB
                                            </p>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Terakhir Diupdate:</label>
                                            <p class="text-muted">{{ $penaltyLevel->updated_at->format('d F Y, H:i') }} WIB
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Deskripsi:</label>
                                            @if ($penaltyLevel->description)
                                                <div class="mt-2 p-3 bg-light rounded">
                                                    {!! nl2br(e($penaltyLevel->description)) !!}
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada deskripsi</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('penalty-levels.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                        </a>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="{{ route('penalty-levels.edit', $penaltyLevel) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-danger"
                                            onclick="deleteData({{ $penaltyLevel->id }})">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Level Sanksi</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <h6 class="text-white mb-0">
                                                    <i class="fas fa-check-circle"></i> Sanksi Ringan
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <small class="text-muted">
                                                    Sanksi dengan tingkat pelanggaran rendah, biasanya berupa peringatan
                                                    atau teguran.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-warning">
                                            <div class="card-header">
                                                <h6 class="text-white mb-0">
                                                    <i class="fas fa-exclamation-triangle"></i> Sanksi Sedang
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <small class="text-muted">
                                                    Sanksi dengan tingkat pelanggaran menengah, dapat berupa penundaan atau
                                                    pembatasan.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-danger">
                                            <div class="card-header">
                                                <h6 class="text-white mb-0">
                                                    <i class="fas fa-times-circle"></i> Sanksi Berat
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <small class="text-muted">
                                                    Sanksi dengan tingkat pelanggaran tinggi, dapat berupa skorsing atau
                                                    pemecatan.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus tingkat sanksi ini?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Peringatan:</strong> Data yang dihapus tidak dapat dikembalikan!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script>
        function deleteData(id) {
            $('#deleteForm').attr('action', '{{ route('penalty-levels.destroy', ':id') }}'.replace(':id', id));
            $('#deleteModal').modal('show');
        }
    </script>
@endpush
