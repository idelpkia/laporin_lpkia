{{-- _form.blade.php --}}
@php
    $isEdit = isset($violationType);
@endphp

<form method="POST"
    action="{{ $isEdit ? route('violation-types.update', $violationType) : route('violation-types.store') }}">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="code">Kode <span class="text-danger">*</span></label>
        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" required
            value="{{ old('code', $violationType->code ?? '') }}">
        @error('code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="name">Nama <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required
            value="{{ old('name', $violationType->name ?? '') }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $violationType->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="category">Kategori <span class="text-danger">*</span></label>
        <select name="category" class="form-control @error('category') is-invalid @enderror" required>
            <option value="">-- Pilih --</option>
            @foreach (['plagiarism' => 'Plagiarisme', 'fabrication' => 'Fabrikasi', 'collusion' => 'Kolusi', 'document_forgery' => 'Pemalsuan Dokumen', 'ip_violation' => 'Pelanggaran Hak Cipta'] as $val => $label)
                <option value="{{ $val }}"
                    {{ old('category', $violationType->category ?? '') == $val ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </select>
        @error('category')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> {{ $isEdit ? 'Update' : 'Simpan' }}
    </button>
    <a href="{{ route('violation-types.index') }}" class="btn btn-secondary">Batal</a>
</form>
