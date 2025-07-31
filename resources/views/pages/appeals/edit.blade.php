@extends('layouts.app')

@section('title', 'Review Banding')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Review Banding</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('appeals.index') }}">Banding</a></div>
                    <div class="breadcrumb-item">Review</div>
                </div>
            </div>

            <div class="section-body">
                <!-- Warning Alert -->
                <div class="alert alert-warning">
                    <div class="alert-title">Perhatian!</div>
                    Anda sedang melakukan review terhadap pengajuan banding. Pastikan untuk mengevaluasi dengan cermat
                    sebelum memberikan keputusan.
                </div>

                <form action="{{ route('appeals.update', $appeal) }}" method="POST">
                    @csrf
                    @method('PUT')
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
