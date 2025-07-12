@extends('layouts.app')

@section('title', 'Dashboard KIA Member')

@section('main')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard KIA Member</h1>
        </div>
        <div class="section-body">

            {{-- Stat Cards --}}
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Laporan Masuk</h4>
                            </div>
                            <div class="card-body">
                                {{ $incomingReports ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Perlu Validasi</h4>
                            </div>
                            <div class="card-body">
                                {{ $pendingValidations ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Investigasi Aktif</h4>
                            </div>
                            <div class="card-body">
                                {{ $activeInvestigations ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Penetapan Sanksi</h4>
                            </div>
                            <div class="card-body">
                                {{ $penaltiesToSet ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Laporan Terbaru --}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Laporan Terbaru</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No. Laporan</th>
                                            <th>Pelapor</th>
                                            <th>Status</th>
                                            <th>Tgl Masuk</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentReports ?? [] as $report)
                                            <tr>
                                                <td>{{ $report->report_number }}</td>
                                                <td>{{ $report->reporter->name ?? '-' }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $report->status == 'submitted' ? 'warning' : 'success' }}">
                                                        {{ ucfirst($report->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $report->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    <a href="{{ route('reports.show', $report) }}"
                                                        class="btn btn-primary btn-sm">Detail</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada laporan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabel Investigasi Aktif --}}
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Investigasi Aktif</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Laporan</th>
                                            <th>Ketua Tim</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($activeInvestigationsTable ?? [] as $investigation)
                                            <tr>
                                                <td>{{ $investigation->report->report_number ?? '-' }}</td>
                                                <td>{{ $investigation->teamLeader->name ?? '-' }}</td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        {{ ucfirst($investigation->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('investigations.show', $investigation) }}"
                                                        class="btn btn-info btn-sm">Detail</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada investigasi.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Panel Notifikasi --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Notifikasi</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @forelse($notifications ?? [] as $notif)
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="float-right text-primary">{{ $notif->created_at->diffForHumans() }}
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

        </div>
    </section>
@endsection
