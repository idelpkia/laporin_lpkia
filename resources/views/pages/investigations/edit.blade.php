@extends('layouts.app')

@section('title', 'Edit Investigasi')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Investigasi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('investigations.index') }}">Investigasi</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <form action="{{ route('investigations.update', $investigation) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('pages.investigations._form')
                </form>
            </div>
        </section>
    </div>
@endsection
