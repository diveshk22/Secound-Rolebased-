@extends('layout.app')

@section('content')

<style>
    body{
        background: linear-gradient(135deg,#0f172a,#1e293b);
        font-family: 'Segoe UI', sans-serif;
    }

    .users-wrapper {
        max-width: 1000px;
        margin: 60px auto;
        background: #ffffff;
        padding: 30px 35px;
        border-radius: 12px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn{
        from{opacity:0; transform:translateY(15px);}
        to{opacity:1; transform:translateY(0);}
    }

    .users-title {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #1e293b;
        text-align: center;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table thead {
        background-color: #f1f5f9;
    }

    .users-table th,
    .users-table td {
        padding: 14px 16px;
        text-align: left;
    }

    .users-table th {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
    }

    .users-table td {
        border-bottom: 1px solid #e2e8f0;
        color: #0f172a;
        font-size: 14px;
    }

    .users-table tr:hover {
        background-color: #f8fafc;
        transition: 0.2s ease-in-out;
    }

    .no-users {
        text-align: center;
        padding: 20px;
        color: #64748b;
        font-weight: 500;
    }

    .badge-date{
        background:#e2e8f0;
        padding:6px 10px;
        border-radius:20px;
        font-size:12px;
        color:#334155;
        font-weight:600;
    }
</style>

<div class="users-wrapper">
    <div class="users-title">All Users List</div>

    <table class="users-table">
        <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge-date">
                            {{ $user->created_at->format('d M Y, h:i A') }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="no-users">No users found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
