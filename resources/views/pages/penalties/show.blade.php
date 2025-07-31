@extends('layouts.app')

@section('title', 'Detail Sanksi')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Sanksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('penalties.index') }}">Sanksi</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
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

                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Sanksi</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('penalties.edit', $penalty) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('penalties.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Status Sanksi</label>
                                            <div>
                                                @if ($penalty->status == 'recommended')
                                                    <span class="badge badge-warning badge-lg">Direkomendasikan</span>
                                                @elseif($penalty->status == 'approved')
                                                    <span class="badge badge-success badge-lg">Disetujui</span>
                                                @elseif($penalty->status == 'executed')
                                                    <span class="badge badge-primary badge-lg">Dijalankan</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Laporan Terkait</label>
                                            <div class="card card-info">
                                                <div class="card-body p-3">
                                                    <h6 class="mb-1">{{ $penalty->report->title ?? 'N/A' }}</h6>
                                                    <small class="text-muted">ID Laporan: {{ $penalty->report_id }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Tingkat Sanksi</label>
                                            <div>
                                                <span class="badge badge-info badge-lg">
                                                    {{ $penalty->penaltyLevel->name ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Jenis Sanksi</label>
                                            <p class="mb-0">{{ $penalty->penalty_type }}</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tanggal Rekomendasi</label>
                                            <p class="mb-0">
                                                {{ $penalty->recommendation_date ? \Carbon\Carbon::parse($penalty->recommendation_date)->format('d F Y') : '-' }}
                                            </p>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Diputuskan Oleh</label>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-2">
                                                    <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}"
                                                        class="rounded-circle">
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">{{ $penalty->decider->name ?? 'N/A' }}
                                                    </div>
                                                    <div class="text-muted small">{{ $penalty->decider->email ?? '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Nomor SK</label>
                                            <p class="mb-0">{{ $penalty->sk_number ?: '-' }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Tanggal SK</label>
                                            <p class="mb-0">
                                                {{ $penalty->sk_date ? \Carbon\Carbon::parse($penalty->sk_date)->format('d F Y') : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                @if ($penalty->description)
                                    <div class="form-group">
                                        <label class="font-weight-bold">Deskripsi</label>
                                        <div class="card card-light">
                                            <div class="card-body">
                                                <p class="mb-0">{{ $penalty->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Dibuat Pada</label>
                                            <p class="mb-0">{{ $penalty->created_at->format('d F Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Terakhir Diperbarui</label>
                                            <p class="mb-0">{{ $penalty->updated_at->format('d F Y, H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
