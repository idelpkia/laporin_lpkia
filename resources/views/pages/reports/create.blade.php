@extends('layouts.app')

@section('title', 'Buat Laporan Baru')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <style>
        .document-item {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }

        .document-item.template {
            display: none;
        }

        .file-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 0.375rem;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .file-upload-area:hover {
            border-color: #6777ef;
            background-color: #f0f3ff;
        }

        .file-upload-area.dragover {
            border-color: #6777ef;
            background-color: #e3f2fd;
        }

        .btn-remove-document {
            position: absolute;
            top: 5px;
            right: 5px;
        }

        .document-item {
            position: relative;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Buat Laporan Baru</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('reports.index') }}">Laporan</a></div>
                    <div class="breadcrumb-item">Buat Laporan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Pelaporan Integritas</h4>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                {{-- komponen alert --}}
                                @include('components.alert')

                                <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data"
                                    id="reportForm">
                                    @csrf

                                    <!-- Informasi Pelaporan -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="title">Judul Laporan <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('title') is-invalid @enderror" id="title"
                                                    name="title" value="{{ old('title') }}"
                                                    placeholder="Masukkan judul laporan" required>
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Informasi Terlapor -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="reported_person_name">Nama Terlapor <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('reported_person_name') is-invalid @enderror"
                                                    id="reported_person_name" name="reported_person_name"
                                                    value="{{ old('reported_person_name') }}"
                                                    placeholder="Masukkan nama terlapor" required>
                                                @error('reported_person_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="reported_person_email">Email Terlapor</label>
                                                <input type="email"
                                                    class="form-control @error('reported_person_email') is-invalid @enderror"
                                                    id="reported_person_email" name="reported_person_email"
                                                    value="{{ old('reported_person_email') }}"
                                                    placeholder="Masukkan email terlapor">
                                                @error('reported_person_email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="reported_person_type">Jenis Terlapor <span
                                                        class="text-danger">*</span></label>
                                                <select
                                                    class="form-control select2 @error('reported_person_type') is-invalid @enderror"
                                                    id="reported_person_type" name="reported_person_type" required>
                                                    <option value="">Pilih jenis terlapor</option>
                                                    <option value="student"
                                                        {{ old('reported_person_type') == 'student' ? 'selected' : '' }}>
                                                        Mahasiswa</option>
                                                    <option value="lecturer"
                                                        {{ old('reported_person_type') == 'lecturer' ? 'selected' : '' }}>
                                                        Dosen</option>
                                                    <option value="staff"
                                                        {{ old('reported_person_type') == 'staff' ? 'selected' : '' }}>
                                                        Staff</option>
                                                    <option value="external"
                                                        {{ old('reported_person_type') == 'external' ? 'selected' : '' }}>
                                                        Eksternal</option>
                                                </select>
                                                @error('reported_person_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="violation_type_id">Jenis Pelanggaran <span
                                                        class="text-danger">*</span></label>
                                                <select
                                                    class="form-control select2 @error('violation_type_id') is-invalid @enderror"
                                                    id="violation_type_id" name="violation_type_id" required>
                                                    <option value="">Pilih jenis pelanggaran</option>
                                                    @foreach ($violationTypes as $type)
                                                        <option value="{{ $type->id }}"
                                                            {{ old('violation_type_id') == $type->id ? 'selected' : '' }}>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('violation_type_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tanggal Kejadian -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="incident_date">Tanggal Kejadian <span
                                                        class="text-danger">*</span></label>
                                                <input type="date"
                                                    class="form-control @error('incident_date') is-invalid @enderror"
                                                    id="incident_date" name="incident_date"
                                                    value="{{ old('incident_date') }}" required>
                                                @error('incident_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="submission_method">Metode Pengajuan <span
                                                        class="text-danger">*</span></label>
                                                <select
                                                    class="form-control @error('submission_method') is-invalid @enderror"
                                                    id="submission_method" name="submission_method" required>
                                                    <option value="">Pilih metode</option>
                                                    <option value="online"
                                                        {{ old('submission_method') == 'online' ? 'selected' : '' }}>Online
                                                    </option>
                                                    <option value="offline"
                                                        {{ old('submission_method') == 'offline' ? 'selected' : '' }}>
                                                        Offline</option>
                                                </select>
                                                @error('submission_method')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Deskripsi Pelanggaran <span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                                    rows="5" placeholder="Jelaskan detail pelanggaran yang terjadi" required>{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Upload Dokumen -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Dokumen Pendukung</label>
                                                <div class="file-upload-area" id="fileUploadArea">
                                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted mb-2">Klik atau drag & drop file ke sini</p>
                                                    <p class="text-muted small">Maksimal 20MB per file. Format: PDF, DOC,
                                                        DOCX, JPG, JPEG, PNG, MP4, MP3, ZIP, RAR</p>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="document.getElementById('fileInput').click()">
                                                        <i class="fas fa-plus"></i> Pilih File
                                                    </button>
                                                    <input type="file" id="fileInput" multiple style="display: none;"
                                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.mp4,.mp3,.zip,.rar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Daftar Dokumen -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="documentsList">
                                                <!-- Dokumen akan ditampilkan di sini -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Template Dokumen (Hidden) -->
                                    {{-- <div class="document-item template" id="documentTemplate">
                                        <button type="button" class="btn btn-danger btn-sm btn-remove-document">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Jenis Dokumen</label>
                                                    <select class="form-control document-type" name="document_types[]">
                                                        <option value="evidence">Bukti</option>
                                                        <option value="similarity_report">Laporan Similarity</option>
                                                        <option value="original_document">Dokumen Asli</option>
                                                        <option value="screenshot">Screenshot</option>
                                                        <option value="recording">Rekaman</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Nama File</label>
                                                    <input type="text" class="form-control file-name" readonly>
                                                    <input type="file" class="form-control file-input"
                                                        name="documents[]" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <!-- Submit Button -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane"></i> Kirim Laporan
                                                </button>
                                                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                                                    <i class="fas fa-times"></i> Batal
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        // Perbaikan JavaScript untuk form
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2();

            let documentIndex = 0;

            // File Upload Handler
            $('#fileInput').on('change', function() {
                handleFiles(this.files);
                // Reset input setelah diproses
                this.value = '';
            });

            // Drag & Drop Handler
            $('#fileUploadArea').on('dragover', function(e) {
                e.preventDefault();
                $(this).addClass('dragover');
            });

            $('#fileUploadArea').on('dragleave', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
            });

            $('#fileUploadArea').on('drop', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
                handleFiles(e.originalEvent.dataTransfer.files);
            });

            // Handle Files Function
            function handleFiles(files) {
                Array.from(files).forEach(file => {
                    if (validateFile(file)) {
                        addDocumentItem(file);
                    }
                });
            }

            // Validate File
            function validateFile(file) {
                const allowedTypes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'image/jpeg',
                    'image/jpg',
                    'image/png',
                    'video/mp4',
                    'audio/mp3',
                    'audio/mpeg',
                    'application/zip',
                    'application/x-rar-compressed',
                    'application/x-zip-compressed'
                ];
                const maxSize = 20 * 1024 * 1024; // 20MB

                if (!allowedTypes.includes(file.type)) {
                    alert('Tipe file tidak didukung: ' + file.name + ' (Type: ' + file.type + ')');
                    return false;
                }

                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar: ' + file.name + ' (maksimal 20MB)');
                    return false;
                }

                return true;
            }

            // Add Document Item - PERBAIKAN TOTAL
            function addDocumentItem(file) {
                const documentId = 'document-' + documentIndex;

                // Buat struktur HTML baru langsung tanpa clone
                const documentItem = $(`
            <div class="document-item" id="${documentId}">
                <button type="button" class="btn btn-danger btn-sm btn-remove-document">
                    <i class="fas fa-times"></i>
                </button>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jenis Dokumen</label>
                            <select class="form-control document-type" name="document_types[]" required>
                                <option value="evidence">Bukti</option>
                                <option value="similarity_report">Laporan Similarity</option>
                                <option value="original_document">Dokumen Asli</option>
                                <option value="screenshot">Screenshot</option>
                                <option value="recording">Rekaman</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Nama File</label>
                            <input type="text" class="form-control file-name" value="${file.name}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        `);

                // Buat input file tersembunyi dan set file-nya
                const fileInput = $('<input type="file" name="documents[]" style="display: none;" required>');
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput[0].files = dt.files;

                // Tambahkan input file ke document item
                documentItem.append(fileInput);

                // Remove document handler
                documentItem.find('.btn-remove-document').on('click', function() {
                    documentItem.remove();
                });

                $('#documentsList').append(documentItem);
                documentIndex++;
            }

            // Form submission validation - DISEDERHANAKAN
            $('#reportForm').on('submit', function(e) {
                // Hitung jumlah input yang visible
                const visibleDocumentItems = $('.document-item:not(.template)').length;
                const fileInputs = $('input[name="documents[]"]');
                const typeInputs = $('select[name="document_types[]"]');

                console.log('Visible items:', visibleDocumentItems);
                console.log('File inputs:', fileInputs.length);
                console.log('Type inputs:', typeInputs.length);

                // Pastikan jumlah sama
                if (fileInputs.length !== typeInputs.length) {
                    e.preventDefault();
                    alert('Terjadi kesalahan pada dokumen. Silakan refresh halaman dan coba lagi.');
                    return false;
                }

                // Validasi setiap file input memiliki file
                let hasError = false;
                fileInputs.each(function() {
                    if (!this.files || this.files.length === 0) {
                        hasError = true;
                        return false;
                    }
                });

                if (hasError) {
                    e.preventDefault();
                    alert(
                        'Ada dokumen yang tidak memiliki file. Silakan hapus atau pilih file yang valid.'
                    );
                    return false;
                }

                return true;
            });
        });
    </script>
@endpush
