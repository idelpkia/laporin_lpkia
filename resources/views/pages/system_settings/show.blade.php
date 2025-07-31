@extends('layouts.app')

@section('title', 'Detail Pengaturan Sistem')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Pengaturan Sistem</h1>
                <div class="section-header-button">
                    <a href="{{ route('system-settings.edit', $systemSetting) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('system-settings.index') }}">Pengaturan Sistem</a>
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
                                <h4>Informasi Pengaturan</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Key:</label>
                                            <div class="mt-2">
                                                <span class="badge badge-primary badge-lg">
                                                    <i class="fas fa-key"></i> {{ $systemSetting->key }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Tanggal Dibuat:</label>
                                            <p class="text-muted">{{ $systemSetting->created_at->format('d F Y, H:i') }} WIB
                                            </p>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Terakhir Diupdate:</label>
                                            <p class="text-muted">{{ $systemSetting->updated_at->format('d F Y, H:i') }} WIB
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Value:</label>
                                            @if ($systemSetting->value)
                                                <div class="mt-2 p-3 bg-light rounded">
                                                    <code
                                                        style="background: transparent; color: #333;">{{ $systemSetting->value }}</code>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada value</p>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Deskripsi:</label>
                                            @if ($systemSetting->description)
                                                <div class="mt-2 p-3 bg-light rounded">
                                                    {!! nl2br(e($systemSetting->description)) !!}
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
                                        <a href="{{ route('system-settings.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                        </a>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="{{ route('system-settings.edit', $systemSetting) }}"
                                            class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-danger"
                                            onclick="deleteData({{ $systemSetting->id }})">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Tips Penggunaan</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h6 class="text-white mb-0">
                                                    <i class="fas fa-lightbulb"></i> Format Key
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <small class="text-muted">
                                                    Gunakan format snake_case untuk key, contoh: app_name, max_file_size,
                                                    email_from
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <h6 class="text-white mb-0">
                                                    <i class="fas fa-code"></i> Value Format
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <small class="text-muted">
                                                    Value dapat berupa string, number, boolean, atau JSON tergantung
                                                    kebutuhan aplikasi
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-warning">
                                            <div class="card-header">
                                                <h6 class="text-white mb-0">
                                                    <i class="fas fa-exclamation-triangle"></i> Perhatian
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <small class="text-muted">
                                                    Pastikan key yang dibuat tidak duplikat dan sesuai dengan kebutuhan
                                                    sistem
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
                    <p>Apakah Anda yakin ingin menghapus pengaturan ini?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Peringatan:</strong> Menghapus pengaturan sistem dapat mempengaruhi fungsionalitas aplikasi!
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
    <script>
        function deleteData(id) {
            $('#deleteForm').attr('action', '{{ route('system-settings.destroy', ':id') }}'.replace(':id', id));
            $('#deleteModal').modal('show');
        }
    </script>
@endpush
