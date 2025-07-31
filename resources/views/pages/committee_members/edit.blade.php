@extends('layouts.app')

@section('title', 'Edit Anggota KIA')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Anggota KIA</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('committee-members.index') }}">Komite Integritas</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Edit Anggota KIA - {{ $committeeMember->user->name }}</h4>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <div class="alert-title">Terjadi Kesalahan!</div>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="alert alert-warning">
                                    <div class="alert-title">Perhatian</div>
                                    <p class="mb-0">
                                        Perubahan data anggota KIA akan mempengaruhi status dan kewenangan dalam sistem.
                                        Pastikan perubahan yang dilakukan sudah sesuai dengan kebijakan institusi.
                                    </p>
                                </div>

                                <form action="{{ route('committee-members.update', $committeeMember) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @include('pages.committee_members._form')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
