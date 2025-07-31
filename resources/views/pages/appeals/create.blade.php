@extends('layouts.app')

@section('title', 'Ajukan Banding')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Ajukan Banding</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('appeals.index') }}">Banding</a></div>
                    <div class="breadcrumb-item">Ajukan Banding</div>
                </div>
            </div>

            <div class="section-body">
                <!-- Info Alert -->
                <div class="alert alert-info">
                    <div class="alert-title">Informasi Pengajuan Banding</div>
                    Banding dapat diajukan untuk laporan yang telah selesai diproses. Pastikan Anda memberikan alasan yang
                    jelas dan bukti yang mendukung pengajuan banding Anda.
                </div>

                <form action="{{ route('appeals.store') }}" method="POST">
                    @csrf
                    @include('pages.appeals._form')
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
@endpush
