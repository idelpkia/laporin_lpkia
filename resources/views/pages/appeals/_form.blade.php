@php
    $isEdit = isset($appeal) && $appeal->exists;
    $isReview = $isEdit && request()->routeIs('appeals.edit');
@endphp

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ $isEdit ? ($isReview ? 'Review Banding' : 'Detail Banding') : 'Form Pengajuan Banding' }}</h4>
            </div>
            <div class="card-body">
                @if (!$isEdit)
                    <!-- Form untuk pengajuan banding baru -->
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Laporan <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-12 col-md-7">
                            <select class="form-control select2 @error('report_id') is-invalid @enderror"
                                name="report_id" required>
                                <option value="">Pilih Laporan</option>
                                @foreach ($reports as $report)
                                    <option value="{{ $report->id }}"
                                        {{ old('report_id') == $report->id ? 'selected' : '' }}>
                                        #{{ $report->id }} - {{ $report->title ?? 'Laporan ' . $report->id }}
                                    </option>
                                @endforeach
                            </select>
                            @error('report_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Pilih laporan yang ingin Anda bandingkan</small>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Banding <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-12 col-md-7">
                            <input type="date" class="form-control @error('appeal_date') is-invalid @enderror"
                                name="appeal_date" value="{{ old('appeal_date', date('Y-m-d')) }}" required>
                            @error('appeal_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alasan Banding <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-12 col-md-7">
                            <textarea class="form-control @error('appeal_reason') is-invalid @enderror" name="appeal_reason" rows="6" required
                                placeholder="Jelaskan alasan mengapa Anda mengajukan banding untuk laporan ini. Sertakan bukti atau argumen yang mendukung banding Anda.">{{ old('appeal_reason') }}</textarea>
                            @error('appeal_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Maksimal 2000 karakter</small>
                        </div>
                    </div>
                @else
                    <!-- Display info untuk edit/review -->
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Laporan</label>
                        <div class="col-sm-12 col-md-7">
                            <div class="form-control-plaintext">
                                <div class="d-flex align-items-center">
                                    <div class="badge badge-secondary mr-2">#{{ $appeal->report->id ?? 'N/A' }}</div>
                                    <div>{{ $appeal->report->title ?? 'Laporan tidak ditemukan' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pemohon</label>
                        <div class="col-sm-12 col-md-7">
                            <div class="form-control-plaintext">
                                <div class="d-flex align-items-center">
                                    <figure class="avatar avatar-sm mr-2">
                                        <img alt="image"
                                            src="{{ $appeal->appellant->avatar ?? asset('img/avatar/avatar-1.png') }}"
                                            class="rounded-circle">
                                    </figure>
                                    <div>
                                        <div class="font-weight-600">{{ $appeal->appellant->name ?? 'Unknown' }}</div>
                                        <small class="text-muted">{{ $appeal->appellant->email ?? '' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Banding</label>
                        <div class="col-sm-12 col-md-7">
                            <div class="form-control-plaintext">
                                {{ \Carbon\Carbon::parse($appeal->appeal_date)->format('d F Y') }}
                                <small
                                    class="text-muted d-block">{{ \Carbon\Carbon::parse($appeal->appeal_date)->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alasan Banding</label>
                        <div class="col-sm-12 col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <p class="mb-0">{{ $appeal->appeal_reason }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($isReview)
                        <!-- Form review untuk dewan etik/admin -->
                        <hr class="my-4">
                        <h5 class="mb-3">Review Banding</h5>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Banding <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control @error('appeal_status') is-invalid @enderror"
                                    name="appeal_status" required>
                                    <option value="submitted"
                                        {{ old('appeal_status', $appeal->appeal_status) == 'submitted' ? 'selected' : '' }}>
                                        Diajukan</option>
                                    <option value="under_review"
                                        {{ old('appeal_status', $appeal->appeal_status) == 'under_review' ? 'selected' : '' }}>
                                        Dalam Review</option>
                                    <option value="approved"
                                        {{ old('appeal_status', $appeal->appeal_status) == 'approved' ? 'selected' : '' }}>
                                        Disetujui</option>
                                    <option value="rejected"
                                        {{ old('appeal_status', $appeal->appeal_status) == 'rejected' ? 'selected' : '' }}>
                                        Ditolak</option>
                                </select>
                                @error('appeal_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Hasil Review</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control @error('review_result') is-invalid @enderror" name="review_result" rows="6"
                                    placeholder="Masukkan hasil review, alasan keputusan, dan tindak lanjut yang diperlukan...">{{ old('review_result', $appeal->review_result) }}</textarea>
                                @error('review_result')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Jelaskan hasil review dan alasan keputusan</small>
                            </div>
                        </div>

                        @if ($appeal->reviewer)
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Reviewer Saat
                                    Ini</label>
                                <div class="col-sm-12 col-md-7">
                                    <div class="form-control-plaintext">
                                        <div class="d-flex align-items-center">
                                            <figure class="avatar avatar-sm mr-2">
                                                <img alt="image"
                                                    src="{{ $appeal->reviewer->avatar ?? asset('img/avatar/avatar-1.png') }}"
                                                    class="rounded-circle">
                                            </figure>
                                            <div>
                                                <div class="font-weight-600">{{ $appeal->reviewer->name }}</div>
                                                <small class="text-muted">{{ $appeal->reviewer->email }}</small>
                                            </div>
                                        </div>
                                        @if ($appeal->review_date)
                                            <small class="text-muted d-block mt-1">
                                                Direview pada:
                                                {{ \Carbon\Carbon::parse($appeal->review_date)->format('d F Y H:i') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Display status untuk view detail -->
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="form-control-plaintext">
                                    @php
                                        $statusClass = [
                                            'submitted' => 'badge-warning',
                                            'under_review' => 'badge-info',
                                            'approved' => 'badge-success',
                                            'rejected' => 'badge-danger',
                                        ];
                                        $statusText = [
                                            'submitted' => 'Diajukan',
                                            'under_review' => 'Dalam Review',
                                            'approved' => 'Disetujui',
                                            'rejected' => 'Ditolak',
                                        ];
                                    @endphp
                                    <div
                                        class="badge {{ $statusClass[$appeal->appeal_status] ?? 'badge-secondary' }} badge-lg">
                                        {{ $statusText[$appeal->appeal_status] ?? $appeal->appeal_status }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($appeal->review_result)
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Hasil
                                    Review</label>
                                <div class="col-sm-12 col-md-7">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="mb-0">{{ $appeal->review_result }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($appeal->reviewer)
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Reviewer</label>
                                <div class="col-sm-12 col-md-7">
                                    <div class="form-control-plaintext">
                                        <div class="d-flex align-items-center">
                                            <figure class="avatar avatar-sm mr-2">
                                                <img alt="image"
                                                    src="{{ $appeal->reviewer->avatar ?? asset('img/avatar/avatar-1.png') }}"
                                                    class="rounded-circle">
                                            </figure>
                                            <div>
                                                <div class="font-weight-600">{{ $appeal->reviewer->name }}</div>
                                                <small class="text-muted">{{ $appeal->reviewer->email }}</small>
                                            </div>
                                        </div>
                                        @if ($appeal->review_date)
                                            <small class="text-muted d-block mt-1">
                                                Direview pada:
                                                {{ \Carbon\Carbon::parse($appeal->review_date)->format('d F Y H:i') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif

                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                    <div class="col-sm-12 col-md-7">
                        @if (!$isEdit)
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Ajukan Banding
                            </button>
                        @elseif($isReview)
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Simpan Review
                            </button>
                        @endif
                        <a href="{{ route('appeals.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for report selection
            $('.select2').select2({
                width: '100%',
                placeholder: 'Pilih Laporan'
            });

            // Character counter for appeal reason
            $('textarea[name="appeal_reason"]').on('input', function() {
                var maxLength = 2000;
                var currentLength = $(this).val().length;
                var remaining = maxLength - currentLength;

                var counterHtml = '<small class="form-text text-muted">Tersisa ' + remaining +
                    ' karakter</small>';

                if (remaining < 0) {
                    counterHtml = '<small class="form-text text-danger">Melebihi batas maksimal ' + Math
                        .abs(remaining) + ' karakter</small>';
                }

                $(this).next('.invalid-feedback').next('.form-text').remove();
                $(this).parent().append(counterHtml);
            });
        });
    </script>
@endpush
