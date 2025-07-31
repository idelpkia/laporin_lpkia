@extends('layouts.auth')

@section('title', 'Login - Portal Integritas Akademik')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="login-card">
        <div class="login-header">
            <h1>Portal Integritas Akademik</h1>
            <p class="subtitle">Sistem Pelaporan Pelanggaran Integritas Akademik</p>
        </div>

        <div class="login-body">
            <!-- Alert Petunjuk -->
            <div class="alert alert-info">
                <div class="alert-title">
                    <i class="fas fa-user-circle"></i> Petunjuk Login
                </div>
                <small>Gunakan akun email institusi Anda untuk mengakses sistem pelaporan</small>
            </div>

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                @csrf
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email Institusi
                    </label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" placeholder="nama@universitas.ac.id" value="{{ old('email') }}" tabindex="1"
                        autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" placeholder="Masukkan password Anda" tabindex="2">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" id="remember-me">
                        <label class="custom-control-label" for="remember-me">Ingat saya</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-login btn-lg btn-block" tabindex="4">
                        <i class="fas fa-sign-in-alt"></i> Masuk ke Sistem
                    </button>
                </div>
            </form>

            <!-- Informasi Sistem -->
            <div class="info-section">
                <h5><i class="fas fa-info-circle icon"></i>Tentang Sistem</h5>
                <p><i class="fas fa-bullhorn icon"></i>Portal pelaporan pelanggaran integritas akademik</p>
                <p><i class="fas fa-users icon"></i>Untuk seluruh civitas akademika</p>
                <p><i class="fas fa-lock icon"></i>Keamanan dan kerahasiaan terjamin</p>

                <ul class="features-list">
                    <li>Pelaporan online 24/7</li>
                    <li>Proses investigasi transparan</li>
                    <li>Notifikasi real-time</li>
                    <li>Sistem tracking status</li>
                </ul>
            </div>

            <!-- Informasi Tambahan -->
            <div class="text-center mt-4">
                <p class="text-muted">
                    <i class="fas fa-question-circle"></i>
                    Butuh bantuan? Hubungi Administrator IT
                </p>
                <p class="text-muted small">
                    <i class="fas fa-phone"></i> Ext: 0818918001 |
                    <i class="fas fa-envelope"></i> admin@lpkia.ac.id
                </p>
            </div>

            <!-- Footer Info -->
            <div class="text-center mt-4 pt-3" style="border-top: 1px solid #eee;">
                <p class="text-muted small">
                    <i class="fas fa-university"></i>
                    Portal Integritas Akademik - Institus Digital Ekonomi LPKIA
                </p>
                <p class="text-muted small">
                    © {{ date('Y') }} - Komisi Integritas Akademik
                </p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Auto focus on email field
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.focus();
            }
        });
    </script>
@endpush
