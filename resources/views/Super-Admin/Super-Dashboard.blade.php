@extends('layout.app')

@section('content')

<style>
    body{
        margin:0;
        font-family: 'Inter', sans-serif;
        background: linear-gradient(-45deg, #0f172a, #1e293b, #0ea5e9, #1e3a8a);
        background-size: 400% 400%;
        animation: gradientMove 12s ease infinite;
        color: #e5e7eb;
    }

    @keyframes gradientMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .dashboard-wrapper{
        padding: 40px 20px;
    }

    .glass-card{
        border-radius: 20px;
        padding: 30px;
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(14px);
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
        transition: all 0.4s ease;
        opacity: 0;
        transform: translateY(30px);
    }

    .glass-card.show{
        opacity: 1;
        transform: translateY(0);
    }

    .glass-card:hover{
        transform: translateY(-8px);
        box-shadow: 0 18px 45px rgba(0,0,0,0.6);
    }

    .feature-card{
        border-radius: 16px;
        padding: 25px;
        color: white;
        transition: 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .feature-card:hover{
        transform: scale(1.04);
    }

    .feature-users{
        background: linear-gradient(135deg, #2563eb, #1e40af);
    }

    .feature-roles{
        background: linear-gradient(135deg, #059669, #065f46);
    }

    .btn-custom{
        background: #ffffff;
        color: #1e40af;
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 18px;
        transition: 0.3s;
    }

    .btn-custom:hover{
        background: #e2e8f0;
        color: #0f172a;
    }

    .title{
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .clock{
        font-size: 14px;
        opacity: 0.8;
    }
</style>

<div class="container dashboard-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="title">🚀 Super Admin Dashboard</h3>
            <div class="clock" id="liveClock"></div>
        </div>
    </div>

    <div class="glass-card mb-4" id="welcomeCard">
        <h4>Welcome, Super Admin 👋</h4>
        <p>
            Manage users, roles, permissions and monitor the entire application from here.
        </p>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="feature-card feature-users">
                    <h5>👥 Manage Users</h5>
                    <p>View users, assign roles and control permissions.</p>
                    <a href="{{ route('super.users') }}" class="btn btn-custom mt-2">
                        Go to Users
                    </a>
                </div>
            </div>

            <div class="col-md-6 mt-3 mt-md-0">
                <div class="feature-card feature-roles">
                    <h5>🛡 Manage Roles</h5>
                    <p>Create and manage roles & permissions using Spatie.</p>
                    <a href="#" class="btn btn-custom mt-2">
                        Manage Roles
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // Fade-in animation
    window.addEventListener('load', () => {
        document.getElementById('welcomeCard').classList.add('show');
    });

    // Live clock
    function updateClock(){
        const now = new Date();
        document.getElementById('liveClock').innerText =
            now.toLocaleString();
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

@endsection
