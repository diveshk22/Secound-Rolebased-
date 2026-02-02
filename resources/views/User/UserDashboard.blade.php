@extends('layout.app')

@section('content')

<style>
    body{
        margin:0;
        font-family: 'Inter', sans-serif;
        background: linear-gradient(-45deg, #0f172a, #1e293b, #0ea5e9, #1e3a8a);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
    }

    @keyframes gradientBG{
        0%{background-position:0% 50%;}
        50%{background-position:100% 50%;}
        100%{background-position:0% 50%;}
    }

    .glass{
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,0.08);
        box-shadow: 0 10px 40px rgba(0,0,0,0.4);
    }

    .fade-in{
        opacity:0;
        transform: translateY(30px);
        transition: all 0.8s ease;
    }

    .fade-in.show{
        opacity:1;
        transform: translateY(0);
    }

    .stat-card{
        transition: 0.4s ease;
    }

    .stat-card:hover{
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 18px 40px rgba(0,0,0,0.6);
    }

    .clock{
        font-size:14px;
        opacity:0.7;
    }
</style>

<div class="min-h-screen py-10 px-6 text-white">

    {{-- Header --}}
    <div class="max-w-7xl mx-auto mb-10 fade-in" id="headerCard">
        <div class="glass rounded-2xl p-8 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold">
                    Welcome, {{ auth()->user()->name }} 👋
                </h2>

                <div class="clock mt-2" id="liveClock"></div>

                <p class="mt-3 text-lg">
                    Role:
                    <span class="px-4 py-1 rounded-full text-sm bg-gradient-to-r from-blue-600 to-indigo-600">
                        {{ auth()->user()->getRoleNames()->first() }}
                    </span>
                </p>
            </div>

            <a href="{{ route('profile.edit') }}">
                <img src="{{ auth()->user()->photo ? asset('profile_photos/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=4f46e5&color=fff&size=50' }}"
                    class="rounded-full border-2 border-white/20 hover:border-white/40 transition object-cover"
                    style="width:70px;height:70px;">
            </a>
        </div>
    </div>

    {{-- Intro --}}
    <div class="max-w-5xl mx-auto mb-12 fade-in" id="introCard">
        <div class="glass rounded-3xl p-12 text-center">
            <h1 class="text-5xl font-extrabold mb-4">Dashboard</h1>
            <p class="text-gray-300 text-lg">
                Everything you need is right here. Fast, clean and beautiful interface.
            </p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="max-w-5xl mx-auto mb-12 fade-in" id="statsCard">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="stat-card glass rounded-2xl p-8 text-center">
                <h3 class="text-lg mb-2">Total Tasks</h3>
                <p class="text-4xl font-bold text-blue-400">{{ $totalTasksCount }}</p>
            </div>

            <div class="stat-card glass rounded-2xl p-8 text-center">
                <h3 class="text-lg mb-2">Pending Tasks</h3>
                <p class="text-4xl font-bold text-orange-400">{{ $pendingTasksCount }}</p>
            </div>

            <div class="stat-card glass rounded-2xl p-8 text-center">
                <h3 class="text-lg mb-2">Rejected Tasks</h3>
                <p class="text-4xl font-bold text-red-400">{{ $rejectedTasksCount }}</p>
            </div>

        </div>
    </div>

</div>

<script>
    // Fade in animation
    window.addEventListener('load', ()=>{
        document.querySelectorAll('.fade-in').forEach((el, i)=>{
            setTimeout(()=> el.classList.add('show'), i * 200);
        });
    });

    // Live clock
    function updateClock(){
        const now = new Date();
        document.getElementById('liveClock').innerText = now.toLocaleString();
    }
    setInterval(updateClock,1000);
    updateClock();
</script>

@endsection
