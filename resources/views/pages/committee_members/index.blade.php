@extends('layouts.app')

@section('title', 'Anggota Komite Integritas Akademik')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Anggota Komite Integritas Akademik</h1>
                <div class="section-header-button">
                    <a href="{{ route('committee-members.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Anggota
                    </a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Komite Integritas</div>
                </div>
            </div>

            <div class="section-body">
                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Anggota</h4>
                                </div>
                                <div class="card-body">
                                    {{ $committeeMembers->total() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Anggota Aktif</h4>
                                </div>
                                <div class="card-body">
                                    {{ $committeeMembers->where('is_active', true)->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Ketua</h4>
                                </div>
                                <div class="card-body">
                                    {{ $committeeMembers->where('position', 'chairman')->where('is_active', true)->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Sekretaris</h4>
                                </div>
                                <div class="card-body">
                                    {{ $committeeMembers->where('position', 'secretary')->where('is_active', true)->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Anggota KIA</h4>
                                <div class="card-header-form">
                                    <form method="GET" action="{{ route('committee-members.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Cari anggota..."
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
                                        <form method="GET" action="{{ route('committee-members.index') }}"
                                            class="form-inline">
                                            <input type="hidden" name="search" value="{{ request('search') }}">

                                            <div class="form-group mr-2">
                                                <label class="mr-1">Posisi:</label>
                                                <select name="position" class="form-control selectric">
                                                    <option value="">Semua Posisi</option>
                                                    <option value="chairman"
                                                        {{ request('position') == 'chairman' ? 'selected' : '' }}>Ketua
                                                    </option>
                                                    <option value="secretary"
                                                        {{ request('position') == 'secretary' ? 'selected' : '' }}>
                                                        Sekretaris</option>
                                                    <option value="member"
                                                        {{ request('position') == 'member' ? 'selected' : '' }}>Anggota
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="form-group mr-2">
                                                <label class="mr-1">Status:</label>
                                                <select name="is_active" class="form-control selectric">
                                                    <option value="">Semua Status</option>
                                                    <option value="1"
                                                        {{ request('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="0"
                                                        {{ request('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif
                                                    </option>
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary mr-1">Filter</button>
                                            <a href="{{ route('committee-members.index') }}"
                                                class="btn btn-secondary">Reset</a>
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
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Posisi</th>
                                                <th>Periode</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($committeeMembers as $index => $member)
                                                <tr>
                                                    <td>{{ $committeeMembers->firstItem() + $index }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm mr-3">
                                                                <div class="avatar-initial rounded-circle bg-primary">
                                                                    {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-600">{{ $member->user->name }}
                                                                </div>
                                                                <div class="text-muted small">
                                                                    {{ $member->user->department ?? '-' }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $member->user->email }}</td>
                                                    <td>
                                                        @php
                                                            $positionColors = [
                                                                'chairman' => 'warning',
                                                                'secretary' => 'info',
                                                                'member' => 'primary',
                                                            ];
                                                            $positionLabels = [
                                                                'chairman' => 'Ketua',
                                                                'secretary' => 'Sekretaris',
                                                                'member' => 'Anggota',
                                                            ];
                                                        @endphp
                                                        <span
                                                            class="badge badge-{{ $positionColors[$member->position] ?? 'secondary' }}">
                                                            {{ $positionLabels[$member->position] ?? ucfirst($member->position) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if ($member->start_date)
                                                            <div class="text-small">
                                                                <strong>Mulai:</strong>
                                                                {{ \Carbon\Carbon::parse($member->start_date)->format('d/m/Y') }}
                                                            </div>
                                                        @endif
                                                        @if ($member->end_date)
                                                            <div class="text-small text-muted">
                                                                <strong>Selesai:</strong>
                                                                {{ \Carbon\Carbon::parse($member->end_date)->format('d/m/Y') }}
                                                            </div>
                                                        @else
                                                            <div class="text-small text-muted">
                                                                <strong>Selesai:</strong> -
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($member->is_active)
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-danger">Tidak Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('committee-members.show', $member) }}"
                                                                class="btn btn-info btn-sm" data-toggle="tooltip"
                                                                title="Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </a>

                                                            <a href="{{ route('committee-members.edit', $member) }}"
                                                                class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                                title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#deleteModal{{ $member->id }}"
                                                                title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>

                                                        <!-- Delete Modal -->
                                                        <div class="modal fade" id="deleteModal{{ $member->id }}"
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
                                                                        <p>Apakah Anda yakin ingin menghapus anggota KIA
                                                                            <strong>{{ $member->user->name }}</strong>?
                                                                        </p>
                                                                        <p class="text-danger"><small>Tindakan ini akan
                                                                                menghapus data keanggotaan dari
                                                                                sistem.</small></p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Batal</button>
                                                                        <form
                                                                            action="{{ route('committee-members.destroy', $member) }}"
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
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        <div class="empty-state" data-height="200">
                                                            <div class="empty-state-icon">
                                                                <i class="fas fa-users"></i>
                                                            </div>
                                                            <h2>Belum ada anggota KIA</h2>
                                                            <p class="lead">Silakan tambahkan anggota Komite Integritas
                                                                Akademik.</p>
                                                            <a href="{{ route('committee-members.create') }}"
                                                                class="btn btn-primary mt-4">
                                                                <i class="fas fa-plus"></i> Tambah Anggota Pertama
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center">
                                    {{ $committeeMembers->appends(request()->query())->links() }}
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
        });
    </script>
@endpush
