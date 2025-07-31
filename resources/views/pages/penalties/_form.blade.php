@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>{{ isset($penalty) ? 'Edit' : 'Tambah' }} Sanksi</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="report_id">Laporan <span class="text-danger">*</span></label>
                    <select name="report_id" id="report_id"
                        class="form-control select2 @error('report_id') is-invalid @enderror" required>
                        <option value="">Pilih Laporan</option>
                        @foreach ($reports as $report)
                            <option value="{{ $report->id }}"
                                {{ old('report_id', $penalty->report_id ?? '') == $report->id ? 'selected' : '' }}>
                                {{ $report->title }} (ID: {{ $report->id }})
                            </option>
                        @endforeach
                    </select>
                    @error('report_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="penalty_level_id">Tingkat Sanksi <span class="text-danger">*</span></label>
                    <select name="penalty_level_id" id="penalty_level_id"
                        class="form-control select2 @error('penalty_level_id') is-invalid @enderror" required>
                        <option value="">Pilih Tingkat Sanksi</option>
                        @foreach ($penaltyLevels as $level)
                            <option value="{{ $level->id }}"
                                {{ old('penalty_level_id', $penalty->penalty_level_id ?? '') == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('penalty_level_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="penalty_type">Jenis Sanksi <span class="text-danger">*</span></label>
                    <input type="text" name="penalty_type" id="penalty_type"
                        class="form-control @error('penalty_type') is-invalid @enderror"
                        value="{{ old('penalty_type', $penalty->penalty_type ?? '') }}"
                        placeholder="Masukkan jenis sanksi" required>
                    @error('penalty_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="decided_by">Diputuskan Oleh <span class="text-danger">*</span></label>
                    <select name="decided_by" id="decided_by"
                        class="form-control select2 @error('decided_by') is-invalid @enderror" required>
                        <option value="">Pilih Pejabat</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('decided_by', $penalty->decided_by ?? '') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('decided_by')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                        class="form-control @error('description') is-invalid @enderror" placeholder="Masukkan deskripsi sanksi (opsional)">{{ old('description', $penalty->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>Detail Tambahan</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                        required>
                        <option value="">Pilih Status</option>
                        <option value="recommended"
                            {{ old('status', $penalty->status ?? '') == 'recommended' ? 'selected' : '' }}>
                            Direkomendasikan
                        </option>
                        <option value="approved"
                            {{ old('status', $penalty->status ?? '') == 'approved' ? 'selected' : '' }}>
                            Disetujui
                        </option>
                        <option value="executed"
                            {{ old('status', $penalty->status ?? '') == 'executed' ? 'selected' : '' }}>
                            Dijalankan
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="recommendation_date">Tanggal Rekomendasi</label>
                    <input type="text" name="recommendation_date" id="recommendation_date"
                        class="form-control datepicker @error('recommendation_date') is-invalid @enderror"
                        value="{{ old('recommendation_date', $penalty->recommendation_date ?? '') }}"
                        placeholder="Pilih tanggal">
                    @error('recommendation_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sk_number">Nomor SK</label>
                    <input type="text" name="sk_number" id="sk_number"
                        class="form-control @error('sk_number') is-invalid @enderror"
                        value="{{ old('sk_number', $penalty->sk_number ?? '') }}" placeholder="Masukkan nomor SK">
                    @error('sk_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sk_date">Tanggal SK</label>
                    <input type="text" name="sk_date" id="sk_date"
                        class="form-control datepicker @error('sk_date') is-invalid @enderror"
                        value="{{ old('sk_date', $penalty->sk_date ?? '') }}" placeholder="Pilih tanggal">
                    @error('sk_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> {{ isset($penalty) ? 'Perbarui' : 'Simpan' }} Sanksi
                    </button>
                    <a href="{{ route('penalties.index') }}" class="btn btn-secondary btn-block mt-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

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
