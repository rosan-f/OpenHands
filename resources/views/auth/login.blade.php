<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>OpenHands — Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Vite (Tailwind) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-linear-to-br from-blue-500 via-purple-600 to-pink-500 font-sans antialiased flex items-center justify-center">

    <div class="w-full max-w-5xl bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl grid grid-cols-1 md:grid-cols-2 overflow-hidden">

        <!-- WELCOME -->
        <div class="hidden md:flex flex-col justify-center p-12 text-white">
            <h1 class="text-4xl font-bold mb-4">
                OpenHands
            </h1>
            <p class="text-lg opacity-90">
                Open your hands,<br>
                share hope,<br>
                change lives.
            </p>

            <div class="mt-10 space-y-2 text-sm opacity-80">
                <p>🤝 Community Donation</p>
                <p>💜 Transparent & Simple</p>
                <p>🌍 Built for Demo & Impact</p>
            </div>
        </div>

        <!-- LOGIN -->
        <div class="bg-white p-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Welcome Back 👋
            </h2>

            <form method="POST" action="/login" class="space-y-5">
                @csrf

                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input
                        type="email"
                        name="email"
                        required
                        class="w-full mt-1 px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label class="text-sm text-gray-600">Password</label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full mt-1 px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500 focus:outline-none"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-linear-to-r from-blue-500 to-purple-600 text-white font-semibold hover:opacity-90 transition"
                >
                    Login
                </button>
            </form>

            <p class="text-sm text-gray-500 mt-6 text-center">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:underline">
                    Register
                </a>
            </p>
        </div>

    </div>

</body>
</html>
