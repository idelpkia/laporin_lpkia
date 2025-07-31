@extends('layouts.app')

@section('title', 'Daftar Sanksi')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manajemen Sanksi</h1>
                <div class="section-header-button">
                    <a href="{{ route('penalties.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Sanksi
                    </a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Sanksi</div>
                </div>
            </div>

            <div class="section-body">
                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-file-alt"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Sanksi</h4>
                                </div>
                                <div class="card-body">
                                    {{ $penalties->total() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="far fa-clock"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Direkomendasikan</h4>
                                </div>
                                <div class="card-body">
                                    {{ $penalties->where('status', 'recommended')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Disetujui</h4>
                                </div>
                                <div class="card-body">
                                    {{ $penalties->where('status', 'approved')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-play"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Dijalankan</h4>
                                </div>
                                <div class="card-body">
                                    {{ $penalties->where('status', 'executed')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-filter"></i> Filter & Pencarian</h4>
                                <div class="card-header-action">
                                    <a data-collapse="#filter-collapse" class="btn btn-icon btn-outline-primary"
                                        href="#"><i class="fas fa-minus"></i></a>
                                </div>
                            </div>
                            <div class="collapse show" id="filter-collapse">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('penalties.index') }}">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status" class="form-control select2">
                                                        <option value="">Semua Status</option>
                                                        <option value="recommended"
                                                            {{ request('status') == 'recommended' ? 'selected' : '' }}>
                                                            Direkomendasikan</option>
                                                        <option value="approved"
                                                            {{ request('status') == 'approved' ? 'selected' : '' }}>
                                                            Disetujui</option>
                                                        <option value="executed"
                                                            {{ request('status') == 'executed' ? 'selected' : '' }}>
                                                            Dijalankan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Tingkat Sanksi</label>
                                                    <select name="penalty_level" class="form-control select2">
                                                        <option value="">Semua Tingkat</option>
                                                        @foreach (\App\Models\PenaltyLevel::all() as $level)
                                                            <option value="{{ $level->id }}"
                                                                {{ request('penalty_level') == $level->id ? 'selected' : '' }}>
                                                                {{ $level->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Pencarian</label>
                                                    <input type="text" name="search" class="form-control"
                                                        placeholder="Cari jenis sanksi..." value="{{ request('search') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <div class="d-block">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-search"></i> Filter
                                                        </button>
                                                        <a href="{{ route('penalties.index') }}" class="btn btn-secondary">
                                                            <i class="fas fa-undo"></i> Reset
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Data Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-list"></i> Data Sanksi</h4>
                                <div class="card-header-action">
                                    <div class="dropdown">
                                        <a href="#" data-toggle="dropdown"
                                            class="btn btn-outline-primary dropdown-toggle">
                                            <i class="fas fa-download"></i> Export
                                        </a>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-file-excel"></i> Excel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                                        </div>
                                    </div>
                                @endif

                                @if ($penalties->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="50">#</th>
                                                    <th width="200">Laporan</th>
                                                    <th width="150">Tingkat Sanksi</th>
                                                    <th>Jenis Sanksi</th>
                                                    <th width="120">Status</th>
                                                    <th width="130">Tanggal Rekomen</th>
                                                    <th width="150">Diputuskan Oleh</th>
                                                    <th width="120">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($penalties as $penalty)
                                                    <tr>
                                                        <td class="text-center">
                                                            <div class="badge badge-light">
                                                                {{ $loop->iteration + ($penalties->currentPage() - 1) * $penalties->perPage() }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="media">
                                                                <div class="media-icon">
                                                                    <i class="fas fa-file-alt text-primary"></i>
                                                                </div>
                                                                <div class="media-body">
                                                                    <div class="media-title font-weight-bold">
                                                                        {{ Str::limit($penalty->report->title ?? 'N/A', 30) }}
                                                                    </div>
                                                                    <div class="text-muted text-small">
                                                                        ID: {{ $penalty->report_id }}
                                                                        @if ($penalty->report->created_at)
                                                                            •
                                                                            {{ $penalty->report->created_at->diffForHumans() }}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-info badge-lg">
                                                                {{ $penalty->penaltyLevel->name ?? 'N/A' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="font-weight-bold">{{ $penalty->penalty_type }}
                                                            </div>
                                                            @if ($penalty->sk_number)
                                                                <div class="text-muted text-small">
                                                                    <i class="fas fa-certificate"></i>
                                                                    {{ $penalty->sk_number }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($penalty->status == 'recommended')
                                                                <span class="badge badge-warning">
                                                                    <i class="far fa-clock"></i> Direkomendasikan
                                                                </span>
                                                            @elseif($penalty->status == 'approved')
                                                                <span class="badge badge-success">
                                                                    <i class="fas fa-check"></i> Disetujui
                                                                </span>
                                                            @elseif($penalty->status == 'executed')
                                                                <span class="badge badge-primary">
                                                                    <i class="fas fa-play"></i> Dijalankan
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($penalty->recommendation_date)
                                                                <div class="font-weight-bold">
                                                                    {{ \Carbon\Carbon::parse($penalty->recommendation_date)->format('d M Y') }}
                                                                </div>
                                                                <div class="text-muted text-small">
                                                                    {{ \Carbon\Carbon::parse($penalty->recommendation_date)->diffForHumans() }}
                                                                </div>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar avatar-sm mr-2">
                                                                    <img alt="image"
                                                                        src="{{ asset('img/avatar/avatar-1.png') }}"
                                                                        class="rounded-circle">
                                                                </div>
                                                                <div>
                                                                    <div class="font-weight-bold text-small">
                                                                        {{ $penalty->decider->name ?? 'N/A' }}
                                                                    </div>
                                                                    <div class="text-muted text-smaller">
                                                                        {{ Str::limit($penalty->decider->email ?? '', 20) }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <a href="#" data-toggle="dropdown"
                                                                    class="btn btn-primary btn-sm dropdown-toggle">
                                                                    <i class="fas fa-cog"></i>
                                                                </a>
                                                                <div class="dropdown-menu">
                                                                    <a href="{{ route('penalties.show', $penalty) }}"
                                                                        class="dropdown-item">
                                                                        <i class="fas fa-eye text-info"></i> Detail
                                                                    </a>
                                                                    <a href="{{ route('penalties.edit', $penalty) }}"
                                                                        class="dropdown-item">
                                                                        <i class="fas fa-edit text-warning"></i> Edit
                                                                    </a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <form
                                                                        action="{{ route('penalties.destroy', $penalty) }}"
                                                                        method="POST" style="display: inline;"
                                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus sanksi ini?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item text-danger">
                                                                            <i class="fas fa-trash"></i> Hapus
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination Info & Links -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Menampilkan {{ $penalties->firstItem() }} sampai {{ $penalties->lastItem() }}
                                            dari {{ $penalties->total() }} data
                                        </div>
                                        <div>
                                            {{ $penalties->appends(request()->query())->links() }}
                                        </div>
                                    </div>
                                @else
                                    <div class="empty-state" data-height="400">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-question"></i>
                                        </div>
                                        <h2>Belum Ada Data Sanksi</h2>
                                        <p class="lead">
                                            Belum ada sanksi yang terdaftar dalam sistem.
                                            Mulai dengan menambahkan sanksi pertama.
                                        </p>
                                        <a href="{{ route('penalties.create') }}" class="btn btn-primary mt-4">
                                            <i class="fas fa-plus"></i> Tambah Sanksi Pertama
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#table-1').DataTable({
                "paging": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "order": [
                    [5, "desc"]
                ],
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 7]
                }]
            });

            // Initialize Select2
            $('.select2').select2({
                width: '100%'
            });

            // Auto submit form on select change
            $('select[name="status"], select[name="penalty_level"]').on('change', function() {
                $(this).closest('form').submit();
            });
        });
    </script>
@endpush
