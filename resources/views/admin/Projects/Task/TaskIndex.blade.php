@extends('layout.app')
@section('content')

<style>
body{
    margin:0;
    font-family:'Inter', sans-serif;
    background:linear-gradient(135deg,#0f172a,#1e293b);
    color:#e5e7eb;
}

.task-container{
    max-width:1200px;
    margin:50px auto;
    padding:40px;
    border-radius:20px;
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(20px);
    border:1px solid rgba(255,255,255,0.08);
    box-shadow:0 20px 60px rgba(0,0,0,0.5);
}

.task-title{
    text-align:center;
    font-size:28px;
    font-weight:700;
    margin-bottom:30px;
}

.task-table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
    border-radius:12px;
}

.task-table thead{
    background:#1e293b;
}

.task-table th{
    padding:14px;
    text-align:left;
    font-size:14px;
    font-weight:600;
    color:#93c5fd;
    border-bottom:1px solid rgba(255,255,255,0.1);
}

.task-table td{
    padding:14px;
    font-size:14px;
    border-bottom:1px solid rgba(255,255,255,0.05);
}

.task-table tbody tr:hover{
    background:rgba(255,255,255,0.04);
    transition:0.3s;
}

/* Status Badges */
.badge{
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.pending{ background:#f59e0b; color:#111; }
.progress{ background:#3b82f6; }
.completed{ background:#22c55e; color:#111; }
.rejected{ background:#ef4444; }

/* Buttons */
.action-btn{
    padding:6px 12px;
    border-radius:6px;
    font-size:13px;
    text-decoration:none;
    color:white;
    border:none;
    cursor:pointer;
    margin-right:5px;
}

.edit-btn{ background:#3b82f6; }
.delete-btn{ background:#ef4444; }
.comment-btn{ background:#22c55e; }

.edit-btn:hover{ background:#2563eb; }
.delete-btn:hover{ background:#dc2626; }
.comment-btn:hover{ background:#16a34a; }

.back-link{
    display:inline-block;
    margin-bottom:20px;
    text-decoration:none;
    color:#93c5fd;
}

.no-task{
    text-align:center;
    padding:20px;
    color:#94a3b8;
}

@media(max-width:768px){
    .task-container{ padding:20px; }
    .task-table{ font-size:12px; }
}
</style>

<div class="task-container">

    <a href="{{route ('admin.projects.index')}}" class="back-link">← Back to Projects</a>

    <div class="task-title">📋 All Tasks</div>

    <table class="task-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Task Title</th>
                <th>Due Date</th>
                <th>Assigned To</th>
                <th>Status</th>
                <th>Comments</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $key => $task)

            @php
            $class = match(strtolower($task->status)){
                'pending' => 'pending',
                'in progress' => 'progress',
                'completed' => 'completed',
                'rejected' => 'rejected',
                default => 'pending'
            };
            @endphp

            <tr>
                <td>{{ $key + 1 }}</td>

                <td>
                    <strong>{{ $task->title }}</strong><br>
                    <small style="color:#94a3b8;">{!! Str::limit(strip_tags($task->description), 50) !!}</small>
                </td>

                <td>
                    {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : '—' }}
                </td>

                <td>
                    {{ $task->assignedUser->name ?? 'Not Assigned' }}
                </td>

                <td>
                    <span class="badge {{ $class }}">
                        {{ $task->status }}
                    </span>
                </td>

                <td>
                    {{ $task->comments->count() }} Comments
                </td>

                <td>
                    <a href="{{ route('admin.task.edit', $task->id) }}" class="action-btn edit-btn">
                        Edit
                    </a>

                    <form action="{{ route('admin.task.delete', $task->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Are you sure?')"
                            class="action-btn delete-btn">
                            Delete
                        </button>
                    </form>

                    <a href="{{ route('admin.task.show', $task->id) }}"
                       class="action-btn comment-btn">
                        Comments
                    </a>
                </td>
            </tr>
            @empty
            <tr>
            <td colspan="7" class="no-task">No tasks found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
