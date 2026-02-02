@extends('layout.app')

@section('content')

<style>
    body{
        background: linear-gradient(135deg, #0f172a, #1e293b);
        font-family: 'Inter', sans-serif;
        color: #e5e7eb;
    }

    .page-title-box h4{
        font-weight: 600;
    }

    .main-card{
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(12px);
        border-radius: 18px;
        border: none;
        box-shadow: 0 12px 30px rgba(0,0,0,0.5);
        padding: 25px;
    }

    table{
        color: #e5e7eb;
    }

    thead{
        background: #1e293b;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
    }

    th, td{
        vertical-align: middle !important;
        text-align: center;
    }

    tbody tr{
        transition: 0.3s;
    }

    tbody tr:hover{
        background: rgba(255,255,255,0.06);
    }

    .form-select{
        background-color: #0f172a;
        color: white;
        border: 1px solid #334155;
        border-radius: 8px;
    }

    .form-select:focus{
        box-shadow: none;
        border-color: #2563eb;
    }

    .btn-update{
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        border: none;
        border-radius: 8px;
        font-size: 13px;
        padding: 6px 14px;
        margin-top: 8px;
        transition: 0.3s;
    }

    .btn-update:hover{
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(37,99,235,0.5);
    }

    .role-badge{
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .role-superadmin{ background: #dc2626; }
    .role-admin{ background: #059669; }
    .role-user{ background: #2563eb; }
    .role-none{ background: #6b7280; }
</style>

<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="page-title-box">
                <h4>👥 Manage Users</h4>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: rgba(34, 197, 94, 0.1); border: 1px solid #22c55e; color: #22c55e;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444;">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card main-card">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Current Role</th>
                        <th>Change Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    @php
                        $role = $user->roles->first()->name ?? 'none';
                    @endphp
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            {{ $user->name }}
                            @if($user->id === auth()->id())
                                <span class="badge bg-info ms-1">You</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="role-badge role-{{ $role }}">
                                {{ ucfirst($role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->id === auth()->id())
                                <span class="text-muted">Cannot change own role</span>
                            @else
                                <form action="{{ route('super.change.role', $user->id) }}" method="POST">
                                    @csrf
                                    <select name="role" class="form-select" required>
                                        <option value="">Select Role</option>
                                        <option value="superadmin" {{ ($role == 'superadmin') ? 'selected' : '' }}>Super Admin</option>
                                        <option value="admin" {{ ($role == 'admin') ? 'selected' : '' }}>Admin</option>
                                        <option value="user" {{ ($role == 'user') ? 'selected' : '' }}>User</option>
                                    </select>
                                    <button type="submit" class="btn btn-update text-white" onclick="return confirm('Are you sure you want to change this user\'s role?')">
                                        Update
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
