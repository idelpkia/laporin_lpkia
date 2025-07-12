@extends('layouts.app')
@section('title', 'Detail Jenis Pelanggaran')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Jenis Pelanggaran</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $violationType->name }}</h4>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-3">Kode</dt>
                            <dd class="col-sm-9">{{ $violationType->code }}</dd>
                            <dt class="col-sm-3">Nama</dt>
                            <dd class="col-sm-9">{{ $violationType->name }}</dd>
                            <dt class="col-sm-3">Kategori</dt>
                            <dd class="col-sm-9">{{ ucfirst($violationType->category) }}</dd>
                            <dt class="col-sm-3">Deskripsi</dt>
                            <dd class="col-sm-9">{{ $violationType->description }}</dd>
                        </dl>
                        <a href="{{ route('violation-types.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
