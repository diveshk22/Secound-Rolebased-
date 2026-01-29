@extends('layout.app')

@section('content')

<style>
    body {
        margin: 0;
        padding: 0;
        background: #0f172a;
        font-family: 'Segoe UI', sans-serif;
        overflow-x: hidden;
    }

    /* Animated Gradient Background */
    .animated-bg {
        position: fixed;
        inset: 0;
        z-index: -1;
        background: radial-gradient(circle at 20% 20%, #2563eb55, transparent 40%),
                    radial-gradient(circle at 80% 30%, #7c3aed55, transparent 40%),
                    radial-gradient(circle at 50% 80%, #0ea5e955, transparent 40%),
                    #0f172a;
        animation: moveBg 18s ease-in-out infinite alternate;
    }

    @keyframes moveBg {
        0% { background-position: 0% 0%, 100% 0%, 50% 100%; }
        100% { background-position: 20% 30%, 80% 10%, 60% 80%; }
    }

    /* Welcome Card */
    .welcome-card {
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(18px);
        border: 1px solid rgba(255,255,255,0.12);
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }

    .role-badge {
        background: linear-gradient(45deg,#2563eb,#4f46e5);
        color: #fff;
        font-weight: 600;
        letter-spacing: .5px;
    }

    /* Dashboard Cards */
    .dashboard-card {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        padding: 40px;
        color: white;
        backdrop-filter: blur(20px);
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: all 0.4s ease;
    }

    .dashboard-card::before {
        content: '';
        position: absolute;
        width: 300%;
        height: 300%;
        top: -100%;
        left: -100%;
        background: linear-gradient(60deg, transparent, #ffffff22, transparent);
        transform: rotate(25deg);
        transition: 0.8s;
    }

    .dashboard-card:hover::before {
        top: 100%;
        left: 100%;
    }

    .dashboard-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 70px rgba(0,0,0,0.6);
    }

    .stat-number {
        font-size: 64px;
        font-weight: 800;
        margin-top: 20px;
        text-shadow: 0 8px 20px rgba(0,0,0,0.6);
    }

    .card-blue { border-left: 6px solid #3b82f6; }
    .card-green { border-left: 6px solid #22c55e; }

    .dashboard-title {
        font-size: 42px;
        font-weight: 800;
        color: white;
        letter-spacing: 1px;
        margin-bottom: 50px;
    }
</style>

<div class="animated-bg"></div>

<!-- Welcome Section -->
<div class="welcome-card p-2 rounded-2xl mb-10 flex justify-between items-center text-white">
    <div>
        <h2 class="text-3xl font-bold">
            Welcome, {{ auth()->user()->name }} 👋
        </h2>

        <p class="mt-3 text-lg">
            Role:
            <span class="px-4 py-1 rounded-full text-sm role-badge">
                {{ auth()->user()->getRoleNames()->first() }}
            </span>
        </p>
    </div>
</div>

<!-- Dashboard Content -->
<div class="px-6 pb-2">

    <h1 class="dashboard-title">
        🚀 Admin Dashboard Overview
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

        {{-- Total Users --}}
        <div class="dashboard-card card-blue">
            <h2 class="text-l uppercase tracking-wider text-gray-100">
                Total Users
            </h2>
            <p class="stat-number text-blue-400">
                {{ $totalUsers }}
            </p>
        </div>

        {{-- Today Users --}}
        <div class="dashboard-card card-green">
            <h2 class="text-l uppercase tracking-wider text-gray-300">
                Users Created Today
            </h2>
            <p class="stat-number text-green-400">
                {{ $todayUsers }}
            </p>
        </div>
        <div style="display:flex;gap:20px;margin:30px;">

    <div style="flex:1;background:#1e293b;padding:25px;border-radius:10px;color:white;text-align:center;">
        <h3>Total Tasks</h3>
        <h1>{{ $totalTasks }}</h1>
    </div>

    <div style="flex:1;background:#0ea5e9;padding:25px;border-radius:10px;color:white;text-align:center;">
        <h3>Today's Tasks</h3>
        <h1>{{ $todayTasks }}</h1>
    </div>

    <div style="flex:1;background:#22c55e;padding:25px;border-radius:10px;color:white;text-align:center;">
        <h3>Pending Tasks</h3>
        <h1>{{ $pendingTasks }}</h1>
    </div>
</div>

    </div>

</div>

@endsection
