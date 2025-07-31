@extends('layouts.app')

@section('title', 'Detail Banding')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Banding</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('appeals.index') }}">Banding</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <!-- Status Alert -->
                @php
                    $statusAlert = [
                        'submitted' => ['warning', 'Banding telah diajukan dan menunggu review dari dewan etik.'],
                        'under_review' => ['info', 'Banding sedang dalam proses review oleh dewan etik.'],
                        'approved' => ['success', 'Banding telah disetujui. Laporan akan ditinjau ulang.'],
                        'rejected' => ['danger', 'Banding telah ditolak. Keputusan laporan tetap berlaku.'],
                    ];
                    $currentStatus = $statusAlert[$appeal->appeal_status] ?? ['secondary', 'Status tidak diketahui.'];
                @endphp

                <div class="alert alert-{{ $currentStatus[0] }}">
                    <div class="alert-title">Status Banding</div>
                    {{ $currentStatus[1] }}
                </div>

                <!-- Action Buttons -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('appeals.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                </a>
                            </div>
                            <div>
                                @if (auth()->user()->can('review-appeal') && in_array($appeal->appeal_status, ['submitted', 'under_review']))
                                    <a href="{{ route('appeals.edit', $appeal) }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Review Banding
                                    </a>
                                @endif

                                @if (auth()->id() == $appeal->appellant_id && $appeal->appeal_status == 'submitted')
                                    <form action="{{ route('appeals.destroy', $appeal) }}" method="POST"
                                        class="d-inline ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus banding ini?')">
                                            <i class="fas fa-trash"></i> Hapus Banding
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Form (Read-only) -->
                @include('appeals._form')

                <!-- Timeline -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Timeline Banding</h4>
                            </div>
                            <div class="card-body">
                                <div class="activities">
                                    <!-- Pengajuan Banding -->
                                    <div class="activity">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <div class="mb-2">
                                                <span
                                                    class="text-job">{{ \Carbon\Carbon::parse($appeal->appeal_date)->format('d F Y H:i') }}</span>
                                                <span class="bullet"></span>
                                                <span
                                                    class="text-job">{{ \Carbon\Carbon::parse($appeal->appeal_date)->diffForHumans() }}</span>
                                            </div>
                                            <p><strong>Banding Diajukan</strong></p>
                                            <p>Banding diajukan oleh <strong>{{ $appeal->appellant->name }}</strong></p>
                                        </div>
                                    </div>

                                    <!-- Review Process -->
                                    @if (in_array($appeal->appeal_status, ['under_review', 'approved', 'rejected']))
                                        <div class="activity">
                                            <div class="activity-icon bg-info text-white shadow-info">
                                                <i class="fas fa-search"></i>
                                            </div>
                                            <div class="activity-detail">
                                                <div class="mb-2">
                                                    <span class="text-job">Dalam Review</span>
                                                </div>
                                                <p><strong>Review Dimulai</strong></p>
                                                <p>Banding sedang dalam proses review oleh dewan etik</p>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Final Decision -->
                                    @if (in_array($appeal->appeal_status, ['approved', 'rejected']) && $appeal->review_date)
                                        <div class="activity">
                                            <div
                                                class="activity-icon bg-{{ $appeal->appeal_status == 'approved' ? 'success' : 'danger' }} text-white shadow-{{ $appeal->appeal_status == 'approved' ? 'success' : 'danger' }}">
                                                <i
                                                    class="fas fa-{{ $appeal->appeal_status == 'approved' ? 'check' : 'times' }}"></i>
                                            </div>
                                            <div class="activity-detail">
                                                <div class="mb-2">
                                                    <span
                                                        class="text-job">{{ \Carbon\Carbon::parse($appeal->review_date)->format('d F Y H:i') }}</span>
                                                    <span class="bullet"></span>
                                                    <span
                                                        class="text-job">{{ \Carbon\Carbon::parse($appeal->review_date)->diffForHumans() }}</span>
                                                </div>
                                                <p><strong>Banding
                                                        {{ $appeal->appeal_status == 'approved' ? 'Disetujui' : 'Ditolak' }}</strong>
                                                </p>
                                                <p>Keputusan dibuat oleh
                                                    <strong>{{ $appeal->reviewer->name ?? 'N/A' }}</strong>
                                                </p>
                                                @if ($appeal->review_result)
                                                    <div class="alert alert-light mt-2">
                                                        <strong>Catatan:</strong><br>
                                                        {{ $appeal->review_result }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Report Info -->
                @if ($appeal->report)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Informasi Laporan Terkait</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="font-weight-600">ID Laporan:</td>
                                                    <td>#{{ $appeal->report->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-600">Judul:</td>
                                                    <td>{{ $appeal->report->title ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-600">Status:</td>
                                                    <td>
                                                        <div class="badge badge-secondary">
                                                            {{ ucfirst($appeal->report->status ?? 'N/A') }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="font-weight-600">Tanggal Dibuat:</td>
                                                    <td>{{ $appeal->report->created_at ? \Carbon\Carbon::parse($appeal->report->created_at)->format('d F Y') : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-600">Terakhir Update:</td>
                                                    <td>{{ $appeal->report->updated_at ? \Carbon\Carbon::parse($appeal->report->updated_at)->format('d F Y') : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <a href="{{ route('reports.show', $appeal->report->id) }}"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-eye"></i> Lihat Detail Laporan
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
