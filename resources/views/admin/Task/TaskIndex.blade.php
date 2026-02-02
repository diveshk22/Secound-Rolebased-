@extends('layout.app')
@section('content')
<style>
    body{
        margin:0;
        font-family:'Inter', sans-serif;
        background:linear-gradient(135deg,#0f172a,#1e293b);
        color:#e5e7eb;
    }

    .view-card{
        max-width:1100px;
        margin:60px auto;
        padding:45px;
        border-radius:22px;
        background:rgba(255,255,255,0.05);
        backdrop-filter:blur(25px);
        border:1px solid rgba(255,255,255,0.08);
        box-shadow:0 20px 60px rgba(0,0,0,0.45);
    }

    .view-card h2{
        font-size:30px;
        margin-bottom:35px;
        font-weight:700;
        text-align:center;
        color:#f8fafc;
    }

    .task-item{
        margin-bottom:28px;
        padding:28px;
        border-radius:18px;
        background:rgba(17,24,39,0.9);
        border:1px solid rgba(255,255,255,0.06);
        transition:0.3s ease;
    }

    .task-item:hover{
        transform:translateY(-5px);
        border:1px solid #38bdf8;
        box-shadow:0 15px 40px rgba(0,0,0,0.4);
    }

    .row{
        display:flex;
        flex-wrap:wrap;
        gap:20px;
    }

    .col{
        flex:1 1 45%;
        min-width:260px;
    }

    .label{
        font-weight:600;
        color:#93c5fd;
        margin-bottom:6px;
        display:block;
        font-size:14px;
    }

    .value{
        font-size:15px;
        color:#e2e8f0;
        word-wrap:break-word;
    }

    .description-box{
        margin-top:15px;
        padding:18px;
        border-radius:12px;
        background:rgba(255,255,255,0.04);
        border:1px solid rgba(255,255,255,0.06);
        max-height:160px;
        overflow:auto;
    }

    .badge{
        padding:6px 12px;
        border-radius:20px;
        font-size:12px;
        font-weight:700;
        text-transform:capitalize;
        display:inline-block;
    }

    .pending{ background:#f59e0b; color:#111; }
    .progress{ background:#3b82f6; }
    .completed{ background:#22c55e; color:#111; }
    .rejected{ background:#ef4444; }

    .edit-btn, .delete-btn {
        padding:8px 16px;
        color:white;
        text-decoration:none;
        border-radius:8px;
        font-size:14px;
        border:none;
        cursor:pointer;
        transition:0.3s ease;
    }

    .edit-btn {
        background:#3b82f6;
    }

    .edit-btn:hover {
        background:#2563eb;
    }

    .delete-btn {
        background:#ef4444;
    }

    .delete-btn:hover {
        background:#dc2626;
    }



    @media(max-width:768px){
        .view-card{ padding:25px; margin:20px; }
        .row{ flex-direction:column; }
    }
</style>


<div class="view-card">
    <h2>📋 All Tasks</h2>

    @forelse($tasks as $task)
        <div class="task-item">

            <div class="row">
                <div class="col">
                    <span class="label">Task Name</span>
                    <div class="value">{{ $task->title }}</div>
                </div>

                <div class="col">
                    <span class="label">Due Date</span>
                    <div class="value">
                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'No due date' }}
                    </div>
                </div>

                <div class="col">
                    <span class="label">Assigned To</span>
                    <div class="value">
                        {{ $task->assignedUser->name ?? 'Not Assigned' }}
                    </div>
                </div>

                <div class="col">
                    <span class="label">Created By</span>
                    <div class="value">
                        {{ $task->createdBy->name ?? 'Admin' }}
                    </div>
                </div>
            </div>

            <div class="description-box">
                <span class="label">Description</span>
                <div class="value">{!! $task->description !!}</div>
            </div>

            <div style="margin-top:15px;">
                <span class="label">Status</span>
                @php
                    $class = match(strtolower($task->status)){
                        'pending' => 'pending',
                        'in progress' => 'progress',
                        'completed' => 'completed',
                        'rejected' => 'rejected',
                        default => 'pending'
                    };
                @endphp
                <span class="badge {{ $class }}">{{ $task->status }}</span>
            </div>
            <!-- edit task  -->
        <div style="margin-top:18px; text-align:right; display:flex; gap:10px; justify-content:flex-end;">
            <a href="{{ route('admin.task.edit', $task->id) }}" class="edit-btn">Edit Task</a>
            <form action="{{ route('admin.task.delete', $task->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
            </form>
        </div>
        </div>

    @empty
        <p style="text-align:center;">No tasks found.</p>
    @endforelse
</div>

@endsection
