@extends('layout.app')
@section('content')

<style>
*{
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}

body{
    background:linear-gradient(120deg,#0f172a,#020617);
    margin:0;
}

.tasks-wrapper{
    padding:50px 20px;
    display:flex;
    justify-content:center;
}

.tasks-card{
    width:100%;
    max-width:1200px;
    background:rgba(15,23,42,0.92);
    border-radius:18px;
    padding:40px;
    border:1px solid rgba(255,255,255,0.08);
    box-shadow:0 40px 90px rgba(0,0,0,.7);
    backdrop-filter:blur(16px);
    color:#e2e8f0;
}

.tasks-title{
    text-align:center;
    font-size:30px;
    font-weight:700;
    margin-bottom:35px;
    color:#fff;
    letter-spacing:.6px;
}

/* Table */
.table-wrap{
    overflow-x:auto;
}

.tasks-table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 12px;
    font-size:14px;
}

.tasks-table thead th{
    color:#94a3b8;
    font-weight:600;
    padding:12px;
    text-align:left;
}

.tasks-table tbody tr{
    background:#0b1220;
    transition:.25s;
}

.tasks-table tbody tr:hover{
    transform:scale(1.01);
    background:#0f172a;
}

.tasks-table td{
    padding:18px 14px;
    vertical-align:top;
    border-top:1px solid #1f2937;
    border-bottom:1px solid #1f2937;
}

.tasks-table td:first-child{
    border-left:1px solid #1f2937;
    border-radius:10px 0 0 10px;
}

.tasks-table td:last-child{
    border-right:1px solid #1f2937;
    border-radius:0 10px 10px 0;
}

/* Badges */
.status-badge{
    padding:6px 12px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
    display:inline-block;
}

.status-pending{
    background:#3f3f1a;
    color:#fde68a;
}

.status-completed{
    background:#064e3b;
    color:#6ee7b7;
}

/* Comment Section */
.comment-section{
    background:#0a0f1a;
    padding:14px;
    border-radius:10px;
    border:1px solid #1f2937;
    max-height:260px;
    overflow:auto;
}

.comment-box{
    background:#111827;
    padding:10px 12px;
    border-radius:8px;
    margin-bottom:10px;
    font-size:13px;
}

.comment-head{
    font-weight:600;
    color:#93c5fd;
    margin-bottom:4px;
    font-size:12px;
}

.comment-form textarea{
    width:100%;
    background:#0f172a;
    border:1px solid #334155;
    border-radius:6px;
    padding:8px;
    color:#fff;
    font-size:13px;
    margin-top:8px;
    resize:none;
}

.comment-form textarea:focus{
    outline:none;
    border-color:#3b82f6;
}

.comment-form button{
    margin-top:8px;
    padding:6px 12px;
    font-size:12px;
    background:#2563eb;
    border:none;
    border-radius:6px;
    color:white;
    cursor:pointer;
}

.comment-form button:hover{
    background:#1d4ed8;
}

.no-tasks{
    text-align:center;
    padding:60px;
    color:#94a3b8;
    font-style:italic;
}

/* Responsive */
@media(max-width:768px){
    .tasks-table td{
        font-size:12px;
    }
}
</style>

<div class="tasks-wrapper">
    <div class="tasks-card">
        <div class="tasks-title">View Assigned Tasks</div>
        @if($assignedTasks->count() > 0)
        <div class="table-wrap">
            <table class="tasks-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Task</th>
                        <th>Description</th>
                        <th>Assigned To</th>
                        <th>Due</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th style="min-width:300px;">Comments</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignedTasks as $task)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $task->title }}</strong></td>
                        <td>{{ \Illuminate\Support\Str::limit($task->description, 50) }}</td>
                        <td>{{ $task->assignedUser->name ?? 'N/A' }}</td>
                        <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'N/A' }}</td>
                        <td>
                            <span class="status-badge {{ ($task->status ?? 'pending') == 'completed' ? 'status-completed' : 'status-pending' }}">
                                {{ ucfirst($task->status ?? 'pending') }}
                            </span>
                        </td>
                        <td>{{ $task->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="comment-section">
                                @forelse($task->comments as $comment)
                                    <div class="comment-box">
                                        <div class="comment-head">
                                            {{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}
                                        </div>
                                        {{ $comment->comment }}
                                    </div>
                                @empty
                                    <div style="font-size:12px;color:#64748b;">No comments yet.</div>
                                @endforelse

                                <form action="{{ route('managers.task.comment') }}" method="POST" class="comment-form">
                                    @csrf
                                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                                    <textarea name="comment" rows="2" required placeholder="Write a comment..."></textarea>
                                    <button type="submit">Add</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="no-tasks">No tasks have been assigned yet.</div>
        @endif
    </div>
</div>

@endsection
