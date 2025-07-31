@extends('layouts.app')

@section('title', 'Daftar Investigasi')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manajemen Investigasi</h1>
                <div class="section-header-button">
                    <a href="{{ route('investigations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Investigasi
                    </a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Investigasi</div>
                </div>
            </div>

            <div class="section-body">
                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Investigasi</h4>
                                </div>
                                <div class="card-body">
                                    {{ $investigations->total() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Sedang Berjalan</h4>
                                </div>
                                <div class="card-body">
                                    {{ $investigations->whereNotIn('status', ['completed'])->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Selesai</h4>
                                </div>
                                <div class="card-body">
                                    {{ $investigations->where('status', 'completed')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Tim Aktif</h4>
                                </div>
                                <div class="card-body">
                                    {{ $investigations->whereNotIn('status', ['completed'])->count() }}
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
                                <h4><i class="fas fa-list"></i> Data Investigasi</h4>
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

                                @if ($investigations->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="50">#</th>
                                                    <th width="200">Laporan</th>
                                                    <th width="150">Ketua Tim</th>
                                                    <th width="120">Status</th>
                                                    <th width="130">Tanggal Mulai</th>
                                                    <th width="130">Tanggal Selesai</th>
                                                    <th width="100">Progress</th>
                                                    <th width="120">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($investigations as $investigation)
                                                    <tr>
                                                        <td class="text-center">
                                                            <div class="badge badge-light">
                                                                {{ $loop->iteration + ($investigations->currentPage() - 1) * $investigations->perPage() }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="media">
                                                                <div class="media-icon">
                                                                    <i class="fas fa-file-alt text-primary"></i>
                                                                </div>
                                                                <div class="media-body">
                                                                    <div class="media-title font-weight-bold">
                                                                        {{ Str::limit($investigation->report->title ?? 'N/A', 30) }}
                                                                    </div>
                                                                    <div class="text-muted text-small">
                                                                        ID: {{ $investigation->report_id }}
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                                                        {{ $investigation->teamLeader->name ?? 'N/A' }}
                                                                    </div>
                                                                    <div class="text-muted text-smaller">
                                                                        Leader
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if ($investigation->status == 'formed')
                                                                <span class="badge badge-secondary">
                                                                    <i class="fas fa-users"></i> Dibentuk
                                                                </span>
                                                            @elseif($investigation->status == 'document_review')
                                                                <span class="badge badge-info">
                                                                    <i class="fas fa-file-search"></i> Review Dokumen
                                                                </span>
                                                            @elseif($investigation->status == 'calling_parties')
                                                                <span class="badge badge-warning">
                                                                    <i class="fas fa-phone"></i> Pemanggilan
                                                                </span>
                                                            @elseif($investigation->status == 'report_writing')
                                                                <span class="badge badge-primary">
                                                                    <i class="fas fa-edit"></i> Penulisan Laporan
                                                                </span>
                                                            @elseif($investigation->status == 'completed')
                                                                <span class="badge badge-success">
                                                                    <i class="fas fa-check"></i> Selesai
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($investigation->start_date)
                                                                <div class="font-weight-bold">
                                                                    {{ \Carbon\Carbon::parse($investigation->start_date)->format('d M Y') }}
                                                                </div>
                                                                <div class="text-muted text-small">
                                                                    {{ \Carbon\Carbon::parse($investigation->start_date)->diffForHumans() }}
                                                                </div>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($investigation->end_date)
                                                                <div class="font-weight-bold">
                                                                    {{ \Carbon\Carbon::parse($investigation->end_date)->format('d M Y') }}
                                                                </div>
                                                                <div class="text-muted text-small">
                                                                    {{ \Carbon\Carbon::parse($investigation->end_date)->diffForHumans() }}
                                                                </div>
                                                            @else
                                                                <span class="text-muted">Belum selesai</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $statuses = [
                                                                    'formed',
                                                                    'document_review',
                                                                    'calling_parties',
                                                                    'report_writing',
                                                                    'completed',
                                                                ];
                                                                $currentIndex = array_search(
                                                                    $investigation->status,
                                                                    $statuses,
                                                                );
                                                                $progress =
                                                                    (($currentIndex + 1) / count($statuses)) * 100;
                                                            @endphp
                                                            <div class="progress" data-height="6">
                                                                <div class="progress-bar 
                                                                    @if ($progress < 40) bg-danger
                                                                    @elseif($progress < 80) bg-warning
                                                                    @else bg-success @endif"
                                                                    data-width="{{ $progress }}%">
                                                                </div>
                                                            </div>
                                                            <div class="text-small text-muted mt-1">
                                                                {{ round($progress) }}%</div>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <a href="#" data-toggle="dropdown"
                                                                    class="btn btn-primary btn-sm dropdown-toggle">
                                                                    <i class="fas fa-cog"></i>
                                                                </a>
                                                                <div class="dropdown-menu">
                                                                    <a href="{{ route('investigations.show', $investigation) }}"
                                                                        class="dropdown-item">
                                                                        <i class="fas fa-eye text-info"></i> Detail
                                                                    </a>
                                                                    <a href="{{ route('investigations.edit', $investigation) }}"
                                                                        class="dropdown-item">
                                                                        <i class="fas fa-edit text-warning"></i> Edit
                                                                    </a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <form
                                                                        action="{{ route('investigations.destroy', $investigation) }}"
                                                                        method="POST" style="display: inline;"
                                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus investigasi ini?')">
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
                                            Menampilkan {{ $investigations->firstItem() }} sampai
                                            {{ $investigations->lastItem() }}
                                            dari {{ $investigations->total() }} data
                                        </div>
                                        <div>
                                            {{ $investigations->links() }}
                                        </div>
                                    </div>
                                @else
                                    <div class="empty-state" data-height="400">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <h2>Belum Ada Investigasi</h2>
                                        <p class="lead">
                                            Belum ada investigasi yang terdaftar dalam sistem.
                                            Mulai dengan membuat investigasi pertama.
                                        </p>
                                        <a href="{{ route('investigations.create') }}" class="btn btn-primary mt-4">
                                            <i class="fas fa-plus"></i> Buat Investigasi Pertama
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

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('#table-1').DataTable({
                "paging": false,
                "searching": true,
                "ordering": true,
                "info": false,
                "order": [
                    [4, "desc"]
                ],
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 6, 7]
                }]
            });
        });
    </script>
@endpush
