@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('main')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard Admin</h1>
        </div>

        <div class="section-body">

            {{-- Stat Cards --}}
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Laporan</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalReports ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-search"></i>
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
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total User</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUsers ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Sanksi</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalPenalties ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grafik dan Tabel --}}
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik Laporan per Bulan</h4>
                        </div>
                        <div class="card-body">
                            {{-- Tempatkan chart.js atau grafik lain di sini --}}
                            <canvas id="chartReports"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Status Investigasi</h4>
                        </div>
                        <div class="card-body">
                            {{-- Pie/Donut Chart --}}
                            <canvas id="chartInvestigationStatus"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Log atau Tabel Aktivitas Terbaru --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Aktivitas Terbaru</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Waktu</th>
                                            <th>User</th>
                                            <th>Aksi</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentActivities ?? [] as $log)
                                            <tr>
                                                <td>{{ $log->created_at }}</td>
                                                <td>{{ $log->user->name ?? '-' }}</td>
                                                <td>{{ $log->action ?? '-' }}</td>
                                                <td>{{ $log->notes ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada aktivitas</td>
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
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Contoh chart untuk laporan per bulan
        var ctx = document.getElementById('chartReports').getContext('2d');
        var chartReports = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($reportChartLabels ?? []),
                datasets: [{
                    label: 'Laporan',
                    data: @json($reportChartData ?? []),
                    borderWidth: 2,
                    fill: false,
                }]
            },
            options: {
                responsive: true
            }
        });

        // Contoh chart untuk status investigasi
        var ctxStatus = document.getElementById('chartInvestigationStatus').getContext('2d');
        var chartInvestigationStatus = new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: @json($investigationStatusLabels ?? []),
                datasets: [{
                    data: @json($investigationStatusData ?? []),
                    backgroundColor: ['#6777ef', '#47c363', '#ffa426', '#fc544b', '#63ed7a'],
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endpush
