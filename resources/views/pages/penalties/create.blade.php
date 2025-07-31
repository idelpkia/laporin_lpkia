@extends('layouts.app')

@section('title', 'Tambah Sanksi')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Sanksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('penalties.index') }}">Sanksi</a></div>
                    <div class="breadcrumb-item">Tambah</div>
                </div>
            </div>

            <div class="section-body">
                <form action="{{ route('penalties.store') }}" method="POST">
                    @csrf
                    @include('pages.penalties._form')
                </form>
            </div>
        </section>
    </div>
@endsection
