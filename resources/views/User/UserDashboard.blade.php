@extends('layout.app')

@section('content')

<style>
    .bg-animated {
        position: relative;
        min-height: 100vh;
        background: radial-gradient(circle at 20% 20%, #1e3a8a, transparent 40%),
                    radial-gradient(circle at 80% 30%, #0ea5e9, transparent 40%),
                    radial-gradient(circle at 50% 80%, #6366f1, transparent 40%),
                    #0f172a;
        animation: bgMove 12s ease-in-out infinite alternate;
    }

    @keyframes bgMove {
        0% { background-position: 0% 0%, 100% 0%, 50% 100%; }
        100% { background-position: 20% 30%, 80% 10%, 60% 80%; }
    }

    .floating-card {
        background: rgba(15, 23, 42, 0.75);
        border: 1px solid rgba(255,255,255,0.1);
        backdrop-filter: blur(25px);
        box-shadow: 0 30px 80px rgba(0,0,0,0.6);
        transition: 0.4s ease;
    }

    .floating-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 40px 100px rgba(0,0,0,0.8);
    }

    .glow-btn {
        position: relative;
        background: #2563eb;
        transition: 0.3s;
    }

    .glow-btn:hover {
        box-shadow: 0 0 25px #3b82f6, 0 0 60px #3b82f6;
        transform: translateY(-3px);
    }
</style>

<div class="bg-animated flex items-center justify-center">

    <div class="floating-card w-full max-w-3xl p-14 rounded-3xl text-center text-white">

        <h1 class="text-5xl font-extrabold mb-6 tracking-wide">
            Welcome Back 👋
        </h1>

        <p class="text-gray-300 text-lg mb-12">
            Your personalized dashboard is ready. Manage everything smoothly from here.
        </p>

        <div class="flex justify-center gap-8 flex-wrap">
        </div>

    </div>

</div>

@endsection
