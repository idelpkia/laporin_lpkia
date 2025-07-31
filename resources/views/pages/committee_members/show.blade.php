@extends('layouts.app')

@section('title', 'Detail Anggota KIA')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Anggota KIA</h1>
                <div class="section-header-button">
                    <a href="{{ route('committee-members.edit', $committeeMember) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('committee-members.index') }}">Komite Integritas</a>
                    </div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row">
                    <!-- Member Information -->
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Informasi Anggota</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <div class="avatar avatar-xl mb-3">
                                            <div class="avatar-initial rounded-circle bg-primary" style="font-size: 2rem;">
                                                {{ strtoupper(substr($committeeMember->user->name, 0, 2)) }}
                                            </div>
                                        </div>
                                        <h5 class="font-weight-bold">{{ $committeeMember->user->name }}</h5>
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
                                            class="badge badge-{{ $positionColors[$committeeMember->position] ?? 'secondary' }} badge-lg">
                                            {{ $positionLabels[$committeeMember->position] ?? ucfirst($committeeMember->position) }}
                                        </span>
                                    </div>
                                    <div class="col-md-8">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="35%"><strong>Email</strong></td>
                                                <td>: {{ $committeeMember->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Role User</strong></td>
                                                <td>: <span
                                                        class="badge badge-secondary">{{ ucfirst($committeeMember->user->role) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Departemen</strong></td>
                                                <td>: {{ $committeeMember->user->department ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Telepon</strong></td>
                                                <td>: {{ $committeeMember->user->phone ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status Keaktifan</strong></td>
                                                <td>:
                                                    @if ($committeeMember->is_active)
                                                        <span class="badge badge-success">Aktif</span>
                                                    @else
                                                        <span class="badge badge-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Period Information -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Periode Keanggotaan</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tanggal Mulai</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control"
                                                    value="{{ $committeeMember->start_date ? \Carbon\Carbon::parse($committeeMember->start_date)->format('d F Y') : 'Tidak ditentukan' }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tanggal Selesai</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control"
                                                    value="{{ $committeeMember->end_date ? \Carbon\Carbon::parse($committeeMember->end_date)->format('d F Y') : 'Masih aktif' }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($committeeMember->start_date)
                                    @php
                                        $startDate = \Carbon\Carbon::parse($committeeMember->start_date);
                                        $endDate = $committeeMember->end_date
                                            ? \Carbon\Carbon::parse($committeeMember->end_date)
                                            : \Carbon\Carbon::now();
                                        $duration = $startDate->diff($endDate);
                                    @endphp
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        <strong>Durasi Keanggotaan:</strong>
                                        {{ $duration->y }} tahun, {{ $duration->m }} bulan, {{ $duration->d }} hari
                                        @if (!$committeeMember->end_date)
                                            (sampai saat ini)
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Statistics & Activities -->
                    <div class="col-md-4">
                        <!-- Status Card -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Status Anggota</h4>
                            </div>
                            <div class="card-body text-center">
                                @if ($committeeMember->is_active)
                                    <div class="mb-3">
                                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                                    </div>
                                    <h5 class="text-success">AKTIF</h5>
                                    <p class="text-muted">Anggota aktif dalam Komite Integritas Akademik</p>
                                @else
                                    <div class="mb-3">
                                        <i class="fas fa-times-circle text-danger" style="font-size: 3rem;"></i>
                                    </div>
                                    <h5 class="text-danger">TIDAK AKTIF</h5>
                                    <p class="text-muted">Anggota tidak aktif dalam Komite Integritas Akademik</p>
                                @endif
                            </div>
                        </div>

                        <!-- Position Description -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Deskripsi Posisi</h4>
                            </div>
                            <div class="card-body">
                                @php
                                    $positionDescriptions = [
                                        'chairman' => [
                                            'title' => 'Ketua Komite',
                                            'icon' => 'fas fa-crown text-warning',
                                            'description' =>
                                                'Memimpin rapat komite, mengambil keputusan strategis, dan bertanggung jawab atas keseluruhan kegiatan komite.',
                                            'responsibilities' => [
                                                'Memimpin rapat komite',
                                                'Mengambil keputusan akhir',
                                                'Koordinasi dengan pimpinan institusi',
                                                'Menandatangani dokumen resmi',
                                            ],
                                        ],
                                        'secretary' => [
                                            'title' => 'Sekretaris Komite',
                                            'icon' => 'fas fa-file-alt text-info',
                                            'description' =>
                                                'Mengelola administrasi komite, mencatat notulen rapat, dan mengelola dokumen-dokumen komite.',
                                            'responsibilities' => [
                                                'Mencatat notulen rapat',
                                                'Mengelola administrasi',
                                                'Menyiapkan agenda rapat',
                                                'Mengelola arsip dokumen',
                                            ],
                                        ],
                                        'member' => [
                                            'title' => 'Anggota Komite',
                                            'icon' => 'fas fa-user text-primary',
                                            'description' =>
                                                'Berpartisipasi aktif dalam rapat, memberikan masukan, dan membantu pengambilan keputusan komite.',
                                            'responsibilities' => [
                                                'Menghadiri rapat komite',
                                                'Memberikan masukan',
                                                'Membantu pengambilan keputusan',
                                                'Melaksanakan tugas yang diberikan',
                                            ],
                                        ],
                                    ];
                                    $positionData = $positionDescriptions[$committeeMember->position] ?? null;
                                @endphp

                                @if ($positionData)
                                    <div class="text-center mb-3">
                                        <i class="{{ $positionData['icon'] }}" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2">{{ $positionData['title'] }}</h6>
                                    </div>

                                    <p class="text-muted small">{{ $positionData['description'] }}</p>

                                    <h6>Tanggung Jawab:</h6>
                                    <ul class="list-unstyled">
                                        @foreach ($positionData['responsibilities'] as $responsibility)
                                            <li class="mb-1">
                                                <i class="fas fa-check text-success mr-2"></i>
                                                <span class="small">{{ $responsibility }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <!-- Timeline Info -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Timeline</h4>
                            </div>
                            <div class="card-body">
                                <div class="activities">
                                    <div class="activity">
                                        <div class="activity-icon bg-primary text-white">
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <div class="mb-2">
                                                <span class="text-job">Ditambahkan ke sistem</span>
                                                <span class="bullet"></span>
                                                <span
                                                    class="text-job">{{ $committeeMember->created_at->format('d M Y') }}</span>
                                            </div>
                                            <p>Data anggota KIA ditambahkan ke sistem</p>
                                        </div>
                                    </div>

                                    @if ($committeeMember->start_date)
                                        <div class="activity">
                                            <div class="activity-icon bg-success text-white">
                                                <i class="fas fa-play"></i>
                                            </div>
                                            <div class="activity-detail">
                                                <div class="mb-2">
                                                    <span class="text-job">Mulai bertugas</span>
                                                    <span class="bullet"></span>
                                                    <span
                                                        class="text-job">{{ \Carbon\Carbon::parse($committeeMember->start_date)->format('d M Y') }}</span>
                                                </div>
                                                <p>Mulai menjalankan tugas sebagai
                                                    {{ $positionLabels[$committeeMember->position] ?? ucfirst($committeeMember->position) }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($committeeMember->end_date)
                                        <div class="activity">
                                            <div class="activity-icon bg-danger text-white">
                                                <i class="fas fa-stop"></i>
                                            </div>
                                            <div class="activity-detail">
                                                <div class="mb-2">
                                                    <span class="text-job">Selesai bertugas</span>
                                                    <span class="bullet"></span>
                                                    <span
                                                        class="text-job">{{ \Carbon\Carbon::parse($committeeMember->end_date)->format('d M Y') }}</span>
                                                </div>
                                                <p>Menyelesaikan tugas sebagai anggota KIA</p>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="activity">
                                        <div class="activity-icon bg-info text-white">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <div class="mb-2">
                                                <span class="text-job">Terakhir diupdate</span>
                                                <span class="bullet"></span>
                                                <span
                                                    class="text-job">{{ $committeeMember->updated_at->format('d M Y') }}</span>
                                            </div>
                                            <p>Data anggota terakhir diperbarui</p>
                                        </div>
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
                                <a href="{{ route('committee-members.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                </a>
                                <a href="{{ route('committee-members.edit', $committeeMember) }}"
                                    class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Anggota
                                </a>
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#deleteModal">
                                    <i class="fas fa-trash"></i> Hapus Anggota
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Delete Modal -->
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
                    <p>Apakah Anda yakin ingin menghapus anggota KIA <strong>{{ $committeeMember->user->name }}</strong>?
                    </p>
                    <p class="text-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <small>Tindakan ini akan menghapus data keanggotaan dari sistem dan tidak dapat dibatalkan.</small>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form action="{{ route('committee-members.destroy', $committeeMember) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@endpush
