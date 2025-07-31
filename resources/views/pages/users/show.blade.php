@extends('layouts.app')

@section('title', 'Detail User')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail User</h1>
                <div class="section-header-button">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Edit User</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <!-- User Information -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi User</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="30%"><strong>Nama</strong></td>
                                        <td>: {{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>: {{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Peran</strong></td>
                                        <td>: <span class="badge badge-primary">{{ ucfirst($user->role) }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Departemen</strong></td>
                                        <td>: {{ $user->department ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Telepon</strong></td>
                                        <td>: {{ $user->phone ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>:
                                            @if ($user->deleted_at)
                                                <span class="badge badge-danger">Nonaktif</span>
                                            @else
                                                <span class="badge badge-success">Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email Verified</strong></td>
                                        <td>:
                                            @if ($user->email_verified_at)
                                                <span class="badge badge-success">Terverifikasi</span>
                                                <br><small
                                                    class="text-muted">{{ $user->email_verified_at->format('d/m/Y H:i') }}</small>
                                            @else
                                                <span class="badge badge-warning">Belum Terverifikasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dibuat</strong></td>
                                        <td>: {{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diperbarui</strong></td>
                                        <td>: {{ $user->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Statistik Aktivitas</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-primary">
                                                <i class="far fa-file-alt"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4>Laporan</h4>
                                                </div>
                                                <div class="card-body">
                                                    {{ $user->reports->count() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-info">
                                                <i class="fas fa-search"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4>Investigasi</h4>
                                                </div>
                                                <div class="card-body">
                                                    {{ $user->leadInvestigations->count() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-warning">
                                                <i class="fas fa-gavel"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4>Keputusan</h4>
                                                </div>
                                                <div class="card-body">
                                                    {{ $user->decidedPenalties->count() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-success">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4>Tim</h4>
                                                </div>
                                                <div class="card-body">
                                                    {{ $user->investigationTeams->count() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Aktivitas Terkini</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Recent Reports -->
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Laporan Terbaru</h6>
                                        @if ($user->reports->take(5)->count() > 0)
                                            <div class="list-group">
                                                @foreach ($user->reports->take(5) as $report)
                                                    <div class="list-group-item">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <h6 class="mb-1">Laporan #{{ $report->id }}</h6>
                                                            <small>{{ $report->created_at->diffForHumans() }}</small>
                                                        </div>
                                                        <p class="mb-1">{{ $report->title ?? 'Tanpa judul' }}</p>
                                                        <small class="text-muted">Status:
                                                            {{ $report->status ?? 'Draft' }}</small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Belum ada laporan</p>
                                        @endif
                                    </div>

                                    <!-- Recent Investigations -->
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Investigasi yang Dipimpin</h6>
                                        @if ($user->leadInvestigations->take(5)->count() > 0)
                                            <div class="list-group">
                                                @foreach ($user->leadInvestigations->take(5) as $investigation)
                                                    <div class="list-group-item">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <h6 class="mb-1">Investigasi #{{ $investigation->id }}</h6>
                                                            <small>{{ $investigation->created_at->diffForHumans() }}</small>
                                                        </div>
                                                        <p class="mb-1">{{ $investigation->title ?? 'Tanpa judul' }}</p>
                                                        <small class="text-muted">Status:
                                                            {{ $investigation->status ?? 'Draft' }}</small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Belum memimpin investigasi</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit User
                                </a>
                                @if (!$user->deleted_at)
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#deleteModal">
                                        <i class="fas fa-trash"></i> Hapus User
                                    </button>
                                @else
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#restoreModal">
                                        <i class="fas fa-undo"></i> Pulihkan User
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Delete Modal -->
    @if (!$user->deleted_at)
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
                        <p>Apakah Anda yakin ingin menghapus user <strong>{{ $user->name }}</strong>?</p>
                        <p class="text-danger"><small>User yang dihapus masih dapat dipulihkan.</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Restore Modal -->
    @if ($user->deleted_at)
        <div class="modal fade" id="restoreModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Pulihkan</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin memulihkan user <strong>{{ $user->name }}</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <form action="{{ route('users.restore', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Pulihkan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
