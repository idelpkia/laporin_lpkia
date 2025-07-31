@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pengaturan Sistem</h1>
                <div class="section-header-button">
                    <a href="{{ route('system-settings.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pengaturan
                    </a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Pengaturan Sistem</div>
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
                                <h4>Data Pengaturan Sistem</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Key</th>
                                                <th>Value</th>
                                                <th>Deskripsi</th>
                                                <th>Tanggal Dibuat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($systemSettings as $setting)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $loop->iteration + ($systemSettings->currentPage() - 1) * $systemSettings->perPage() }}
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-primary">{{ $setting->key }}</span>
                                                    </td>
                                                    <td>
                                                        @if (strlen($setting->value) > 50)
                                                            {{ Str::limit($setting->value, 50) }}
                                                        @else
                                                            {{ $setting->value ?? '-' }}
                                                        @endif
                                                    </td>
                                                    <td>{{ Str::limit($setting->description ?? '-', 40) }}</td>
                                                    <td>{{ $setting->created_at->format('d M Y H:i') }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('system-settings.show', $setting) }}"
                                                                class="btn btn-info btn-sm" title="Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('system-settings.edit', $setting) }}"
                                                                class="btn btn-warning btn-sm" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="deleteData({{ $setting->id }})" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                @if ($systemSettings->hasPages())
                                    <div class="card-footer text-right">
                                        <nav class="d-inline-block">
                                            {{ $systemSettings->links('pagination::bootstrap-4') }}
                                        </nav>
                                    </div>
                                @endif
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
                    Apakah Anda yakin ingin menghapus pengaturan ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#table-1").DataTable({
                "pageLength": 10,
                "searching": true,
                "ordering": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });
        });

        function deleteData(id) {
            $('#deleteForm').attr('action', '{{ route('system-settings.destroy', ':id') }}'.replace(':id', id));
            $('#deleteModal').modal('show');
        }
    </script>
@endpush
