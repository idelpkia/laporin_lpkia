@extends('layouts.app')

@section('title', 'Edit Sanksi')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Sanksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('penalties.index') }}">Sanksi</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <form action="{{ route('penalties.update', $penalty) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('pages.penalties._form')
                </form>
            </div>
        </section>
    </div>
@endsection
