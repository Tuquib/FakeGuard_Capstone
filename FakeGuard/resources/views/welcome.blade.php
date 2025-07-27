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
        <!-- AOS Animation Library -->
        <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ once: false, duration: 800 });
          });
        </script>
        <style>
            body {
                position: relative;
                min-height: 100vh;
                overflow-x: hidden;
                background-color: #fff;
                color: #111;
                font-family: 'Poppins', sans-serif;
            }
            h1, .display-4, .lead, span, p {
                color: #111 !important;
            }
            .main-btn, .inline-block.px-5 {
                background: #111;
                color: #fff !important;
                border: 1.5px solid #111;
                transition: background 0.2s, color 0.2s, border 0.2s;
                text-decoration: none;
            }
            .main-btn:hover, .inline-block.px-5:hover {
                background: #fff;
                color: #111 !important;
                border: 1.5px solid #111;
                text-decoration: none;
            }
            .navbar-brand span {
                color: #111 !important;
            }
            .section {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                padding: 0 1rem;
            }
            .section-content {
                max-width: 700px;
                margin: 0 auto;
            }
            .section-alt {
                background: #f7f7f7;
            }
            @media (max-width: 600px) {
                .section-content { max-width: 98vw; }
                h1, .display-4 { font-size: 2rem !important; }
            }
        </style>
    </head>
    <body class="text-[#1b1b18] flex flex-col min-h-screen" style="min-height: 100vh;">
        <header style="width: 100%; max-width: 1100px; margin: 0 auto; padding: 1.5rem 1rem 0 1rem; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <img src="{{ asset('build/assets/images/logo.png') }}" alt="FakeGuard Logo" class="rounded-full object-cover shadow-sm" style="width: 80px; height: 80px;">
                <span style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 1.5rem; color: #111;">FakeGuard</span>
                    </div>
            <div style="display: flex; align-items: center; gap: 2rem;">
                        @auth
                    <a href="{{ url('/dashboard') }}" class="main-btn" style="padding: 0.5rem 1.5rem; font-size: 1rem; border-radius: 4px;">Dashboard</a>
                        @else
                    <a href="{{ route('login') }}" class="main-btn" style="padding: 0.5rem 1.5rem; font-size: 1rem; border-radius: 4px;">Log in</a>
                            @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="main-btn" style="padding: 0.5rem 1.5rem; font-size: 1rem; border-radius: 4px;">Signup</a>
                            @endif
                        @endauth
                    </div>
        </header>

        <!-- Hero Section -->
        <div class="section" data-aos="fade-up" style="flex: 1; display: flex; align-items: center; justify-content: center;">
            <div class="section-content text-center">
                <h1 class="display-4" style="font-family: 'Poppins', sans-serif; font-weight: bolder; font-size: 2.5rem;">Spot Fake News Instantly</h1>
                <p class="lead" style="font-size: 1.2rem; color: #444; margin-top: 1rem;">FakeGuard is a machine learning-based web application designed to detect fake news. It trained the BERT model to analyze the content of news articles and the Google Fact Check Tools API to verify claims against trusted sources.</p>
            </div>
        </div>

        <!-- How It Works Section -->
        <div class="section section-alt" data-aos="fade-right">
            <div class="section-content">
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #111;">How It Works</h2>
                <ul style="font-size: 1.1rem; color: #222; margin-top: 1.2rem;">
                    <li style="margin-bottom: 0.7em;"><strong>Paste a news article or link.</strong></li>
                    <li style="margin-bottom: 0.7em;"><strong>The BERT model</strong> analyzes the text for signs of misinformation.</li>
                    <li style="margin-bottom: 0.7em;"><strong>Fact-check integration</strong> finds related claims from trusted sources.</li>
                    <li style="margin-bottom: 0.7em;"><strong>See similar news</strong> for more context.</li>
                </ul>
            </div>
        </div>

        <!-- Limitations Section -->
        <div class="section" data-aos="fade-left">
            <div class="section-content">
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #111;">Limitations</h2>
                <p style="font-size: 1.1rem; color: #222; margin-top: 1.2rem;">
                    While FakeGuard leverages advanced trained model and fact-checking tools, not every article can be verified especially if it is new or obscure because it is limited API. The BERT model is state of the art but not perfect, so there may be occasional misclassifications, particularly with subtle or novel misinformation, because it was trained base on the datasets. References to similar news are provided for your context and research, but they may not always agree with the article being analyzed. Always use your own judgment alongside the platform’s results. It can detect through text and link only. And use English words only, it may not be accurate classification for other languages.  
                </p>
            </div>
        </div>

        <!-- Get Started Section -->
        <div class="section section-alt" data-aos="zoom-in">
            <div class="section-content text-center">
                <h2 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #111;">Ready to try FakeGuard?</h2>
                <a href="{{ route('register') }}" class="main-btn" style="padding: 0.75rem 2rem; font-size: 1.1rem; margin-top: 1.5rem;">Sign Up Free</a>
            </div>
        </div>
    </body>
</html>
