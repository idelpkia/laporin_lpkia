<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Nama <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="role">Peran <span class="text-danger">*</span></label>
            <select class="form-control selectric @error('role') is-invalid @enderror" id="role" name="role"
                required>
                <option value="">Pilih Peran</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="lecturer" {{ old('role', $user->role) == 'lecturer' ? 'selected' : '' }}>Dosen</option>
                <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staf</option>
                <option value="mahasiswa" {{ old('role', $user->role) == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa
                </option>
                <option value="kia_member" {{ old('role', $user->role) == 'kia_member' ? 'selected' : '' }}>KIA Member
                </option>
                <option value="investigator" {{ old('role', $user->role) == 'investigator' ? 'selected' : '' }}>
                    Investigator</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="department">Departemen <span class="text-danger">*</span></label>
            <select class="form-control selectric @error('department') is-invalid @enderror" id="department"
                name="department" required>
                <option value="">Pilih Departemen</option>
                <option value="Teknik Informatika"
                    {{ old('department', $user->department) == 'Teknik Informatika' ? 'selected' : '' }}>Teknik
                    Informatika</option>
                <option value="Sistem Informasi"
                    {{ old('department', $user->department) == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi
                </option>
                <option value="Teknik Komputer"
                    {{ old('department', $user->department) == 'Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer
                </option>
                <option value="Manajemen Informatika"
                    {{ old('department', $user->department) == 'Manajemen Informatika' ? 'selected' : '' }}>Manajemen
                    Informatika</option>
                <option value="Teknik Elektro"
                    {{ old('department', $user->department) == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro
                </option>
                <option value="Teknik Mesin"
                    {{ old('department', $user->department) == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin
                </option>
                <option value="Teknik Sipil"
                    {{ old('department', $user->department) == 'Teknik Sipil' ? 'selected' : '' }}>Teknik Sipil
                </option>
                <option value="Administrasi"
                    {{ old('department', $user->department) == 'Administrasi' ? 'selected' : '' }}>Administrasi
                </option>
            </select>
            @error('department')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <!-- Empty column for spacing -->
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">Password {!! isset($user->id) ? '' : '<span class="text-danger">*</span>' !!}</label>
            <div class="input-group">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" {{ !isset($user->id) ? 'required' : '' }}
                    placeholder="{{ isset($user->id) ? 'Kosongkan jika tidak ingin mengubah password' : 'Masukkan password' }}">
                <div class="input-group-append">
                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </span>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if (!isset($user->id))
                <small class="form-text text-muted">Password minimal 8 karakter</small>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password {!! isset($user->id) ? '' : '<span class="text-danger">*</span>' !!}</label>
            <div class="input-group">
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                    id="password_confirmation" name="password_confirmation" {{ !isset($user->id) ? 'required' : '' }}
                    placeholder="{{ isset($user->id) ? 'Kosongkan jika tidak ingin mengubah password' : 'Ulangi password' }}">
                <div class="input-group-append">
                    <span class="input-group-text" id="togglePasswordConfirmation" style="cursor: pointer;">
                        <i class="fas fa-eye" id="eyeIconConfirmation"></i>
                    </span>
                </div>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

@if (isset($user->id))
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        <strong>Catatan:</strong> Kosongkan field password jika tidak ingin mengubah password yang sudah ada.
    </div>
@endif

<div class="form-group">
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($user->id) ? 'Update' : 'Simpan' }}
        </button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize selectric for select elements
            $('.selectric').selectric();

            // Toggle password visibility
            $('#togglePassword').click(function() {
                const passwordField = $('#password');
                const eyeIcon = $('#eyeIcon');

                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Toggle password confirmation visibility
            $('#togglePasswordConfirmation').click(function() {
                const passwordField = $('#password_confirmation');
                const eyeIcon = $('#eyeIconConfirmation');

                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Toggle password requirement based on edit mode
            const isEdit = {{ isset($user->id) ? 'true' : 'false' }};

            if (isEdit) {
                // For edit mode, make password optional but validate if filled
                $('#password, #password_confirmation').on('input', function() {
                    const password = $('#password').val();
                    const confirmation = $('#password_confirmation').val();

                    if (password.length > 0 || confirmation.length > 0) {
                        $('#password, #password_confirmation').prop('required', true);
                    } else {
                        $('#password, #password_confirmation').prop('required', false);
                    }
                });
            }

            // Real-time password confirmation validation
            $('#password_confirmation').on('input', function() {
                const password = $('#password').val();
                const confirmation = $(this).val();

                if (password !== '' && confirmation !== '') {
                    if (password !== confirmation) {
                        $(this).addClass('is-invalid');
                        $(this).siblings('.invalid-feedback').remove();
                        $(this).parent().after(
                            '<div class="invalid-feedback d-block">Konfirmasi password tidak cocok.</div>'
                        );
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).parent().siblings('.invalid-feedback').remove();
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).parent().siblings('.invalid-feedback').remove();
                }
            });

            // Password strength indicator (optional)
            $('#password').on('input', function() {
                const password = $(this).val();
                let strength = 0;

                // Remove existing strength indicator
                $(this).parent().siblings('.password-strength').remove();

                if (password.length >= 8) strength++;
                if (/[a-z]/.test(password)) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;

                if (password.length > 0) {
                    let strengthText = '';
                    let strengthClass = '';

                    switch (strength) {
                        case 0:
                        case 1:
                            strengthText = 'Sangat Lemah';
                            strengthClass = 'text-danger';
                            break;
                        case 2:
                            strengthText = 'Lemah';
                            strengthClass = 'text-warning';
                            break;
                        case 3:
                            strengthText = 'Sedang';
                            strengthClass = 'text-info';
                            break;
                        case 4:
                            strengthText = 'Kuat';
                            strengthClass = 'text-success';
                            break;
                        case 5:
                            strengthText = 'Sangat Kuat';
                            strengthClass = 'text-success font-weight-bold';
                            break;
                    }

                    $(this).parent().after(
                        `<small class="password-strength ${strengthClass}">Kekuatan Password: ${strengthText}</small>`
                    );
                }
            });

            // Form validation before submit
            $('form').on('submit', function(e) {
                const password = $('#password').val();
                const confirmation = $('#password_confirmation').val();
                const isEdit = {{ isset($user->id) ? 'true' : 'false' }};

                // If it's create mode or password is filled in edit mode
                if (!isEdit || (isEdit && password.length > 0)) {
                    if (password !== confirmation) {
                        e.preventDefault();
                        $('#password_confirmation').addClass('is-invalid');
                        $('#password_confirmation').parent().after(
                            '<div class="invalid-feedback d-block">Konfirmasi password tidak cocok.</div>'
                        );
                        return false;
                    }

                    if (password.length < 8) {
                        e.preventDefault();
                        $('#password').addClass('is-invalid');
                        $('#password').parent().after(
                            '<div class="invalid-feedback d-block">Password minimal 8 karakter.</div>');
                        return false;
                    }
                }
            });
        });
    </script>
@endpush
