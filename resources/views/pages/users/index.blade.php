@extends('layouts.app')

@section('title', 'Manajemen User')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manajemen User</h1>
                <div class="section-header-button">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah User</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">User</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar User</h4>
                                <div class="card-header-form">
                                    <form method="GET" action="{{ route('users.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Cari user..."
                                                name="search" value="{{ request('search') }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Filter Section -->
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <form method="GET" action="{{ route('users.index') }}" class="form-inline">
                                            <input type="hidden" name="search" value="{{ request('search') }}">

                                            <div class="form-group mr-2">
                                                <label class="mr-1">Peran:</label>
                                                <select name="role" class="form-control selectric">
                                                    <option value="">Semua Peran</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role }}"
                                                            {{ request('role') == $role ? 'selected' : '' }}>
                                                            {{ ucfirst($role) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mr-2">
                                                <label class="mr-1">Departemen:</label>
                                                <select name="department" class="form-control selectric">
                                                    <option value="">Semua Departemen</option>
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department }}"
                                                            {{ request('department') == $department ? 'selected' : '' }}>
                                                            {{ $department }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary mr-1">Filter</button>
                                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Reset</a>
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
                                                <th>Peran</th>
                                                <th>Departemen</th>
                                                <th>Telepon</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($users as $index => $user)
                                                <tr>
                                                    <td>{{ $users->firstItem() + $index }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        <span class="badge badge-primary">{{ ucfirst($user->role) }}</span>
                                                    </td>
                                                    <td>{{ $user->department ?? '-' }}</td>
                                                    <td>{{ $user->phone ?? '-' }}</td>
                                                    <td>
                                                        @if ($user->deleted_at)
                                                            <span class="badge badge-danger">Nonaktif</span>
                                                        @else
                                                            <span class="badge badge-success">Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('users.show', $user) }}"
                                                                class="btn btn-info btn-sm" data-toggle="tooltip"
                                                                title="Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </a>

                                                            @if (!$user->deleted_at)
                                                                <a href="{{ route('users.edit', $user) }}"
                                                                    class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                                    title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>

                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#deleteModal{{ $user->id }}"
                                                                    title="Hapus">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            @else
                                                                <button type="button" class="btn btn-success btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#restoreModal{{ $user->id }}"
                                                                    title="Pulihkan">
                                                                    <i class="fas fa-undo"></i>
                                                                </button>
                                                            @endif
                                                        </div>

                                                        <!-- Delete Modal -->
                                                        @if (!$user->deleted_at)
                                                            <div class="modal fade" id="deleteModal{{ $user->id }}"
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
                                                                            <p>Apakah Anda yakin ingin menghapus user
                                                                                <strong>{{ $user->name }}</strong>?
                                                                            </p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">Batal</button>
                                                                            <form
                                                                                action="{{ route('users.destroy', $user) }}"
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

                                                        <!-- Restore Modal -->
                                                        @if ($user->deleted_at)
                                                            <div class="modal fade" id="restoreModal{{ $user->id }}"
                                                                tabindex="-1" role="dialog">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Konfirmasi Pulihkan
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal">
                                                                                <span>&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Apakah Anda yakin ingin memulihkan user
                                                                                <strong>{{ $user->name }}</strong>?
                                                                            </p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">Batal</button>
                                                                            <form
                                                                                action="{{ route('users.restore', $user->id) }}"
                                                                                method="POST" class="d-inline">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <button type="submit"
                                                                                    class="btn btn-success">Pulihkan</button>
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
                                                    <td colspan="8" class="text-center">Tidak ada data user</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center">
                                    {{ $users->appends(request()->query())->links() }}
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
        });
    </script>
@endpush
