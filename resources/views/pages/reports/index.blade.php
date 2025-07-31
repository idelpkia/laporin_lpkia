@extends('layouts.app')

@section('title', 'Daftar Laporan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Laporan</h1>
                @if (auth()->user()->role !== 'admin')
                    <div class="section-header-button">
                        <a href="{{ route('reports.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Buat Laporan
                        </a>
                    </div>
                @endif
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Laporan</div>
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
                                    <h4>Total Laporan</h4>
                                </div>
                                <div class="card-body">
                                    {{ $reports->total() }}
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
                                    <h4>Pending</h4>
                                </div>
                                <div class="card-body">
                                    {{ $reports->where('status', 'pending')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Dalam Investigasi</h4>
                                </div>
                                <div class="card-body">
                                    {{ $reports->where('status', 'investigating')->count() }}
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
                                    <h4>Selesai</h4>
                                </div>
                                <div class="card-body">
                                    {{ $reports->where('status', 'completed')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>
                                    @if (auth()->user()->role === 'student')
                                        Laporan Saya
                                    @else
                                        Semua Laporan
                                    @endif
                                </h4>
                                <div class="card-header-form">
                                    <form method="GET" action="{{ route('reports.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Cari laporan..."
                                                name="search" value="{{ request('search') }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Filter Section -->
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <form method="GET" action="{{ route('reports.index') }}" class="form-inline">
                                            <input type="hidden" name="search" value="{{ request('search') }}">

                                            <div class="form-group mr-2">
                                                <label class="mr-1">Status:</label>
                                                <select name="status" class="form-control selectric">
                                                    <option value="">Semua Status</option>
                                                    <option value="draft"
                                                        {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                    <option value="submitted"
                                                        {{ request('status') == 'submitted' ? 'selected' : '' }}>Disubmit
                                                    </option>
                                                    <option value="under_review"
                                                        {{ request('status') == 'under_review' ? 'selected' : '' }}>Dalam
                                                        Review</option>
                                                    <option value="investigating"
                                                        {{ request('status') == 'investigating' ? 'selected' : '' }}>
                                                        Investigasi</option>
                                                    <option value="completed"
                                                        {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai
                                                    </option>
                                                    <option value="rejected"
                                                        {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="form-group mr-2">
                                                <label class="mr-1">Tipe Pelapor:</label>
                                                <select name="reported_person_type" class="form-control selectric">
                                                    <option value="">Semua Tipe</option>
                                                    <option value="student"
                                                        {{ request('reported_person_type') == 'student' ? 'selected' : '' }}>
                                                        Mahasiswa</option>
                                                    <option value="lecturer"
                                                        {{ request('reported_person_type') == 'lecturer' ? 'selected' : '' }}>
                                                        Dosen</option>
                                                    <option value="staff"
                                                        {{ request('reported_person_type') == 'staff' ? 'selected' : '' }}>
                                                        Staff</option>
                                                </select>
                                            </div>

                                            <div class="form-group mr-2">
                                                <label class="mr-1">Metode:</label>
                                                <select name="submission_method" class="form-control selectric">
                                                    <option value="">Semua Metode</option>
                                                    <option value="online"
                                                        {{ request('submission_method') == 'online' ? 'selected' : '' }}>
                                                        Online</option>
                                                    <option value="offline"
                                                        {{ request('submission_method') == 'offline' ? 'selected' : '' }}>
                                                        Offline</option>
                                                    <option value="anonymous"
                                                        {{ request('submission_method') == 'anonymous' ? 'selected' : '' }}>
                                                        Anonim</option>
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary mr-1">Filter</button>
                                            <a href="{{ route('reports.index') }}" class="btn btn-secondary">Reset</a>
                                        </form>
                                    </div>
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No. Laporan</th>
                                                <th>Judul</th>
                                                <th>Pelapor</th>
                                                <th>Dilaporkan</th>
                                                <th>Jenis Pelanggaran</th>
                                                <th>Tanggal Kejadian</th>
                                                <th>Status</th>
                                                <th>Metode</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($reports as $report)
                                                <tr>
                                                    <td>
                                                        <strong class="text-primary">
                                                            {{ $report->report_number ?? 'RPT-' . str_pad($report->id, 5, '0', STR_PAD_LEFT) }}
                                                        </strong>
                                                    </td>
                                                    <td>
                                                        <div class="font-weight-600">
                                                            {{ Str::limit($report->title, 30) }}
                                                        </div>
                                                        @if ($report->description)
                                                            <div class="text-muted small">
                                                                {{ Str::limit($report->description, 50) }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($report->reporter)
                                                            <div class="font-weight-600">{{ $report->reporter->name }}
                                                            </div>
                                                            <div class="text-muted small">{{ $report->reporter->role }}
                                                            </div>
                                                        @else
                                                            <span class="text-muted">Anonim</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="font-weight-600">{{ $report->reported_person_name }}
                                                        </div>
                                                        <div class="text-muted small">
                                                            {{ ucfirst($report->reported_person_type) }}
                                                        </div>
                                                        @if ($report->reported_person_email)
                                                            <div class="text-muted small">
                                                                {{ $report->reported_person_email }}</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($report->violationType)
                                                            <span class="badge badge-warning">
                                                                {{ $report->violationType->name }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($report->incident_date)
                                                            {{ \Carbon\Carbon::parse($report->incident_date)->format('d/m/Y') }}
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusColors = [
                                                                'draft' => 'secondary',
                                                                'submitted' => 'info',
                                                                'under_review' => 'warning',
                                                                'investigating' => 'primary',
                                                                'completed' => 'success',
                                                                'rejected' => 'danger',
                                                            ];
                                                            $statusLabels = [
                                                                'draft' => 'Draft',
                                                                'submitted' => 'Disubmit',
                                                                'under_review' => 'Review',
                                                                'investigating' => 'Investigasi',
                                                                'completed' => 'Selesai',
                                                                'rejected' => 'Ditolak',
                                                            ];
                                                        @endphp
                                                        <span
                                                            class="badge badge-{{ $statusColors[$report->status] ?? 'secondary' }}">
                                                            {{ $statusLabels[$report->status] ?? ucfirst($report->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $methodIcons = [
                                                                'online' => 'fas fa-globe text-primary',
                                                                'offline' => 'fas fa-file-alt text-info',
                                                                'anonymous' => 'fas fa-user-secret text-warning',
                                                            ];
                                                        @endphp
                                                        <i class="{{ $methodIcons[$report->submission_method] ?? 'fas fa-question text-muted' }}"
                                                            data-toggle="tooltip"
                                                            title="{{ ucfirst($report->submission_method) }}"></i>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('reports.show', $report) }}"
                                                                class="btn btn-info btn-sm" data-toggle="tooltip"
                                                                title="Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </a>

                                                            @if (auth()->user()->role === 'student' && $report->reporter_id === auth()->id() && $report->status === 'draft')
                                                                <a href="{{ route('reports.edit', $report) }}"
                                                                    class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                                    title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif

                                                            @if (auth()->user()->role === 'admin' ||
                                                                    (auth()->user()->role === 'student' && $report->reporter_id === auth()->id() && $report->status === 'draft'))
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#deleteModal{{ $report->id }}"
                                                                    title="Hapus">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @endif

                                                            @if ($report->reportDocuments->count() > 0)
                                                                <a href="{{ route('reports.documents', $report) }}"
                                                                    class="btn btn-secondary btn-sm" data-toggle="tooltip"
                                                                    title="Dokumen ({{ $report->reportDocuments->count() }})">
                                                                    <i class="fas fa-paperclip"></i>
                                                                </a>
                                                            @endif
                                                        </div>

                                                        <!-- Delete Modal -->
                                                        @if (auth()->user()->role === 'admin' ||
                                                                (auth()->user()->role === 'student' && $report->reporter_id === auth()->id() && $report->status === 'draft'))
                                                            <div class="modal fade" id="deleteModal{{ $report->id }}"
                                                                tabindex="-1" role="dialog">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal">
                                                                                <span>&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Apakah Anda yakin ingin menghapus laporan
                                                                                <strong>{{ $report->title }}</strong>?
                                                                            </p>
                                                                            <p class="text-danger"><small>Tindakan ini
                                                                                    tidak dapat dibatalkan.</small></p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">Batal</button>
                                                                            <form
                                                                                action="{{ route('reports.destroy', $report) }}"
                                                                                method="POST" class="d-inline">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-danger">Hapus</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">
                                                        <div class="empty-state" data-height="200">
                                                            <div class="empty-state-icon">
                                                                <i class="fas fa-file-alt"></i>
                                                            </div>
                                                            <h2>Tidak ada laporan</h2>
                                                            <p class="lead">
                                                                @if (auth()->user()->role === 'student')
                                                                    Anda belum membuat laporan apapun.
                                                                @else
                                                                    Belum ada laporan yang masuk.
                                                                @endif
                                                            </p>
                                                            @if (auth()->user()->role !== 'admin')
                                                                <a href="{{ route('reports.create') }}"
                                                                    class="btn btn-primary mt-4">
                                                                    <i class="fas fa-plus"></i> Buat Laporan Baru
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center">
                                    {{ $reports->appends(request()->query())->links() }}
                                </div>
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
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            // Initialize selectric
            $('.selectric').selectric();

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Confirm before delete
            $('.btn-danger[data-target*="deleteModal"]').on('click', function() {
                const reportTitle = $(this).closest('tr').find('td:eq(1) .font-weight-600').text();
                const modal = $($(this).data('target'));
                modal.find('.modal-body strong').text(reportTitle);
            });
        });
    </script>
@endpush
