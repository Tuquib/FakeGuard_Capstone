<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FakeGuard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
        
        @endif
        <style>
            body {
                position: relative;
                min-height: 100vh;
                overflow-x: hidden;
                background-color: #fff;
                color: #111;
            }
            h1, .display-4, .lead, span, p {
                color: #111 !important;
            }
            .main-btn, .inline-block.px-5 {
                background: #111;
                color: #fff !important;
                border: 1.5px solid #111;
                transition: background 0.2s, color 0.2s, border 0.2s;
            }
            .main-btn:hover, .inline-block.px-5:hover {
                background: #fff;
                color: #111 !important;
                border: 1.5px solid #111;
            }
            .navbar-brand span {
                color: #111 !important;
            }
        </style>
    </head>
    <body class="text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-between gap-4" style="max-width: 100%;">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('build/assets/images/logo.png') }}" alt="FakeGuard Logo" class="rounded-full object-cover shadow-sm" style="width: 100px; height: 100px;">
                        <span style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 1.25rem; color: #111;">
                            FakeGuard
                        </span>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="inline-block px-5 py-1.5 main-btn rounded-sm text-sm leading-normal"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-block px-5 py-1.5 main-btn rounded-sm text-sm leading-normal"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-block px-5 py-1.5 main-btn rounded-sm text-sm leading-normal">
                                    Signup
                                </a>
                            @endif
                        @endauth
                    </div>
                </nav>
            @endif
        </header>

        <div class="flex-1 flex items-center justify-center">
            <div class="text-center">
            <h1 class="display-4" style="color: #111; font-family: 'Poppins', sans-serif; font-weight: bolder;">Welcome to FakeGuard</h1>
            <p class="lead" style="color: #111; font-family: 'Poppins', sans-serif;">A Web Based Platform to Detect Fake News</p>
            </div>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
