<x-guest-layout>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            min-height: 100vh;
            width: 100vw;
            background: radial-gradient(circle at 20% 30%, #232526 0%, #232526 40%, #fff 100%),
                        radial-gradient(circle at 80% 80%, #444 0%, #232526 60%, #232526 100%);
            background-blend-mode: lighten, normal;
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
        }
        #app, .min-h-screen, .min-vh-100, .w-full, .container, .flex, .justify-center, .items-center {
            background: none !important;
            box-shadow: none !important;
        }
        .background-svg {
            position: absolute;
            top: -120px;
            left: -120px;
            z-index: 0;
            opacity: 0.18;
        }
        .background-svg2 {
            position: absolute;
            bottom: -120px;
            right: -120px;
            z-index: 0;
            opacity: 0.12;
        }
        .glass-card {
            position: relative;
            z-index: 1;
            background: rgba(30, 30, 30, 0.85);
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 370px;
            width: 100%;
            margin: 2rem auto;
        }
        .login-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
        }
        .input-field {
            background: rgba(60, 60, 60, 0.8);
            border: 1.5px solid #444;
            border-radius: 7px;
            color: #fff;
            padding: 12px;
            width: 100%;
            margin-bottom: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .input-field:focus {
            border-color: #888;
            box-shadow: 0 0 0 2px #fff4;
            background: rgba(60, 60, 60, 1);
        }
        .input-label {
            color: #bbb;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }
        .button {
            background: linear-gradient(90deg, #232526 0%, #444 100%);
            color: #fff;
            border: none;
            border-radius: 7px;
            padding: 12px 0;
            width: 100%;
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 1rem;
            box-shadow: 0 2px 8px #23252633;
            transition: background 0.3s, transform 0.2s;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .button:hover {
            background: linear-gradient(90deg, #444 0%, #232526 100%);
            transform: translateY(-2px) scale(1.03);
        }
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }
        .form-footer a {
            color: #bbb;
            text-decoration: none;
            font-size: 0.97rem;
            transition: color 0.2s;
        }
        .form-footer a:hover {
            color: #fff;
            text-decoration: underline;
        }
        .remember-label {
            color: #bbb;
            font-size: 0.97rem;
        }
    </style>
    <svg class="background-svg" width="400" height="400" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="200" cy="200" r="200" fill="url(#paint0_radial)"/>
        <defs>
            <radialGradient id="paint0_radial" cx="0" cy="0" r="1" gradientTransform="translate(200 200) scale(200)" gradientUnits="userSpaceOnUse">
                <stop stop-color="#fff"/>
                <stop offset="1" stop-color="#232526" stop-opacity="0"/>
            </radialGradient>
        </defs>
    </svg>
    <svg class="background-svg2" width="400" height="400" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="200" cy="200" r="200" fill="url(#paint1_radial)"/>
        <defs>
            <radialGradient id="paint1_radial" cx="0" cy="0" r="1" gradientTransform="translate(200 200) scale(200)" gradientUnits="userSpaceOnUse">
                <stop stop-color="#bbb"/>
                <stop offset="1" stop-color="#232526" stop-opacity="0"/>
            </radialGradient>
        </defs>
    </svg>
    <div class="glass-card">
        <div class="login-title">
            <!-- Replace with your logo if desired -->
            <span>🔒 FakeGuard Login</span>
        </div>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="input-label" />
                <x-text-input id="email" class="input-field" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="input-label" />
                <x-text-input id="password" class="input-field" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <!-- Remember Me & Forgot Password -->
            <div class="form-footer">
                <label for="remember_me" class="inline-flex items-center remember-label">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2">{{ __('Remember me') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                @endif
            </div>
            <x-primary-button class="button">{{ __('Log in') }}</x-primary-button>
        </form>
    </div>
</x-guest-layout>