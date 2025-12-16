<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - OpenHands</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-900 font-sans antialiased">

    <div class="min-h-screen flex items-center justify-center p-6 lg:p-12">
        <div class="w-full max-w-2xl">

       >

            <!-- Form Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8 lg:p-10">

                <!-- Header -->
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Buat Akun Baru
                    </h2>

                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div
                        class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3"></i>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-red-800 dark:text-red-200">
                                    Terjadi kesalahan:
                                </p>
                                <ul class="mt-1 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                           Nama Lengkap
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            autofocus
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white transition-all"
                            >
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white transition-all"
                           >
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white transition-all"
                               >
                            <button type="button" onclick="togglePassword('password', 'toggleIcon1')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                <i class="fas fa-eye" id="toggleIcon1"></i>
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Minimal 8 karakter
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                           </i>Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white transition-all"
                                >
                            <button type="button" onclick="togglePassword('password_confirmation', 'toggleIcon2')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                <i class="fas fa-eye" id="toggleIcon2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="terms" required
                                class="w-4 h-4 text-cyan-600 bg-gray-100 border-gray-300 rounded focus:ring-cyan-500 dark:focus:ring-cyan-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <label for="terms" class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                            Saya setuju dengan <a href="#"
                                class="text-cyan-600 hover:text-cyan-700 dark:text-cyan-400 font-medium hover:underline">Syarat
                                & Ketentuan</a> dan <a href="#"
                                class="text-cyan-600 hover:text-cyan-700 dark:text-cyan-400 font-medium hover:underline">Kebijakan
                                Privasi</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-3 px-4 bg-linear-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-2">
                        <span>Daftar Sekarang</span>
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                            Sudah punya akun?
                        </span>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <a href="{{ route('login') }}"
                        class="text-cyan-600 hover:text-cyan-700 dark:text-cyan-400 font-semibold hover:underline flex items-center justify-center space-x-2">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login</span>
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <p class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                © 2024 OpenHands. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();

        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
