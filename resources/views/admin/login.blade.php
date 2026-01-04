{{-- resources/views/admin/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | Netourism</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex items-center justify-center p-4">

<div class="w-full max-w-md">
    {{-- Container --}}
    <div class="bg-white/95 backdrop-blur-lg shadow-xl rounded-2xl border border-slate-200 p-8">

        {{-- Logo / Heading --}}
        <div class="mb-6 text-center">
            <h1 class="text-xl font-bold text-slate-800">
                Admin Login
            </h1>
            <p class="text-sm text-slate-500">
                Access restricted dashboard
            </p>
        </div>

        {{-- Flash Error --}}
        @if(session('error'))
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Login Form --}}
        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-slate-800 mb-1">
                    Email Address
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    value="{{ old('email') }}"
                    class="block w-full h-12 px-4 rounded-lg border border-slate-300 bg-white text-base text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                    placeholder="admin@example.com"
                >
            </div>

            {{-- Password + Toggle (pure JS) --}}
            <div>
                <label for="password" class="block text-sm font-medium text-slate-800 mb-1">
                    Password
                </label>

                <div class="relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="block w-full h-12 px-4 pr-12 rounded-lg border border-slate-300 bg-white text-base text-slate-800 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="••••••••"
                    >

                    {{-- Toggle Button --}}
                    <button
                        type="button"
                        id="togglePassword"
                        class="absolute inset-y-0 right-3 flex items-center text-slate-500 hover:text-slate-700"
                        aria-label="Toggle password visibility"
                    >
                        {{-- Eye (show) --}}
                        <svg id="iconShow" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 
                                     7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>

                        {{-- Eye with slash (hide) --}}
                        <svg id="iconHide" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.018 
                                     10.018 0 012.406-4.263m3.489-2.484A9.959 9.959 0 0112 5c4.477 0 8.268 2.943 
                                     9.542 7a10.05 10.05 0 01-4.027 5.307M15 12a3 3 0 00-3-3"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center gap-2">
                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                    class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                >
                <label for="remember" class="text-sm text-slate-700 select-none">Remember me</label>
            </div>

            {{-- Login Button --}}
            <button
                type="submit"
                class="w-full flex justify-center h-12 items-center rounded-lg bg-emerald-600 px-4 py-2 text-base font-semibold text-white shadow-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
            >
                Sign In
            </button>
        </form>

        {{-- Footer --}}
        <p class="mt-6 text-center text-xs text-slate-500">
            Protected Admin Area • Netourism
        </p>
    </div>
</div>

{{-- Simple JS for password toggle --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        const iconShow = document.getElementById('iconShow');
        const iconHide = document.getElementById('iconHide');

        if (passwordInput && toggleButton && iconShow && iconHide) {
            toggleButton.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';

                // Toggle icons
                if (isPassword) {
                    iconShow.classList.add('hidden');
                    iconHide.classList.remove('hidden');
                } else {
                    iconShow.classList.remove('hidden');
                    iconHide.classList.add('hidden');
                }
            });
        }
    });
</script>

</body>
</html>
