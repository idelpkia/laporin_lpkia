@extends('layouts.app')

@section('title', 'Dashboard Pelapor')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard Pelapor</h1>
            </div>
            <div class="section-body">

                {{-- Stat Cards --}}
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Laporan Saya</h4>
                                </div>
                                <div class="card-body">
                                    {{ $myReportsCount ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Proses Investigasi</h4>
                                </div>
                                <div class="card-body">
                                    {{ $myInvestigationCount ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Laporan Selesai</h4>
                                </div>
                                <div class="card-body">
                                    {{ $myCompletedCount ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabel Riwayat Laporan --}}
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Riwayat Laporan Saya</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('reports.create') }}" class="btn btn-primary">Buat Laporan Baru</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No. Laporan</th>
                                                <th>Judul</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($myReports ?? [] as $report)
                                                <tr>
                                                    <td>{{ $report->report_number }}</td>
                                                    <td>{{ $report->title }}</td>
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $report->status == 'completed' ? 'success' : ($report->status == 'rejected' ? 'danger' : 'warning') }}">
                                                            {{ ucfirst($report->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $report->created_at->format('d-m-Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('reports.show', $report) }}"
                                                            class="btn btn-info btn-sm">Detail</a>
                                                        @if ($report->status == 'completed' && !$report->appeals->count())
                                                            <a href="{{ route('appeals.create', ['report_id' => $report->id]) }}"
                                                                class="btn btn-warning btn-sm">Ajukan Banding</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Belum ada laporan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Panel Notifikasi --}}
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Notifikasi</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled list-unstyled-border">
                                    @forelse($notifications ?? [] as $notif)
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="float-right text-primary">
                                                    {{ $notif->created_at->diffForHumans() }}
                                                </div>
                                                <div class="media-title">{{ $notif->title }}</div>
                                                <span class="text-small text-muted">{{ $notif->message }}</span>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-title text-muted">Tidak ada notifikasi.</div>
                                            </div>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabel Banding (Jika Ada) --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Banding Saya</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No. Laporan</th>
                                                <th>Tanggal Banding</th>
                                                <th>Status Banding</th>
                                                <th>Hasil Review</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($myAppeals ?? [] as $appeal)
                                                <tr>
                                                    <td>{{ $appeal->report->report_number ?? '-' }}</td>
                                                    <td>{{ $appeal->appeal_date }}</td>
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $appeal->appeal_status == 'approved' ? 'success' : ($appeal->appeal_status == 'rejected' ? 'danger' : 'warning') }}">
                                                            {{ ucfirst($appeal->appeal_status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $appeal->review_result ?? '-' }}</td>
                                                    <td>
                                                        <a href="{{ route('appeals.show', $appeal) }}"
                                                            class="btn btn-info btn-sm">Detail</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Belum ada data banding.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
