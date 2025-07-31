@extends('layouts.app')

@section('title', 'Detail Investigasi')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Investigasi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('investigations.index') }}">Investigasi</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    </div>
                @endif

                <!-- Investigation Overview -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Investigasi</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('investigations.edit', $investigation) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Laporan Terkait</label>
                                            <div class="card card-info">
                                                <div class="card-body p-3">
                                                    <h6 class="mb-1">{{ $investigation->report->title ?? 'N/A' }}</h6>
                                                    <small class="text-muted">ID Laporan:
                                                        {{ $investigation->report_id }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Ketua Tim Investigasi</label>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-lg mr-3">
                                                    <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}"
                                                        class="rounded-circle">
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">
                                                        {{ $investigation->teamLeader->name ?? 'N/A' }}</div>
                                                    <div class="text-muted">{{ $investigation->teamLeader->email ?? '' }}
                                                    </div>
                                                    <div class="badge badge-primary">Team Leader</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Status Investigasi</label>
                                            <div>
                                                @if ($investigation->status == 'formed')
                                                    <span class="badge badge-secondary badge-lg">
                                                        <i class="fas fa-users"></i> Dibentuk
                                                    </span>
                                                @elseif($investigation->status == 'document_review')
                                                    <span class="badge badge-info badge-lg">
                                                        <i class="fas fa-file-search"></i> Review Dokumen
                                                    </span>
                                                @elseif($investigation->status == 'calling_parties')
                                                    <span class="badge badge-warning badge-lg">
                                                        <i class="fas fa-phone"></i> Pemanggilan
                                                    </span>
                                                @elseif($investigation->status == 'report_writing')
                                                    <span class="badge badge-primary badge-lg">
                                                        <i class="fas fa-edit"></i> Penulisan Laporan
                                                    </span>
                                                @elseif($investigation->status == 'completed')
                                                    <span class="badge badge-success badge-lg">
                                                        <i class="fas fa-check"></i> Selesai
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Timeline</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <small class="text-muted">Mulai:</small>
                                                    <div class="font-weight-bold">
                                                        {{ $investigation->start_date ? \Carbon\Carbon::parse($investigation->start_date)->format('d M Y') : '-' }}
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Selesai:</small>
                                                    <div class="font-weight-bold">
                                                        {{ $investigation->end_date ? \Carbon\Carbon::parse($investigation->end_date)->format('d M Y') : 'Belum selesai' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Progress</label>
                                            @php
                                                $statuses = [
                                                    'formed',
                                                    'document_review',
                                                    'calling_parties',
                                                    'report_writing',
                                                    'completed',
                                                ];
                                                $currentIndex = array_search($investigation->status, $statuses);
                                                $progress = (($currentIndex + 1) / count($statuses)) * 100;
                                            @endphp
                                            <div class="progress mb-2" data-height="10">
                                                <div class="progress-bar 
                                                    @if ($progress < 40) bg-danger
                                                    @elseif($progress < 80) bg-warning
                                                    @else bg-success @endif"
                                                    data-width="{{ $progress }}%">
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ round($progress) }}% selesai</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Statistik</h4>
                            </div>
                            <div class="card-body">
                                <div class="summary">
                                    <div class="summary-info">
                                        <h4>{{ $investigation->investigationTeams->count() }}</h4>
                                        <span>Anggota Tim</span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="text-muted">Total anggota tim investigasi</span>
                                    </div>
                                </div>
                                <div class="summary">
                                    <div class="summary-info">
                                        <h4>{{ $investigation->investigationActivities->count() }}</h4>
                                        <span>Aktivitas</span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="text-muted">Aktivitas yang telah dilakukan</span>
                                    </div>
                                </div>
                                <div class="summary">
                                    <div class="summary-info">
                                        <h4>{{ $investigation->investigationTools->count() }}</h4>
                                        <span>Tools Digunakan</span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="text-muted">Tools analisis yang digunakan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Members -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-users"></i> Tim Investigasi</h4>
                                <div class="card-header-action">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addTeamMemberModal">
                                        <i class="fas fa-plus"></i> Tambah Anggota
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($investigation->investigationTeams->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Anggota</th>
                                                    <th>Role</th>
                                                    <th>Bergabung</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($investigation->investigationTeams as $teamMember)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar avatar-sm mr-2">
                                                                    <img alt="image"
                                                                        src="{{ asset('img/avatar/avatar-1.png') }}"
                                                                        class="rounded-circle">
                                                                </div>
                                                                <div>
                                                                    <div class="font-weight-bold">
                                                                        {{ $teamMember->member->name ?? 'N/A' }}</div>
                                                                    <div class="text-muted text-small">
                                                                        {{ $teamMember->member->email ?? '' }}</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-info">{{ $teamMember->role }}</span>
                                                        </td>
                                                        <td>{{ $teamMember->created_at->format('d M Y') }}</td>
                                                        <td>
                                                            <form
                                                                action="{{ route('investigations.removeTeamMember', [$investigation, $teamMember->id]) }}"
                                                                method="POST" style="display: inline;"
                                                                onsubmit="return confirm('Hapus anggota tim ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="empty-state" data-height="200">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <h2>Belum Ada Anggota Tim</h2>
                                        <p class="lead">Tambahkan anggota tim untuk memulai investigasi</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Investigation Activities -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-tasks"></i> Aktivitas Investigasi</h4>
                                <div class="card-header-action">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addActivityModal">
                                        <i class="fas fa-plus"></i> Tambah Aktivitas
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($investigation->investigationActivities->count() > 0)
                                    <div class="activities">
                                        @foreach ($investigation->investigationActivities->sortByDesc('activity_date') as $activity)
                                            <div class="activity">
                                                <div
                                                    class="activity-icon 
                                                    @if ($activity->activity_type == 'document_analysis') bg-info
                                                    @elseif($activity->activity_type == 'interview') bg-warning
                                                    @elseif($activity->activity_type == 'similarity_check') bg-primary
                                                    @elseif($activity->activity_type == 'metadata_audit') bg-success @endif">
                                                    @if ($activity->activity_type == 'document_analysis')
                                                        <i class="fas fa-file-search"></i>
                                                    @elseif($activity->activity_type == 'interview')
                                                        <i class="fas fa-comments"></i>
                                                    @elseif($activity->activity_type == 'similarity_check')
                                                        <i class="fas fa-search"></i>
                                                    @elseif($activity->activity_type == 'metadata_audit')
                                                        <i class="fas fa-code"></i>
                                                    @endif
                                                </div>
                                                <div class="activity-detail">
                                                    <div class="mb-2">
                                                        <span
                                                            class="text-job">{{ \Carbon\Carbon::parse($activity->activity_date)->format('d M Y') }}</span>
                                                        <span class="bullet"></span>
                                                        <span
                                                            class="text-job">{{ $activity->performer->name ?? 'N/A' }}</span>
                                                        <div class="float-right">
                                                            @if ($activity->activity_type == 'document_analysis')
                                                                <span class="badge badge-info">Analisis Dokumen</span>
                                                            @elseif($activity->activity_type == 'interview')
                                                                <span class="badge badge-warning">Wawancara</span>
                                                            @elseif($activity->activity_type == 'similarity_check')
                                                                <span class="badge badge-primary">Cek Similaritas</span>
                                                            @elseif($activity->activity_type == 'metadata_audit')
                                                                <span class="badge badge-success">Audit Metadata</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <p>{{ $activity->description ?: 'Tidak ada deskripsi' }}</p>
                                                    @if ($activity->notes)
                                                        <div class="alert alert-light">
                                                            <strong>Catatan:</strong> {{ $activity->notes }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="empty-state" data-height="200">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-tasks"></i>
                                        </div>
                                        <h2>Belum Ada Aktivitas</h2>
                                        <p class="lead">Mulai dokumentasikan aktivitas investigasi</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Investigation Tools -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-tools"></i> Tools Investigasi</h4>
                                <div class="card-header-action">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addToolModal">
                                        <i class="fas fa-plus"></i> Tambah Tool
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($investigation->investigationTools->count() > 0)
                                    <div class="row">
                                        @foreach ($investigation->investigationTools as $tool)
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h4>
                                                            @if ($tool->tool_name == 'turnitin')
                                                                <i class="fas fa-check-circle text-primary"></i> Turnitin
                                                            @elseif($tool->tool_name == 'grammarly')
                                                                <i class="fas fa-spell-check text-success"></i> Grammarly
                                                            @elseif($tool->tool_name == 'codequiry')
                                                                <i class="fas fa-code text-info"></i> Codequiry
                                                            @elseif($tool->tool_name == 'jplag')
                                                                <i class="fas fa-search text-warning"></i> JPlag
                                                            @elseif($tool->tool_name == 'lms_audit')
                                                                <i class="fas fa-graduation-cap text-secondary"></i> LMS
                                                                Audit
                                                            @elseif($tool->tool_name == 'git_audit')
                                                                <i class="fab fa-git-alt text-dark"></i> Git Audit
                                                            @endif
                                                        </h4>
                                                        <div class="card-header-action">
                                                            <form
                                                                action="{{ route('investigations.removeTool', [$investigation, $tool->id]) }}"
                                                                method="POST" style="display: inline;"
                                                                onsubmit="return confirm('Hapus tool ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        @if ($tool->result_percentage)
                                                            <div class="mb-2">
                                                                <span class="text-muted">Hasil:</span>
                                                                <div class="progress" data-height="6">
                                                                    <div class="progress-bar 
                                                                        @if ($tool->result_percentage < 20) bg-success
                                                                        @elseif($tool->result_percentage < 50) bg-warning
                                                                        @else bg-danger @endif"
                                                                        data-width="{{ $tool->result_percentage }}%">
                                                                    </div>
                                                                </div>
                                                                <small class="text-muted">{{ $tool->result_percentage }}%
                                                                    similarity</small>
                                                            </div>
                                                        @endif

                                                        @if ($tool->result_file_path)
                                                            <div class="mb-2">
                                                                <a href="{{ $tool->result_file_path }}"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-download"></i> Download Hasil
                                                                </a>
                                                            </div>
                                                        @endif

                                                        @if ($tool->notes)
                                                            <small class="text-muted">{{ $tool->notes }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="empty-state" data-height="200">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-tools"></i>
                                        </div>
                                        <h2>Belum Ada Tools</h2>
                                        <p class="lead">Tambahkan tools untuk analisis investigasi</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Add Team Member Modal -->
    <div class="modal fade" id="addTeamMemberModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Anggota Tim</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('investigations.addTeamMember', $investigation) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Anggota <span class="text-danger">*</span></label>
                            <select name="member_id" class="form-control select2" required>
                                <option value="">Pilih Anggota</option>
                                @foreach (\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Role <span class="text-danger">*</span></label>
                            <input type="text" name="role" class="form-control"
                                placeholder="Masukkan role anggota" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Anggota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Activity Modal -->
    <div class="modal fade" id="addActivityModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Aktivitas</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('investigations.addActivity', $investigation) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Aktivitas <span class="text-danger">*</span></label>
                                    <select name="activity_type" class="form-control" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="document_analysis">Analisis Dokumen</option>
                                        <option value="interview">Wawancara</option>
                                        <option value="similarity_check">Cek Similaritas</option>
                                        <option value="metadata_audit">Audit Metadata</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal <span class="text-danger">*</span></label>
                                    <input type="text" name="activity_date" class="form-control datepicker" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Dilakukan Oleh <span class="text-danger">*</span></label>
                            <select name="performed_by" class="form-control select2" required>
                                <option value="">Pilih Pelaksana</option>
                                @foreach (\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi aktivitas"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Catatan tambahan"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Aktivitas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Tool Modal -->
    <div class="modal fade" id="addToolModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tool</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('investigations.addTool', $investigation) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tool <span class="text-danger">*</span></label>
                            <select name="tool_name" class="form-control" required>
                                <option value="">Pilih Tool</option>
                                <option value="turnitin">Turnitin</option>
                                <option value="grammarly">Grammarly</option>
                                <option value="codequiry">Codequiry</option>
                                <option value="jplag">JPlag</option>
                                <option value="lms_audit">LMS Audit</option>
                                <option value="git_audit">Git Audit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Hasil Persentase (%)</label>
                            <input type="number" name="result_percentage" class="form-control" min="0"
                                max="100" step="0.01">
                        </div>
                        <div class="form-group">
                            <label>Path File Hasil</label>
                            <input type="text" name="result_file_path" class="form-control"
                                placeholder="Path atau URL file hasil">
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Catatan tentang hasil tool"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Tool</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                width: '100%'
            });

            // Initialize Datepicker
            $('.datepicker').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'YYYY-MM-DD'
                },
                autoApply: true
            });
        });
    </script>
@endpush
