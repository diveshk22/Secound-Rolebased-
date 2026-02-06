@extends('layout.app')

@section('content')

<style>
    body{
        margin:0;
        font-family: 'Inter', sans-serif;
        background: #0f172a;
        color: #e5e7eb;
    }

    .dashboard-wrapper{
        padding: 50px 25px;
    }

    .title{
        font-weight: 700;
        letter-spacing: 1px;
        color: #f1f5f9;
    }

    /* Glass Card */
    .glass-card{
        border-radius: 22px;
        padding: 35px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(12px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.6);
        transition: 0.4s ease;
    }

    .glass-card:hover{
        transform: translateY(-6px);
        box-shadow: 0 25px 70px rgba(0,0,0,0.7);
    }

    /* Feature Cards */
    .feature-card{
        border-radius: 18px;
        padding: 28px;
        background: #1e293b;
        border: 1px solid rgba(255,255,255,0.06);
        transition: 0.3s ease;
        height: 100%;
    }

    .feature-card:hover{
        transform: scale(1.03);
        background: #243447;
    }

    .feature-card h5{
        font-weight: 600;
        margin-bottom: 10px;
        color: #f8fafc;
    }

    .feature-card p{
        font-size: 14px;
        opacity: 0.8;
        margin-bottom: 15px;
    }

    /* Buttons */
    .btn-custom{
        background: #38bdf8;
        color: #0f172a;
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 20px;
        border: none;
        transition: 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-custom:hover{
        background: #0ea5e9;
        color: white;
    }

    /* Header Section */
    .header-box{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .badge-role{
        background: #334155;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 13px;
        opacity: 0.9;
    }
</style>

<div class="container dashboard-wrapper">

    <div class="header-box">
        <h3 class="title">Super Admin Dashboard</h3>
        <div class="badge-role">Full System Control Panel</div>
    </div>

    <div class="glass-card mb-4">
        <h4>Welcome, Super Admin 👋</h4>
        <p>
            From here you can manage users, roles, permissions and monitor all system activities.
        </p>

        <div class="row mt-4">
            <div class="col-md-6 mb-3">
                <div class="feature-card">
                    <h5>👥 Manage Users</h5>
                    <p>View all users, assign roles and control access permissions.</p>
                    <a href="{{ route('super.users') }}" class="btn-custom">
                        Go to Users
                    </a>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="feature-card">
                    <h5>🛡 Manage Roles & Permissions</h5>
                    <p>Create roles and manage permissions using Spatie role system.</p>
                    <a href="#" class="btn-custom">
                        Manage Roles
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
