<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        body {
            min-height: 100vh;
            background: radial-gradient(circle at top left, #1e3a8a, transparent 40%),
                        radial-gradient(circle at bottom right, #0ea5e9, transparent 40%),
                        #0f172a;
        }

        .auth-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255,255,255,0.15);
        }
    </style>
</head>

<body class="flex items-center justify-center text-white">

    <div class="auth-card p-10 rounded-2xl shadow-2xl w-full max-w-md">

        <h2 class="text-3xl font-extrabold mb-8 text-center tracking-wide">
            Forgot Password
        </h2>

        @if (session('status'))
            <div class="bg-green-500/20 text-green-300 border border-green-400/30 p-3 rounded mb-6">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block mb-2 font-semibold text-gray-200">Email</label>
                <input type="email" name="email" required
                       class="w-full p-3 rounded-lg bg-gray-900 border border-gray-600
                              text-white placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Enter your email">
            </div>

            <button type="submit"
                class="w-full py-3 rounded-lg font-bold text-lg text-white
                       bg-gradient-to-r from-blue-500 to-indigo-600
                       hover:from-blue-600 hover:to-indigo-700
                       transition duration-300 shadow-lg">
                Send Password Reset Link
            </button>
            <a href="{{route ('login')}}" class="block text-center mt-4 text-blue-400 hover:text-blue-300">Log in here</a>
        </form>

    </div>

</body>
</html>
