@extends('layout.app')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #0f172a, #1e293b, #0f172a);
        min-height: 100vh;
    }

    .dashboard-card {
        backdrop-filter: blur(12px);
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: all 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }

    .stat-number {
        text-shadow: 0 4px 10px rgba(0,0,0,0.4);
    }
</style>

<div class="py-12 px-6">

    <h1 class="text-4xl font-extrabold text-white mb-12 tracking-wide">
        🚀 Admin Dashboard
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- Total Users --}}
        <div class="dashboard-card p-8 rounded-2xl shadow-xl">
            <h2 class="text-lg uppercase tracking-wider text-gray-300">
                Total Users
            </h2>

            <p class="stat-number text-5xl font-extrabold mt-4 text-blue-400">
                {{ $totalUsers }}
            </p>
        </div>

        {{-- Today Users --}}
        <div class="dashboard-card p-8 rounded-2xl shadow-xl">
            <h2 class="text-lg uppercase tracking-wider text-gray-300">
                Users Created Today
            </h2>

            <p class="stat-number text-5xl font-extrabold mt-4 text-green-400">
                {{ $todayUsers }}
            </p>
        </div>

    </div>

</div>

@endsection
