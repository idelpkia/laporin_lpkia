<div class="card">
    <div class="card-header">
        <h4>{{ isset($penaltyLevel) ? 'Edit Tingkat Sanksi' : 'Tambah Tingkat Sanksi' }}</h4>
    </div>
    <div class="card-body">
        <form method="POST"
            action="{{ isset($penaltyLevel) ? route('penalty-levels.update', $penaltyLevel) : route('penalty-levels.store') }}">
            @csrf
            @if (isset($penaltyLevel))
                @method('PUT')
            @endif

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Level Sanksi <span
                        class="text-danger">*</span></label>
                <div class="col-sm-12 col-md-7">
                    <select class="form-control select2 @error('level') is-invalid @enderror" name="level" required>
                        <option value="">Pilih Level Sanksi</option>
                        <option value="light"
                            {{ old('level', isset($penaltyLevel) ? $penaltyLevel->level : '') == 'light' ? 'selected' : '' }}>
                            Ringan
                        </option>
                        <option value="medium"
                            {{ old('level', isset($penaltyLevel) ? $penaltyLevel->level : '') == 'medium' ? 'selected' : '' }}>
                            Sedang
                        </option>
                        <option value="heavy"
                            {{ old('level', isset($penaltyLevel) ? $penaltyLevel->level : '') == 'heavy' ? 'selected' : '' }}>
                            Berat
                        </option>
                    </select>
                    @error('level')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <small class="form-text text-muted">Pilih tingkat sanksi yang sesuai</small>
                </div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                <div class="col-sm-12 col-md-7">
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5"
                        placeholder="Masukkan deskripsi tingkat sanksi (opsional)">{{ old('description', isset($penaltyLevel) ? $penaltyLevel->description : '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <small class="form-text text-muted">Deskripsi detail mengenai tingkat sanksi ini</small>
                </div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($penaltyLevel) ? 'Update' : 'Simpan' }}
                    </button>
                    <a href="{{ route('penalty-levels.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih Level Sanksi",
                allowClear: false
            });
        });
    </script>
@endpush
