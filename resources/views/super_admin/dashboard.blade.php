@extends('layout.app')

@section('content')

<style>
    body {
        background: #0f172a;
        font-family: 'Segoe UI', sans-serif;
    }

    .dashboard-container {
        max-width: 1100px;
        margin: 50px auto;
        padding: 20px;
    }

    .dashboard-title {
        color: #fff;
        font-size: 32px;
        font-weight: 600;
        margin-bottom: 30px;
        text-align: center;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
    }

    .dashboard-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(20px);
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
        text-align: center;
    }

    .dashboard-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.5);
    }

    .card-title {
        font-size: 14px;
        letter-spacing: 1px;
        color: #cbd5e1;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .stat-number {
        font-size: 40px;
        font-weight: bold;
        color: #22c55e;
    }

    .card-green {
        border-left: 5px solid #22c55e;
    }
</style>

<div class="dashboard-container">

    <h1 class="dashboard-title">Super Admin Dashboard</h1>

    <div class="dashboard-grid">
        <!-------- total users show ------------>
        {{-- Total Users --}}
        <div class="dashboard-card card-green">
            <h2 class="card-title">
                Total Users
            </h2>
            <p class="stat-number">
                {{ \App\Models\User::count() }}


        <!-- today created users  -->
        {{-- Users Created Today --}}
        <div class="dashboard-card card-green">
            <h2 class="card-title">
                Users Created Today
            </h2>
            <p class="stat-number">
                {{ $todayUsers }}
            </p>
        </div>

    </div>

</div>

@endsection