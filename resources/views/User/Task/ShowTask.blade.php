@extends('layout.app')

@section('title', 'User Tasks')
@section('content')
<style>
    body{
        background: #0f172a;
        font-family: 'Segoe UI', sans-serif;
    }

    .task-wrapper{
        max-width: 1200px;
        margin: 60px auto;
        padding: 35px;
        border-radius: 22px;
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(30px);
        box-shadow: 0 25px 80px rgba(0,0,0,0.55);
        color: #fff;
    }

    .task-title{
        text-align:center;
        font-size:32px;
        font-weight:800;
        margin-bottom:30px;
        letter-spacing:1px;
    }

    /* Alerts */
    .alert{
        padding:12px;
        border-radius:10px;
        font-weight:600;
        margin-bottom:20px;
    }

    .alert-success{
        background:#16a34a;
    }

    .alert-danger{
        background:#dc2626;
    }

    /* Table */
    .task-table{
        width:100%;
        border-collapse:separate;
        border-spacing:0 12px;
    }

    .task-table thead th{
        background: linear-gradient(90deg,#0ea5e9,#6366f1);
        padding:14px;
        font-size:14px;
        border:none;
        text-align:center;
        color:white;
    }

    .task-table tbody tr{
        background: rgba(255,255,255,0.04);
        transition:0.3s;
    }

    .task-table tbody tr:hover{
        transform:scale(1.01);
        background: rgba(255,255,255,0.09);
    }

    .task-table td{
        padding:16px;
        text-align:center;
        vertical-align:middle;
        border-top:1px solid rgba(255,255,255,0.08);
        border-bottom:1px solid rgba(255,255,255,0.08);
    }

    /* Status Badges */
    .badge{
        padding:6px 12px;
        border-radius:20px;
        font-size:12px;
        font-weight:700;
        text-transform:capitalize;
    }

    .badge-pending{ background:#f59e0b; }
    .badge-progress{ background:#3b82f6; }
    .badge-completed{ background:#22c55e; }
    .badge-cancelled{ background:#ef4444; }

    /* Dropdown */
    .form-select{
        background: rgba(255,255,255,0.08);
        border:1px solid rgba(255,255,255,0.2);
        color:white;
        border-radius:8px;
        padding:6px 10px;
        font-size:13px;
        outline:none;
        cursor:pointer;
    }

    .form-select option{
        color:black;
    }

    /* Responsive */
    @media(max-width:768px){
        .task-wrapper{
            padding:20px;
        }
        .task-title{
            font-size:24px;
        }
        .task-table td, .task-table th{
            font-size:12px;
            padding:10px;
        }
    }
</style>

<div class="task-wrapper">

    <div class="task-title">Your Assigned Tasks</div>

    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif
    <table class="task-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Task Title</th>
                <th>Job Description</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Comments</th>
            </tr>
        </thead>

        <tbody>
            @forelse($tasks as $key => $task)
                <tr>
                    <td>{{ $key + 1 }}</td>

                    <td>{{ $task->title }}</td>

                    <td>
                    <a href="{{ route('task.view.description', $task->id) }}" 
                     style="background:#6366f1;padding:8px 14px;border-radius:8px;color:white;text-decoration:none;font-size:13px;">
                     View
                    </a>
                </td>

                    <td>
                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : '-' }}
                    </td>

                    <td>
                        <form action="{{ route('task.update.status', $task->id) }}" method="POST">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="form-select">
                                @foreach(\App\Models\Task::STATUSES as $status)
                                    <option value="{{ $status }}" {{ $task->status == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td style="min-width:280px; text-align:left;">
                        {{-- Existing Comments --}}
                        <div style="max-height:150px; overflow-y:auto; margin-bottom:10px;">
                            @foreach($task->comments as $comment)
                                <div style="background:rgba(255,255,255,0.06); padding:6px; border-radius:6px; margin-bottom:6px;">
                                    <div style="font-size:11px; color:#94a3b8;">
                                        {{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}
                                    </div>
                                    <div style="font-size:13px;">
                                        {{ $comment->comment }}
                                    </div>
                                </div>
                            @endforeach
                        </div>  

                        {{-- Add Comment Form --}}
                        <form action="{{ route('task.comment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="task_id" value="{{ $task->id }}">

                            <textarea name="comment" required
                                style="width:100%; padding:6px; border-radius:6px; background:#0f172a; color:white; font-size:12px;"
                                placeholder="Write comment..."></textarea>

                            <button type="submit"
                                style="margin-top:5px; background:#3b82f6; padding:5px 10px; border:none; border-radius:5px; color:white; font-size:12px;">
                                Add
                            </button>
                        </form>
                    </td>

            @empty
                <tr>
                    <td colspan="6">No tasks assigned yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
