@extends('layouts.app')
@section('title', 'Edit Jenis Pelanggaran')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Jenis Pelanggaran</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        @include('pages.violation_types._form', ['violationType' => $violationType])
                    </div>
                </div>
            </div>
        </section>
    @endsection
