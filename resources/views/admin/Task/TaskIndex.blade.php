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
    }

    .task-item{
        margin-bottom:30px;
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
        margin-top:6px;
    }

    .pending{ background:#f59e0b; color:#111; }
    .progress{ background:#3b82f6; }
    .completed{ background:#22c55e; color:#111; }
    .rejected{ background:#ef4444; }

    /* Comments */
    .comment-section{
        margin-top:25px;
        padding:18px;
        background:rgba(255,255,255,0.04);
        border-radius:12px;
    }

    .comment-box{
        background:#1e293b;
        padding:10px 14px;
        border-radius:8px;
        margin-bottom:8px;
    }

    .comment-head{
        font-size:12px;
        color:#94a3b8;
        margin-bottom:4px;
    }

    .comment-form textarea{
        width:100%;
        padding:10px;
        border-radius:8px;
        background:#0f172a;
        border:1px solid #334155;
        color:white;
        resize:none;
        height:70px;
        margin-top:8px;
    }

    .comment-form button{
        margin-top:8px;
        background:#3b82f6;
        padding:6px 14px;
        border:none;
        border-radius:6px;
        color:white;
        cursor:pointer;
    }

    /* Actions */
    .action-bar{
        margin-top:18px;
        text-align:right;
        display:flex;
        gap:10px;
        justify-content:flex-end;
    }

    .edit-btn, .delete-btn{
        padding:8px 16px;
        color:white;
        text-decoration:none;
        border-radius:8px;
        font-size:14px;
        border:none;
        cursor:pointer;
    }

    .edit-btn{ background:#3b82f6; }
    .delete-btn{ background:#ef4444; }

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

        @php
            $class = match(strtolower($task->status)){
                'pending' => 'pending',
                'in progress' => 'progress',
                'completed' => 'completed',
                'rejected' => 'rejected',
                default => 'pending'
            };
        @endphp

        <div style="margin-top:15px;">
            <span class="label">Status</span>
            <span class="badge {{ $class }}">{{ $task->status }}</span>
        </div>

        {{-- Comments --}}
        <div class="comment-section">
            <div class="label">Comments</div>

            @forelse($task->comments as $comment)
                <div class="comment-box">
                    <div class="comment-head">
                        {{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}
                    </div>
                    <div>{{ $comment->comment }}</div>
                </div>
            @empty
                <div style="font-size:13px;color:#64748b;">No comments yet.</div>
            @endforelse

            <form action="{{ route('task.comment') }}" method="POST" class="comment-form">
                @csrf
                <input type="hidden" name="task_id" value="{{ $task->id }}">
                <textarea name="comment" required placeholder="Write a comment..."></textarea>
                <button type="submit">Add Comment</button>
            </form>
        </div>

        <div class="action-bar">
            <a href="{{ route('admin.task.edit', $task->id) }}" class="edit-btn">Edit Task</a>

            <form action="{{ route('admin.task.delete', $task->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn"
                    onclick="return confirm('Are you sure you want to delete this task?')">
                    Delete
                </button>
            </form>
        </div>

    </div>
    @empty
        <p style="text-align:center;">No tasks found.</p>
    @endforelse

</div>

@endsection
