@extends('layouts.app')

@section('title', 'Dashboard Investigator')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard Investigator</h1>
            </div>
            <div class="section-body">

                {{-- Stat Cards --}}
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Investigasi Saya</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalInvestigations ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-spinner"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Aktif</h4>
                                </div>
                                <div class="card-body">
                                    {{ $activeInvestigations ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Selesai</h4>
                                </div>
                                <div class="card-body">
                                    {{ $completedInvestigations ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Daftar Investigasi Saya --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Investigasi Saya</h4>
                                <div class="card-header-action">
                                    {{-- Filter/status, jika diperlukan --}}
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Laporan</th>
                                                <th>Status</th>
                                                <th>Ketua Tim</th>
                                                <th>Deadline</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($myInvestigations ?? [] as $investigation)
                                                <tr>
                                                    <td>{{ $investigation->report->title ?? '-' }}</td>
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $investigation->status == 'completed' ? 'success' : 'info' }}">
                                                            {{ ucfirst($investigation->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $investigation->teamLeader->name ?? '-' }}</td>
                                                    <td>
                                                        @if ($investigation->end_date)
                                                            <span
                                                                class="text-danger">{{ $investigation->end_date->format('d-m-Y') }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('investigations.show', $investigation) }}"
                                                            class="btn btn-info btn-sm">Detail</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Belum ada investigasi.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Panel Aktivitas Saya --}}
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Aktivitas Terbaru Saya</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled list-unstyled-border">
                                    @forelse($myActivities ?? [] as $activity)
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-title">{{ $activity->activity_type }}</div>
                                                <span class="text-small text-muted">{{ $activity->activity_date }} -
                                                    {{ $activity->description }}</span>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="media-title text-muted">Belum ada aktivitas.</div>
                                            </div>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Notifikasi --}}
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

            </div>
        </section>
    </div>
@endsection
