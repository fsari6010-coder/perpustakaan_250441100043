<x-guest-layout>
    <div class="auth-container">
        <div class="auth-heading">
            <h2>Selamat Datang Kembali!</h2>
            <p>Silakan masuk untuk mengakses Perpustakaan Kita.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="auth-field">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="auth-field">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input
                    id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="auth-remember">
                <label for="remember_me">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                    >
                    <span>Remember me</span>
                </label>
            </div>

            <div class="auth-actions">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif

                <x-primary-button>
                    Log in
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>