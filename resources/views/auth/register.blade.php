<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>OpenHands — Register</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Vite (Tailwind) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            Create Account ✨
        </h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="text-sm text-gray-600">Name</label>
                <input
                    type="text"
                    name="name"
                    required
                    class="w-full mt-1 px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500 focus:outline-none"
                >
            </div>

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

            <div>
                <label class="text-sm text-gray-600">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full mt-1 px-4 py-3 rounded-xl border focus:ring-2 focus:ring-purple-500 focus:outline-none"
                >
            </div>

            <button
                type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold hover:opacity-90 transition"
            >
                Register
            </button>
        </form>

        <p class="text-sm text-gray-500 mt-6 text-center">
            Already have an account?
            <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:underline">
                Login
            </a>
        </p>
    </div>

</body>
</html>
