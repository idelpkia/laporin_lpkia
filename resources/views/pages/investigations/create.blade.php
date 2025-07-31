@extends('layouts.app')

@section('title', 'Buat Investigasi')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Buat Investigasi Baru</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('investigations.index') }}">Investigasi</a></div>
                    <div class="breadcrumb-item">Buat</div>
                </div>
            </div>

            <div class="section-body">
                <form action="{{ route('investigations.store') }}" method="POST">
                    @csrf
                    @include('pages.investigations._form')
                </form>
            </div>
        </section>
    </div>
@endsection
