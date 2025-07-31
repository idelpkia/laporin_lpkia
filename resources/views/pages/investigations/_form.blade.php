@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>{{ isset($investigation) ? 'Edit' : 'Buat' }} Investigasi</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="report_id">Laporan <span class="text-danger">*</span></label>
                    <select name="report_id" id="report_id"
                        class="form-control select2 @error('report_id') is-invalid @enderror"
                        {{ isset($investigation) ? 'disabled' : 'required' }}>
                        <option value="">Pilih Laporan</option>
                        @if (isset($investigation))
                            <option value="{{ $investigation->report_id }}" selected>
                                {{ $investigation->report->title }} (ID: {{ $investigation->report_id }})
                            </option>
                        @else
                            @foreach ($reports as $report)
                                <option value="{{ $report->id }}"
                                    {{ old('report_id') == $report->id ? 'selected' : '' }}>
                                    {{ $report->title }} (ID: {{ $report->id }})
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @if (isset($investigation))
                        <input type="hidden" name="report_id" value="{{ $investigation->report_id }}">
                        <small class="text-muted">Laporan tidak dapat diubah setelah investigasi dibuat</small>
                    @endif
                    @error('report_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="team_leader_id">Ketua Tim Investigasi <span class="text-danger">*</span></label>
                    <select name="team_leader_id" id="team_leader_id"
                        class="form-control select2 @error('team_leader_id') is-invalid @enderror" required>
                        <option value="">Pilih Ketua Tim</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('team_leader_id', $investigation->team_leader_id ?? '') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('team_leader_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status Investigasi <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                        required>
                        <option value="">Pilih Status</option>
                        <option value="formed"
                            {{ old('status', $investigation->status ?? '') == 'formed' ? 'selected' : '' }}>
                            Dibentuk
                        </option>
                        <option value="document_review"
                            {{ old('status', $investigation->status ?? '') == 'document_review' ? 'selected' : '' }}>
                            Review Dokumen
                        </option>
                        <option value="calling_parties"
                            {{ old('status', $investigation->status ?? '') == 'calling_parties' ? 'selected' : '' }}>
                            Pemanggilan Pihak Terkait
                        </option>
                        <option value="report_writing"
                            {{ old('status', $investigation->status ?? '') == 'report_writing' ? 'selected' : '' }}>
                            Penulisan Laporan
                        </option>
                        <option value="completed"
                            {{ old('status', $investigation->status ?? '') == 'completed' ? 'selected' : '' }}>
                            Selesai
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>Timeline Investigasi</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="start_date">Tanggal Mulai</label>
                    <input type="text" name="start_date" id="start_date"
                        class="form-control datepicker @error('start_date') is-invalid @enderror"
                        value="{{ old('start_date', $investigation->start_date ?? '') }}"
                        placeholder="Pilih tanggal mulai">
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_date">Tanggal Selesai</label>
                    <input type="text" name="end_date" id="end_date"
                        class="form-control datepicker @error('end_date') is-invalid @enderror"
                        value="{{ old('end_date', $investigation->end_date ?? '') }}"
                        placeholder="Pilih tanggal selesai">
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Kosongkan jika investigasi belum selesai</small>
                </div>

                <!-- Progress Indicator -->
                @if (isset($investigation))
                    <div class="form-group">
                        <label>Progress Investigasi</label>
                        @php
                            $statuses = [
                                'formed' => 'Dibentuk',
                                'document_review' => 'Review Dokumen',
                                'calling_parties' => 'Pemanggilan',
                                'report_writing' => 'Penulisan Laporan',
                                'completed' => 'Selesai',
                            ];
                            $currentIndex = array_search($investigation->status, array_keys($statuses));
                            $progress = (($currentIndex + 1) / count($statuses)) * 100;
                        @endphp
                        <div class="progress mb-2" data-height="8">
                            <div class="progress-bar 
                                @if ($progress < 40) bg-danger
                                @elseif($progress < 80) bg-warning
                                @else bg-success @endif"
                                data-width="{{ $progress }}%"></div>
                        </div>
                        <small class="text-muted">{{ round($progress) }}% selesai</small>
                    </div>
                @endif

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> {{ isset($investigation) ? 'Perbarui' : 'Buat' }} Investigasi
                    </button>
                    <a href="{{ route('investigations.index') }}" class="btn btn-secondary btn-block mt-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </div>
        </div>

        <!-- Status Guidelines -->
        <div class="card">
            <div class="card-header">
                <h4>Panduan Status</h4>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                        <small><strong>Dibentuk:</strong> Tim investigasi telah dibentuk</small>
                        <span class="badge badge-secondary badge-sm">1</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                        <small><strong>Review Dokumen:</strong> Analisis dokumen dan bukti</small>
                        <span class="badge badge-info badge-sm">2</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                        <small><strong>Pemanggilan:</strong> Wawancara pihak terkait</small>
                        <span class="badge badge-warning badge-sm">3</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                        <small><strong>Penulisan Laporan:</strong> Menyusun hasil investigasi</small>
                        <span class="badge badge-primary badge-sm">4</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center p-2">
                        <small><strong>Selesai:</strong> Investigasi telah selesai</small>
                        <span class="badge badge-success badge-sm">5</span>
                    </div>
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

            // Validate end date is after start date
            $('#start_date, #end_date').on('change', function() {
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();

                if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
                    alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai');
                    $('#end_date').val('');
                }
            });
        });
    </script>
@endpush
