@extends('layout.app')

@section('content')

<style>
    body{
        margin:0;
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #0f172a, #1e293b);
        color:#e5e7eb;
    }

    .view-card{
        max-width:1000px;
        margin:60px auto;
        padding:45px;
        border-radius:22px;
        background:rgba(255,255,255,0.05);
        backdrop-filter:blur(25px);
        border:1px solid rgba(255,255,255,0.08);
        box-shadow:0 20px 60px rgba(0,0,0,0.45);
        animation:fadeIn 0.6s ease;
    }

    .view-card h2{
        font-size:28px;
        margin-bottom:30px;
        letter-spacing:1px;
        font-weight:600;
        color:#f8fafc;
    }

    .task-item{
        margin-bottom:25px;
        padding:25px;
        border-radius:16px;
        background:rgba(17,24,39,0.85);
        border:1px solid rgba(255,255,255,0.06);
        transition:all 0.3s ease;
    }

    .task-item:hover{
        transform:translateY(-6px);
        box-shadow:0 15px 40px rgba(0,0,0,0.4);
        border:1px solid #38bdf8;
    }

    .task-item p{
        margin:8px 0;
        font-size:15px;
        color:#d1d5db;
    }

    .task-item strong{
        color:#f1f5f9;
        font-weight:600;
    }

    .actions{
        margin-top:18px;
    }

    .btn{
        display:inline-block;
        padding:9px 16px;
        border-radius:8px;
        font-size:14px;
        text-decoration:none;
        color:white;
        margin-right:8px;
        transition:all 0.25s ease;
        border:none;
        cursor:pointer;
    }

    .btn-view{
        background:#0ea5e9;
    }

    .btn-view:hover{
        background:#0284c7;
        transform:scale(1.05);
    }

    .btn-edit{
        background:#6366f1;
    }

    .btn-edit:hover{
        background:#4f46e5;
        transform:scale(1.05);
    }

    .btn-delete{
        background:#ef4444;
    }

    .btn-delete:hover{
        background:#dc2626;
        transform:scale(1.05);
    }

    .badge{
        padding:5px 10px;
        border-radius:20px;
        font-size:12px;
        font-weight:600;
    }

    .badge-pending{
        background:#f59e0b;
        color:#111827;
    }

    .badge-completed{
        background:#22c55e;
        color:#111827;
    }

    .badge-late{
        background:#ef4444;
        color:white;
    }

    @keyframes fadeIn{
        from{ opacity:0; transform:translateY(15px); }
        to{ opacity:1; transform:translateY(0); }
    }

    @media(max-width:768px){
        .view-card{
            margin:20px;
            padding:25px;
        }
    }
</style>

<div class="view-card">
    <h2>📋 All Tasks</h2>

    @forelse($tasks as $task)
        <div class="task-item">
            <p><strong>Task Name:</strong> {{ $task->title }}</p>
            <p><strong>Created By:</strong> {{ $task->user->name }}</p>
            <p><strong>Assigned To:</strong> {{ $task->assignedUser->name ?? 'Not Assigned' }}</p>
            <p><strong>Due Date:</strong> {{ $task->due_date ?? 'No due date' }}</p>

            <p>
                <strong>Status:</strong>
                @php
                    $statusClass = match($task->status) {
                        'Done' => 'badge-completed',
                        'Reject' => 'badge-late',
                        'In Progress', 'QA', 'shared for UAT' => 'badge-pending',
                        default => 'badge-pending'
                    };
                @endphp
                <span class="badge {{ $statusClass }}">{{ $task->status ?? 'backlog' }}</span>
            </p>

            <div class="actions">
                <a href="{{ route('admin.task.show', $task->id) }}" class="btn btn-view">View</a>

                <a href="{{ route('admin.task.edit', $task->id) }}" class="btn btn-edit">Edit</a>

                <form method="POST" action="{{ route('admin.task.destroy', $task->id) }}" style="display:inline;" 
                      onsubmit="return confirm('Are you sure you want to delete this task?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p>No tasks found.</p>
    @endforelse
</div>

@endsection
@push('scripts')