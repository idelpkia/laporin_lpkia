@extends('layouts.app')
@section('title', 'Tambah Jenis Pelanggaran')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Jenis Pelanggaran</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        @include('pages.violation_types._form')
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
