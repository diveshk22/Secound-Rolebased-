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
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at center, rgba(255, 255, 255, 0.2), transparent 70%);
        transform: rotate(25deg);
        transition: all 0.6s ease;
    }
    .dashboard-card:hover::before {
        top: -70%;
        left: -70%;
    }
</style>
<div class="animated-bg"></div>
    <div class="min-h-screen bg-slate-900 py-10 px-6">
        {{-- Welcome Header --}}
        <div class="max-w-7xl mx-auto mb-10">
            <div class="welcome-card rounded-2xl p-8 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-white">
                        Welcome, {{ auth()->user()->name }} 👋
                    </h2>

                    <p class="mt-3 text-lg text-white">
                        Role:
                        <span class="role-badge px-4 py-1 rounded-full text-sm">
                            {{ auth()->user()->getRoleNames()->first() }}
                        </span>
                    </p>
                </div>

                <a href="{{ route('profile.edit') }}" class="hover:scale-105 transition">
                    <img src="{{ auth()->user()->photo ? asset('profile_photos/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=4f46e5&color=fff&size=50' }}" 
                        alt="Profile" 
                        class="rounded-full border-2 border-white/20 hover:border-white/40 transition object-cover"
                        style="width: 68px; height: 68px;">
                </a>
            </div>
        </div>
        {{-- Dashboard Title --}}
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="dashboard-title">
                Admin Dashboard
            </h1>
        </div>
        {{-- Statistics Cards --}}
        <div class="max-w-7xl mx-auto mt-10 grid grid-cols-
1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="dashboard-card card-blue">
                <h3 class="text-xl font-semibold">Total Users</h3>
                <div class="stat-number">
                    {{ \App\Models\User::count() }}
                </div>
            </div>

            <div class="dashboard-card card-green">
                <h3 class="text-xl font-semibold">Total Tasks</h3>
                <div class="stat-number">
                    {{ \App\Models\Task::count() }}
                </div>
            </div>
        </div>
    </div>
@endsection