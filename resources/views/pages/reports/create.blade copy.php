@extends('layouts.app')

@section('title', 'Buat Laporan Baru')

@push('style')
    <style>
        .form-wizard {
            position: relative;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .step-item {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .step-item:not(:last-child):after {
            content: '';
            position: absolute;
            top: 25px;
            right: -50%;
            width: 100%;
            height: 2px;
            background: #e9ecef;
            z-index: 0;
        }

        .step-item.active:not(:last-child):after,
        .step-item.completed:not(:last-child):after {
            background: #007bff;
        }

        .step-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: bold;
            position: relative;
            z-index: 1;
        }

        .step-item.active .step-circle {
            background: #007bff;
            color: white;
        }

        .step-item.completed .step-circle {
            background: #28a745;
            color: white;
        }

        .step-title {
            font-size: 14px;
            font-weight: 500;
            color: #6c757d;
        }

        .step-item.active .step-title {
            color: #007bff;
        }

        .step-item.completed .step-title {
            color: #28a745;
        }

        .form-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .required-indicator {
            color: #dc3545;
            font-weight: bold;
        }

        .form-help {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 0 4px 4px 0;
        }

        .evidence-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .evidence-item {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            background: #f8f9fa;
            min-width: 150px;
        }

        .evidence-remove {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 12px;
        }

        .progress-bar-container {
            background: #e9ecef;
            border-radius: 10px;
            height: 8px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .progress-bar {
            background: linear-gradient(45deg, #007bff, #0056b3);
            height: 100%;
            transition: width 0.3s ease;
            border-radius: 10px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>
                    <i class="fas fa-file-alt"></i> Buat Laporan Baru
                </h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Buat Laporan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-lg-10 offset-lg-1">
                        <div class="card">
                            <div class="card-header">
                                <h4>
                                    <i class="fas fa-edit"></i> Formulir Pengajuan Laporan
                                </h4>
                            </div>
                            <div class="card-body">

                                <!-- Progress Bar -->
                                <div class="progress-bar-container">
                                    <div class="progress-bar" id="progressBar" style="width: 25%"></div>
                                </div>

                                <!-- Help Text -->
                                <div class="form-help">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Petunjuk:</strong> Isi formulir ini dengan lengkap dan jelas. Semua field yang
                                    bertanda <span class="required-indicator">*</span> wajib diisi. Anda dapat melampirkan
                                    bukti pendukung untuk memperkuat laporan Anda.
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <div class="alert-title">
                                            <i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan dalam pengisian
                                        </div>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data"
                                    id="reportForm">
                                    @csrf

                                    <!-- Step Indicator -->
                                    <div class="step-indicator">
                                        <div class="step-item active" data-step="1">
                                            <div class="step-circle">1</div>
                                            <div class="step-title">Informasi Dasar</div>
                                        </div>
                                        <div class="step-item" data-step="2">
                                            <div class="step-circle">2</div>
                                            <div class="step-title">Data Terlapor</div>
                                        </div>
                                        <div class="step-item" data-step="3">
                                            <div class="step-circle">3</div>
                                            <div class="step-title">Detail Pelanggaran</div>
                                        </div>
                                        <div class="step-item" data-step="4">
                                            <div class="step-circle">4</div>
                                            <div class="step-title">Bukti & Finalisasi</div>
                                        </div>
                                    </div>

                                    <!-- Step 1: Informasi Dasar -->
                                    <div class="form-step active" id="step1">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="mb-3">
                                                    <i class="fas fa-file-signature"></i> Informasi Dasar Laporan
                                                </h5>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="title">
                                                        <i class="fas fa-heading"></i> Judul Laporan
                                                        <span class="required-indicator">*</span>
                                                    </label>
                                                    <input type="text" name="title"
                                                        class="form-control @error('title') is-invalid @enderror" required
                                                        value="{{ old('title') }}"
                                                        placeholder="Masukkan judul laporan yang jelas dan singkat">
                                                    @error('title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <small class="form-text text-muted">
                                                        Contoh: "Pelecehan Verbal di Ruang Kuliah", "Pelanggaran Kode Etik
                                                        Dosen"
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="submission_method">
                                                        <i class="fas fa-paper-plane"></i> Metode Pengajuan
                                                        <span class="required-indicator">*</span>
                                                    </label>
                                                    <select name="submission_method"
                                                        class="form-control @error('submission_method') is-invalid @enderror"
                                                        required>
                                                        <option value="">-- Pilih Metode --</option>
                                                        <option value="online"
                                                            {{ old('submission_method') == 'online' ? 'selected' : '' }}>
                                                            Online
                                                        </option>
                                                        <option value="offline"
                                                            {{ old('submission_method') == 'offline' ? 'selected' : '' }}>
                                                            Offline
                                                        </option>
                                                    </select>
                                                    @error('submission_method')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 2: Data Terlapor -->
                                    <div class="form-step" id="step2">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="mb-3">
                                                    <i class="fas fa-user-tag"></i> Data Terlapor
                                                </h5>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="reported_person_name">
                                                        <i class="fas fa-user"></i> Nama Terlapor
                                                        <span class="required-indicator">*</span>
                                                    </label>
                                                    <input type="text" name="reported_person_name"
                                                        class="form-control @error('reported_person_name') is-invalid @enderror"
                                                        required value="{{ old('reported_person_name') }}"
                                                        placeholder="Masukkan nama lengkap terlapor">
                                                    @error('reported_person_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="reported_person_type">
                                                        <i class="fas fa-user-tag"></i> Tipe Terlapor
                                                        <span class="required-indicator">*</span>
                                                    </label>
                                                    <select name="reported_person_type"
                                                        class="form-control @error('reported_person_type') is-invalid @enderror"
                                                        required>
                                                        <option value="">-- Pilih Tipe --</option>
                                                        <option value="student"
                                                            {{ old('reported_person_type') == 'student' ? 'selected' : '' }}>
                                                            Mahasiswa
                                                        </option>
                                                        <option value="lecturer"
                                                            {{ old('reported_person_type') == 'lecturer' ? 'selected' : '' }}>
                                                            Dosen
                                                        </option>
                                                        <option value="staff"
                                                            {{ old('reported_person_type') == 'staff' ? 'selected' : '' }}>
                                                            Tendik
                                                        </option>
                                                        <option value="external"
                                                            {{ old('reported_person_type') == 'external' ? 'selected' : '' }}>
                                                            Eksternal
                                                        </option>
                                                    </select>
                                                    @error('reported_person_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="reported_person_email">
                                                <i class="fas fa-envelope"></i> Email Terlapor
                                            </label>
                                            <input type="email" name="reported_person_email"
                                                class="form-control @error('reported_person_email') is-invalid @enderror"
                                                value="{{ old('reported_person_email') }}"
                                                placeholder="email@example.com (opsional)">
                                            @error('reported_person_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Email ini akan digunakan untuk proses verifikasi dan pemberitahuan (jika
                                                diperlukan)
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Step 3: Detail Pelanggaran -->
                                    <div class="form-step" id="step3">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="mb-3">
                                                    <i class="fas fa-exclamation-triangle"></i> Detail Pelanggaran
                                                </h5>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="violation_type_id">
                                                        <i class="fas fa-list-alt"></i> Jenis Pelanggaran
                                                        <span class="required-indicator">*</span>
                                                    </label>
                                                    <select name="violation_type_id"
                                                        class="form-control @error('violation_type_id') is-invalid @enderror"
                                                        required>
                                                        <option value="">-- Pilih Jenis Pelanggaran --</option>
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="incident_date">
                                                        <i class="fas fa-calendar-alt"></i> Tanggal Kejadian
                                                    </label>
                                                    <input type="date" name="incident_date"
                                                        class="form-control @error('incident_date') is-invalid @enderror"
                                                        value="{{ old('incident_date') }}" max="{{ date('Y-m-d') }}">
                                                    @error('incident_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">
                                                <i class="fas fa-align-left"></i> Deskripsi Laporan
                                            </label>
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="6"
                                                placeholder="Jelaskan secara detail kronologi kejadian, tempat, waktu, dan hal-hal penting lainnya yang mendukung laporan Anda">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Semakin detail informasi yang Anda berikan, semakin mudah proses penanganan
                                                laporan ini
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Step 4: Bukti & Finalisasi -->
                                    <div class="form-step" id="step4">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="mb-3">
                                                    <i class="fas fa-paperclip"></i> Bukti Pendukung & Finalisasi
                                                </h5>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="evidence">
                                                <i class="fas fa-upload"></i> Upload Bukti (Opsional)
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" name="evidence[]"
                                                    class="custom-file-input @error('evidence.*') is-invalid @enderror"
                                                    id="evidenceInput" multiple
                                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.mp4,.mov,.avi">
                                                <label class="custom-file-label" for="evidenceInput">Pilih file
                                                    bukti...</label>
                                            </div>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle"></i>
                                                Dapat mengupload lebih dari satu file. Maksimal 20 MB per file.
                                                Format yang didukung: PDF, DOC, DOCX, JPG, PNG, MP4, MOV, AVI
                                            </small>
                                            @error('evidence.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="evidence-preview" id="evidencePreview"></div>
                                        </div>

                                        <div class="alert alert-info">
                                            <div class="alert-title">
                                                <i class="fas fa-shield-alt"></i> Perlindungan Data
                                            </div>
                                            Laporan Anda akan ditangani dengan kerahasiaan tinggi. Data pribadi akan
                                            dilindungi sesuai dengan kebijakan privasi institusi.
                                        </div>

                                        <div class="alert alert-warning">
                                            <div class="alert-title">
                                                <i class="fas fa-exclamation-triangle"></i> Peringatan
                                            </div>
                                            Pastikan semua informasi yang Anda berikan adalah benar dan dapat
                                            dipertanggungjawabkan. Laporan palsu dapat dikenakan sanksi.
                                        </div>
                                    </div>

                                    <!-- Navigation Buttons -->
                                    <div class="form-navigation">
                                        <button type="button" class="btn btn-secondary" id="prevBtn"
                                            style="display: none;">
                                            <i class="fas fa-arrow-left"></i> Sebelumnya
                                        </button>
                                        <div></div>
                                        <button type="button" class="btn btn-primary" id="nextBtn">
                                            Selanjutnya <i class="fas fa-arrow-right"></i>
                                        </button>
                                        <button type="submit" class="btn btn-success" id="submitBtn"
                                            style="display: none;">
                                            <i class="fas fa-paper-plane"></i> Kirim Laporan
                                        </button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 4;

            // Elements
            const steps = document.querySelectorAll('.form-step');
            const stepIndicators = document.querySelectorAll('.step-item');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');
            const progressBar = document.getElementById('progressBar');
            const evidenceInput = document.getElementById('evidenceInput');
            const evidencePreview = document.getElementById('evidencePreview');

            // Update progress bar
            function updateProgressBar() {
                const progress = (currentStep / totalSteps) * 100;
                progressBar.style.width = progress + '%';
            }

            // Show current step
            function showStep(step) {
                steps.forEach(s => s.classList.remove('active'));
                stepIndicators.forEach(s => s.classList.remove('active', 'completed'));

                document.getElementById('step' + step).classList.add('active');

                // Update step indicators
                for (let i = 1; i <= totalSteps; i++) {
                    const indicator = document.querySelector(`[data-step="${i}"]`);
                    if (i < step) {
                        indicator.classList.add('completed');
                    } else if (i === step) {
                        indicator.classList.add('active');
                    }
                }

                // Update navigation buttons
                prevBtn.style.display = step === 1 ? 'none' : 'inline-block';
                nextBtn.style.display = step === totalSteps ? 'none' : 'inline-block';
                submitBtn.style.display = step === totalSteps ? 'inline-block' : 'none';

                updateProgressBar();
            }

            // Validate current step
            function validateStep(step) {
                const currentStepElement = document.getElementById('step' + step);
                const requiredInputs = currentStepElement.querySelectorAll('input[required], select[required]');

                let valid = true;
                requiredInputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        valid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                return valid;
            }

            // Next button click
            nextBtn.addEventListener('click', function() {
                if (validateStep(currentStep)) {
                    if (currentStep < totalSteps) {
                        currentStep++;
                        showStep(currentStep);
                    }
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Mohon lengkapi data',
                        text: 'Silakan isi semua field yang wajib diisi sebelum melanjutkan.',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Previous button click
            prevBtn.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            // File input change
            evidenceInput.addEventListener('change', function(e) {
                const files = Array.from(e.target.files);
                evidencePreview.innerHTML = '';

                if (files.length > 0) {
                    const label = document.querySelector('label[for="evidenceInput"]');
                    label.textContent = files.length + ' file(s) dipilih';

                    files.forEach((file, index) => {
                        const fileItem = document.createElement('div');
                        fileItem.className = 'evidence-item';
                        fileItem.innerHTML = `
                    <i class="fas fa-file"></i> ${file.name}
                    <br><small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                `;
                        evidencePreview.appendChild(fileItem);
                    });
                }
            });

            // Initialize
            showStep(1);
        });
    </script>
@endpush
