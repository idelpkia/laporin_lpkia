@extends('layouts.app')

@section('title', 'Daftar Banding')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Banding</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Banding</div>
                </div>
            </div>
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Menunggu Review</h4>
                            </div>
                            <div class="card-body">
                                {{ $appeals->where('appeal_status', 'submitted')->count() }}
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
                                <h4>Dalam Review</h4>
                            </div>
                            <div class="card-body">
                                {{ $appeals->where('appeal_status', 'under_review')->count() }}
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
                                {{ $appeals->where('appeal_status', 'approved')->count() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Ditolak</h4>
                            </div>
                            <div class="card-body">
                                {{ $appeals->where('appeal_status', 'rejected')->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Banding Pelaporan</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('appeals.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Ajukan Banding
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Filter Section -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <select class="form-control" id="statusFilter">
                                            <option value="">Semua Status</option>
                                            <option value="submitted">Diajukan</option>
                                            <option value="under_review">Dalam Review</option>
                                            <option value="approved">Disetujui</option>
                                            <option value="rejected">Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" id="dateFilter"
                                            placeholder="Filter Tanggal">
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped" id="appealsTable">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>ID Laporan</th>
                                                <th>Pemohon</th>
                                                <th>Tanggal Banding</th>
                                                <th>Status</th>
                                                <th>Reviewer</th>
                                                <th>Tanggal Review</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($appeals as $key => $appeal)
                                                <tr>
                                                    <td class="text-center">{{ $appeals->firstItem() + $key }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="badge badge-secondary mr-2">
                                                                #{{ $appeal->report->id ?? 'N/A' }}
                                                            </div>
                                                            <div>
                                                                <small class="text-muted">
                                                                    {{ Str::limit($appeal->report->title ?? 'Laporan tidak ditemukan', 30) }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <figure class="avatar avatar-sm mr-2">
                                                                <img alt="image"
                                                                    src="{{ $appeal->appellant->avatar ?? asset('img/avatar/avatar-1.png') }}"
                                                                    class="rounded-circle">
                                                            </figure>
                                                            <div>
                                                                <div class="font-weight-600">
                                                                    {{ $appeal->appellant->name ?? 'Unknown' }}</div>
                                                                <small
                                                                    class="text-muted">{{ $appeal->appellant->email ?? '' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            {{ \Carbon\Carbon::parse($appeal->appeal_date)->format('d/m/Y') }}
                                                        </div>
                                                        <small
                                                            class="text-muted">{{ \Carbon\Carbon::parse($appeal->appeal_date)->diffForHumans() }}</small>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusClass = [
                                                                'submitted' => 'badge-warning',
                                                                'under_review' => 'badge-info',
                                                                'approved' => 'badge-success',
                                                                'rejected' => 'badge-danger',
                                                            ];
                                                            $statusText = [
                                                                'submitted' => 'Diajukan',
                                                                'under_review' => 'Dalam Review',
                                                                'approved' => 'Disetujui',
                                                                'rejected' => 'Ditolak',
                                                            ];
                                                        @endphp
                                                        <div
                                                            class="badge {{ $statusClass[$appeal->appeal_status] ?? 'badge-secondary' }}">
                                                            {{ $statusText[$appeal->appeal_status] ?? $appeal->appeal_status }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($appeal->reviewer)
                                                            <div class="d-flex align-items-center">
                                                                <figure class="avatar avatar-sm mr-2">
                                                                    <img alt="image"
                                                                        src="{{ $appeal->reviewer->avatar ?? asset('img/avatar/avatar-1.png') }}"
                                                                        class="rounded-circle">
                                                                </figure>
                                                                <div>
                                                                    <div class="font-weight-600">
                                                                        {{ $appeal->reviewer->name }}</div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">Belum ada</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($appeal->review_date)
                                                            <div>
                                                                {{ \Carbon\Carbon::parse($appeal->review_date)->format('d/m/Y') }}
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ \Carbon\Carbon::parse($appeal->review_date)->diffForHumans() }}</small>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="#" data-toggle="dropdown"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a href="{{ route('appeals.show', $appeal) }}"
                                                                    class="dropdown-item">
                                                                    <i class="fas fa-eye"></i> Detail
                                                                </a>
                                                                @if (auth()->user()->can('review-appeal') && in_array($appeal->appeal_status, ['submitted', 'under_review']))
                                                                    <a href="{{ route('appeals.edit', $appeal) }}"
                                                                        class="dropdown-item">
                                                                        <i class="fas fa-edit"></i> Review
                                                                    </a>
                                                                @endif
                                                                @if (auth()->id() == $appeal->appellant_id && $appeal->appeal_status == 'submitted')
                                                                    <div class="dropdown-divider"></div>
                                                                    <form action="{{ route('appeals.destroy', $appeal) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item text-danger"
                                                                            onclick="return confirm('Yakin ingin menghapus banding ini?')">
                                                                            <i class="fas fa-trash"></i> Hapus
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center">
                                    {{ $appeals->links() }}
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Filter functionality
            $('#statusFilter').on('change', function() {
                var status = $(this).val();
                if (status) {
                    $('tbody tr').hide();
                    $('tbody tr td:nth-child(5) .badge').each(function() {
                        if ($(this).hasClass('badge-' + getStatusClass(status))) {
                            $(this).closest('tr').show();
                        }
                    });
                } else {
                    $('tbody tr').show();
                }
            });

            function getStatusClass(status) {
                const classes = {
                    'submitted': 'warning',
                    'under_review': 'info',
                    'approved': 'success',
                    'rejected': 'danger'
                };
                return classes[status] || 'secondary';
            }

            // Date filter
            $('#dateFilter').on('change', function() {
                var selectedDate = $(this).val();
                if (selectedDate) {
                    $('tbody tr').hide();
                    $('tbody tr').each(function() {
                        var rowDate = $(this).find('td:nth-child(4) div').first().text();
                        var formattedDate = convertToISO(rowDate);
                        if (formattedDate === selectedDate) {
                            $(this).show();
                        }
                    });
                } else {
                    $('tbody tr').show();
                }
            });

            function convertToISO(dateStr) {
                var parts = dateStr.split('/');
                return parts[2] + '-' + parts[1].padStart(2, '0') + '-' + parts[0].padStart(2, '0');
            }
        });
    </script>
@endpush
