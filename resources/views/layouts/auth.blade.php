<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>@yield('title') &mdash; Stisla</title>

        <!-- General CSS Files -->
        <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        @stack('style')

        {{-- style tambahandi sini --}}
        <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
        <style>
            .login-container {
                background: linear-gradient(135deg, #0d36ec 0%, #5c18a0 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px 0;
            }

            .login-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                overflow: hidden;
            }

            .login-header {
                background: linear-gradient(135deg, #0e88f3 0%, #01a3ac 100%);
                color: white;
                padding: 40px 30px;
                text-align: center;
                position: relative;
            }

            .login-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.1)"><polygon points="1000,100 1000,0 0,100"/></svg>');
                background-size: cover;
            }

            .login-header h1 {
                font-size: 2.2rem;
                font-weight: 700;
                margin-bottom: 10px;
                position: relative;
                z-index: 1;
            }

            .login-header .subtitle {
                font-size: 1.1rem;
                opacity: 0.9;
                position: relative;
                z-index: 1;
            }

            .login-body {
                padding: 40px 30px;
            }

            .info-section {
                background: linear-gradient(135deg, #fa455d 0%, #e61f5a 100%);
                color: white;
                padding: 30px;
                border-radius: 15px;
                margin-bottom: 30px;
                position: relative;
                overflow: hidden;
            }

            .info-section::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
                animation: pulse 4s ease-in-out infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    transform: scale(1);
                    opacity: 0.7;
                }

                50% {
                    transform: scale(1.1);
                    opacity: 0.4;
                }
            }

            .info-section h5 {
                font-weight: 600;
                margin-bottom: 15px;
                position: relative;
                z-index: 1;
            }

            .info-section p {
                margin-bottom: 10px;
                font-size: 0.9rem;
                opacity: 0.95;
                position: relative;
                z-index: 1;
            }

            .info-section .icon {
                font-size: 1.2rem;
                margin-right: 8px;
            }

            .form-group {
                margin-bottom: 25px;
            }

            .form-group label {
                font-weight: 600;
                color: #333;
                margin-bottom: 8px;
                display: block;
            }

            .form-control {
                height: 50px;
                border-radius: 10px;
                border: 2px solid #e9ecef;
                padding: 0 20px;
                font-size: 16px;
                transition: all 0.3s ease;
                background: rgba(255, 255, 255, 0.9);
            }

            .form-control:focus {
                border-color: #4facfe;
                box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
                background: white;
            }

            .btn-login {
                height: 50px;
                border-radius: 10px;
                font-size: 16px;
                font-weight: 600;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                color: white;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
                color: white;
            }

            .btn-login::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.5s;
            }

            .btn-login:hover::before {
                left: 100%;
            }

            .features-list {
                list-style: none;
                padding: 0;
                margin-top: 20px;
            }

            .features-list li {
                padding: 8px 0;
                position: relative;
                padding-left: 30px;
                position: relative;
                z-index: 1;
            }

            .features-list li::before {
                content: '✓';
                position: absolute;
                left: 0;
                color: rgba(255, 255, 255, 0.9);
                font-weight: bold;
                font-size: 1.1rem;
            }

            .alert-info {
                background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
                border: none;
                color: white;
                border-radius: 10px;
                padding: 15px 20px;
                margin-bottom: 20px;
            }

            .alert-info .alert-title {
                font-weight: 600;
                margin-bottom: 5px;
            }

            @media (max-width: 768px) {
                .login-header {
                    padding: 30px 20px;
                }

                .login-header h1 {
                    font-size: 1.8rem;
                }

                .login-body {
                    padding: 30px 20px;
                }

                .info-section {
                    padding: 20px;
                }
            }
        </style>

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components.css') }}">
        <!-- Start GA -->
        {{-- <script async
        src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script> --}}
        <!-- END GA -->
    </head>

    <body>
        <div id="app">
            <section class="section">
                <div class="container mt-5">
                    <div class="row">
                        <div
                            class="{{ Request::is('auth-register') ? 'col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2' : 'col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2' }}">
                            <!-- Footer -->
                            @include('components.auth-header')

                            <!-- Content -->
                            @yield('main')

                            <!-- Footer -->
                            @include('components.auth-footer')
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- General JS Scripts -->
        <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
        <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
        <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
        <script src="{{ asset('js/stisla.js') }}"></script>

        @stack('scripts')

        <!-- Template JS File -->
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
    </body>

</html>
