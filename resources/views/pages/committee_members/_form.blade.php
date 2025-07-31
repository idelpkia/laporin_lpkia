<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="user_id">Pilih User <span class="text-danger">*</span></label>
            <select class="form-control selectric @error('user_id') is-invalid @enderror" id="user_id" name="user_id"
                required>
                <option value="">Pilih User</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" data-email="{{ $user->email }}" data-role="{{ $user->role }}"
                        data-department="{{ $user->department }}"
                        {{ old('user_id', isset($committeeMember) ? $committeeMember->user_id : '') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} - {{ $user->role }} ({{ $user->department ?? 'No Dept' }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Pilih user yang akan dijadikan anggota KIA</small>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="position">Posisi <span class="text-danger">*</span></label>
            <select class="form-control selectric @error('position') is-invalid @enderror" id="position"
                name="position" required>
                <option value="">Pilih Posisi</option>
                <option value="chairman"
                    {{ old('position', isset($committeeMember) ? $committeeMember->position : '') == 'chairman' ? 'selected' : '' }}>
                    Ketua
                </option>
                <option value="secretary"
                    {{ old('position', isset($committeeMember) ? $committeeMember->position : '') == 'secretary' ? 'selected' : '' }}>
                    Sekretaris
                </option>
                <option value="member"
                    {{ old('position', isset($committeeMember) ? $committeeMember->position : '') == 'member' ? 'selected' : '' }}>
                    Anggota
                </option>
            </select>
            @error('position')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="start_date">Tanggal Mulai</label>
            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                name="start_date"
                value="{{ old('start_date', isset($committeeMember) ? $committeeMember->start_date : '') }}">
            @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Tanggal mulai menjabat sebagai anggota KIA</small>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="end_date">Tanggal Selesai</label>
            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                name="end_date"
                value="{{ old('end_date', isset($committeeMember) ? $committeeMember->end_date : '') }}">
            @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Kosongkan jika belum ada tanggal selesai</small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Status Keaktifan <span class="text-danger">*</span></label>
            <div class="form-check-inline">
                <div class="custom-control custom-radio">
                    <input type="radio" id="active_yes" name="is_active" value="1"
                        class="custom-control-input @error('is_active') is-invalid @enderror"
                        {{ old('is_active', isset($committeeMember) ? $committeeMember->is_active : '1') == '1' ? 'checked' : '' }}
                        required>
                    <label class="custom-control-label" for="active_yes">
                        <span class="badge badge-success">Aktif</span>
                    </label>
                </div>
                <div class="custom-control custom-radio ml-3">
                    <input type="radio" id="active_no" name="is_active" value="0"
                        class="custom-control-input @error('is_active') is-invalid @enderror"
                        {{ old('is_active', isset($committeeMember) ? $committeeMember->is_active : '1') == '0' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="active_no">
                        <span class="badge badge-danger">Tidak Aktif</span>
                    </label>
                </div>
            </div>
            @error('is_active')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Status keaktifan anggota dalam komite</small>
        </div>
    </div>

    <div class="col-md-6">
        <!-- User Info Preview -->
        <div id="user-info" class="card" style="display: none;">
            <div class="card-header">
                <h6 class="mb-0">Informasi User</h6>
            </div>
            <div class="card-body">
                <div id="user-details">
                    <!-- Will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

@if (isset($committeeMember))
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        <strong>Catatan:</strong> Perubahan data akan mempengaruhi status keanggotaan dalam Komite Integritas Akademik.
    </div>
@endif

<div class="form-group">
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($committeeMember) ? 'Update' : 'Simpan' }}
        </button>
        <a href="{{ route('committee-members.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize selectric for select elements
            $('.selectric').selectric();

            // Show user info when user is selected
            $('#user_id').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const userInfo = $('#user-info');
                const userDetails = $('#user-details');

                if ($(this).val()) {
                    const email = selectedOption.data('email');
                    const role = selectedOption.data('role');
                    const department = selectedOption.data('department');

                    userDetails.html(`
                <div class="row">
                    <div class="col-sm-4"><strong>Email:</strong></div>
                    <div class="col-sm-8">${email}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><strong>Role:</strong></div>
                    <div class="col-sm-8"><span class="badge badge-primary">${role}</span></div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><strong>Departemen:</strong></div>
                    <div class="col-sm-8">${department || '-'}</div>
                </div>
            `);

                    userInfo.fadeIn();
                } else {
                    userInfo.fadeOut();
                }
            });

            // Trigger change event if user is already selected (for edit mode)
            if ($('#user_id').val()) {
                $('#user_id').trigger('change');
            }

            // Date validation
            $('#start_date, #end_date').on('change', function() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();

                if (startDate && endDate) {
                    if (new Date(endDate) < new Date(startDate)) {
                        $('#end_date').addClass('is-invalid');
                        $('#end_date').siblings('.invalid-feedback').remove();
                        $('#end_date').after(
                            '<div class="invalid-feedback">Tanggal selesai tidak boleh lebih awal dari tanggal mulai.</div>'
                        );
                    } else {
                        $('#end_date').removeClass('is-invalid');
                        $('#end_date').siblings('.invalid-feedback').remove();
                    }
                }
            });

            // Position info tooltips
            const positionInfo = {
                'chairman': 'Memimpin rapat dan mengambil keputusan strategis komite',
                'secretary': 'Mencatat notulen rapat dan mengelola administrasi komite',
                'member': 'Berpartisipasi dalam rapat dan memberikan masukan'
            };

            $('#position').on('change', function() {
                const position = $(this).val();
                const info = positionInfo[position];

                // Remove existing tooltip
                $(this).siblings('.position-info').remove();

                if (info) {
                    $(this).after(`<small class="position-info text-muted mt-1">${info}</small>`);
                }
            });

            // Form validation before submit
            $('form').on('submit', function(e) {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();

                // Validate date range
                if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
                    e.preventDefault();
                    $('#end_date').addClass('is-invalid');
                    $('#end_date').siblings('.invalid-feedback').remove();
                    $('#end_date').after(
                        '<div class="invalid-feedback">Tanggal selesai tidak boleh lebih awal dari tanggal mulai.</div>'
                    );

                    // Scroll to error
                    $('html, body').animate({
                        scrollTop: $('#end_date').offset().top - 100
                    }, 500);

                    return false;
                }
            });

            // Auto-fill start date with today if empty
            if (!$('#start_date').val() && !{{ isset($committeeMember) ? 'true' : 'false' }}) {
                const today = new Date().toISOString().split('T')[0];
                $('#start_date').val(today);
            }
        });
    </script>
@endpush
