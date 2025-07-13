@extends('layouts.app')

@section('title', 'Detail Laporan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Laporan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('reports.index') }}">Laporan</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <!-- Alert Messages -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif

                        <!-- Report Information Card -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Laporan</h4>
                                <div class="card-header-action">
                                    <!-- Status Badge -->
                                    @php
                                        $statusColors = [
                                            'submitted' => 'warning',
                                            'validated' => 'info',
                                            'under_investigation' => 'primary',
                                            'completed' => 'success',
                                            'rejected' => 'danger',
                                            'appeal' => 'secondary',
                                        ];
                                        $statusLabels = [
                                            'submitted' => 'Diajukan',
                                            'validated' => 'Divalidasi',
                                            'under_investigation' => 'Dalam Investigasi',
                                            'completed' => 'Selesai',
                                            'rejected' => 'Ditolak',
                                            'appeal' => 'Banding',
                                        ];
                                    @endphp
                                    <span
                                        class="badge badge-{{ $statusColors[$report->status] ?? 'secondary' }} badge-pill">
                                        {{ $statusLabels[$report->status] ?? ucfirst($report->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="200"><strong>Nomor Laporan</strong></td>
                                                <td>: {{ $report->report_number }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Pelapor</strong></td>
                                                <td>: {{ $report->reporter->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nama Terlapor</strong></td>
                                                <td>: {{ $report->reported_person_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email Terlapor</strong></td>
                                                <td>: {{ $report->reported_person_email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jenis Terlapor</strong></td>
                                                <td>: {{ ucfirst($report->reported_person_type) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="200"><strong>Jenis Pelanggaran</strong></td>
                                                <td>: {{ $report->violationType->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Kejadian</strong></td>
                                                <td>:
                                                    {{ $report->incident_date ? date('d M Y', strtotime($report->incident_date)) : 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Metode Pengajuan</strong></td>
                                                <td>: {{ ucfirst($report->submission_method) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Dibuat</strong></td>
                                                <td>: {{ date('d M Y H:i', strtotime($report->created_at)) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Terakhir Diupdate</strong></td>
                                                <td>: {{ date('d M Y H:i', strtotime($report->updated_at)) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6><strong>Judul Laporan:</strong></h6>
                                        <p>{{ $report->title }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <h6><strong>Deskripsi Laporan:</strong></h6>
                                        <p style="white-space: pre-wrap;">{{ $report->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Document Management Card -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Manajemen Dokumen</h4>
                                <div class="card-header-action">
                                    @if (
                                        $report->status === 'submitted' &&
                                            (auth()->user()->id === $report->reporter_id ||
                                                in_array(auth()->user()->role, ['admin', 'kia_member', 'investigator'])))
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
                                            <i class="fas fa-upload"></i> Upload Dokumen
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($report->reportDocuments->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama File</th>
                                                    <th>Jenis Dokumen</th>
                                                    <th>Ukuran</th>
                                                    <th>Tanggal Upload</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($report->reportDocuments as $index => $document)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $document->file_name }}</td>
                                                        <td>
                                                            @php
                                                                $docTypeLabels = [
                                                                    'evidence' => 'Bukti',
                                                                    'similarity_report' => 'Laporan Similaritas',
                                                                    'original_document' => 'Dokumen Asli',
                                                                    'screenshot' => 'Screenshot',
                                                                    'recording' => 'Rekaman',
                                                                ];
                                                            @endphp
                                                            <span
                                                                class="badge badge-info">{{ $docTypeLabels[$document->document_type] ?? $document->document_type }}</span>
                                                        </td>
                                                        <td>{{ number_format($document->file_size / 1024, 2) }} KB</td>
                                                        <td>{{ date('d M Y H:i', strtotime($document->created_at)) }}</td>
                                                        <td>
                                                            <a href="{{ route('reports.documents.download', [$report->id, $document->id]) }}"
                                                                class="btn btn-sm btn-success">
                                                                <i class="fas fa-download"></i> Download
                                                            </a>
                                                            @if (
                                                                $report->status === 'submitted' &&
                                                                    (auth()->user()->id === $report->reporter_id ||
                                                                        in_array(auth()->user()->role, ['admin', 'kia_member', 'investigator'])))
                                                                <button class="btn btn-sm btn-danger"
                                                                    onclick="confirmDelete('{{ route('reports.documents.delete', [$report->id, $document->id]) }}')">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="empty-state" data-height="400">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <h2>Belum ada dokumen</h2>
                                        <p class="lead">Belum ada dokumen yang diupload untuk laporan ini.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Kembali
                                        </a>

                                        @if ($report->status === 'submitted' && auth()->user()->id === $report->reporter_id)
                                            <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i> Edit Laporan
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-md-6 text-right">
                                        @if (in_array(auth()->user()->role, ['admin', 'kia_member', 'investigator']))
                                            <button class="btn btn-info" data-toggle="modal"
                                                data-target="#changeStatusModal">
                                                <i class="fas fa-exchange-alt"></i> Ubah Status
                                            </button>
                                        @endif

                                        @if (
                                            $report->status === 'submitted' &&
                                                (auth()->user()->id === $report->reporter_id || auth()->user()->role === 'admin'))
                                            <button class="btn btn-danger"
                                                onclick="confirmDelete('{{ route('reports.destroy', $report->id) }}')">
                                                <i class="fas fa-trash"></i> Hapus Laporan
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('reports.documents.add', $report->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Upload Dokumen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="document_type">Jenis Dokumen</label>
                            <select class="form-control" id="document_type" name="document_type" required>
                                <option value="">Pilih Jenis Dokumen</option>
                                <option value="evidence">Bukti</option>
                                <option value="similarity_report">Laporan Similaritas</option>
                                <option value="original_document">Dokumen Asli</option>
                                <option value="screenshot">Screenshot</option>
                                <option value="recording">Rekaman</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" class="form-control-file" id="file" name="file" required>
                            <small class="form-text text-muted">
                                Maksimal 20MB. Format yang diizinkan: PDF, DOC, DOCX, JPG, JPEG, PNG, MP4, AVI, ZIP, RAR
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Status Modal -->
    <div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog"
        aria-labelledby="changeStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('reports.change-status', $report->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeStatusModalLabel">Ubah Status Laporan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="to_status">Status Baru</label>
                            <select class="form-control" id="to_status" name="to_status" required>
                                <option value="">Pilih Status</option>
                                <option value="submitted" {{ $report->status === 'submitted' ? 'selected' : '' }}>Diajukan
                                </option>
                                <option value="validated" {{ $report->status === 'validated' ? 'selected' : '' }}>
                                    Divalidasi</option>
                                <option value="under_investigation"
                                    {{ $report->status === 'under_investigation' ? 'selected' : '' }}>Dalam Investigasi
                                </option>
                                <option value="completed" {{ $report->status === 'completed' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="rejected" {{ $report->status === 'rejected' ? 'selected' : '' }}>Ditolak
                                </option>
                                <option value="appeal" {{ $report->status === 'appeal' ? 'selected' : '' }}>Banding
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"
                                placeholder="Catatan perubahan status (opsional)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ubah Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <script>
        function confirmDelete(url) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                // Create form and submit
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                // Add CSRF token
                var csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Add DELETE method
                var methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endpush
