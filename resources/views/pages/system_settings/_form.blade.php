<div class="card">
    <div class="card-header">
        <h4>{{ isset($systemSetting) ? 'Edit Pengaturan Sistem' : 'Tambah Pengaturan Sistem' }}</h4>
    </div>
    <div class="card-body">
        <form method="POST"
            action="{{ isset($systemSetting) ? route('system-settings.update', $systemSetting) : route('system-settings.store') }}">
            @csrf
            @if (isset($systemSetting))
                @method('PUT')
            @endif

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Key <span
                        class="text-danger">*</span></label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control @error('key') is-invalid @enderror" name="key"
                        value="{{ old('key', isset($systemSetting) ? $systemSetting->key : '') }}"
                        placeholder="Masukkan key pengaturan" required>
                    @error('key')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <small class="form-text text-muted">Key harus unik, gunakan format snake_case (contoh: app_name,
                        max_file_size)</small>
                </div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Value</label>
                <div class="col-sm-12 col-md-7">
                    <textarea class="form-control @error('value') is-invalid @enderror" name="value" rows="4"
                        placeholder="Masukkan nilai pengaturan">{{ old('value', isset($systemSetting) ? $systemSetting->value : '') }}</textarea>
                    @error('value')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <small class="form-text text-muted">Nilai dari pengaturan sistem</small>
                </div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                <div class="col-sm-12 col-md-7">
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3"
                        placeholder="Masukkan deskripsi pengaturan (opsional)">{{ old('description', isset($systemSetting) ? $systemSetting->description : '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <small class="form-text text-muted">Penjelasan mengenai fungsi pengaturan ini</small>
                </div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($systemSetting) ? 'Update' : 'Simpan' }}
                    </button>
                    <a href="{{ route('system-settings.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
