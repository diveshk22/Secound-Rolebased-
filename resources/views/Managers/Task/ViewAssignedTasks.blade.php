@extends('layout.app')
@section('content')

<div class="tasks-container">
    <div class="tasks-card">
        <h2 class="tasks-title">View Assigned Tasks</h2>

        @if($assignedTasks->count() > 0)
            <div class="table-responsive">
                <table class="tasks-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Task Name</th>
                            <th>Description</th>
                            <th>Assigned To</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignedTasks as $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="bold">{{ $task->title }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($task->description, 50) }}</td>
                                <td>{{ $task->assignedUser->name ?? 'N/A' }}</td>
                                <td>
                                    {{ $task->due_date 
                                        ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') 
                                        : 'N/A' }}
                                </td>
                                <td>
                                    <span class="status-badge 
                                        {{ ($task->status ?? 'pending') == 'completed' 
                                            ? 'status-completed' 
                                            : 'status-pending' }}">
                                        {{ ucfirst($task->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td>{{ $task->created_at->format('d M Y') }}</td>
                                <td style="min-width:280px; text-align:left;">
                                {{-- Existing Comments --}}
                                <div class="comment-section">
                                    <div class="label">Comments</div>

                                @forelse($task ->comments as $comment)
                                <div class="comment-box">
                                    <div class="comment-head">
                                        {{$comment->user->name }} {{ $comment->created_at->diffForHumans()}}
                                    </div>
                                    <div>{{ $comment->comment}}</div>
                                </div>
                                @empty
                                <div style="font-size:13px;color:#64748b;">No comments yet.</div>
                                @endforelse
                                <form action="{{ route('managers.task.comment') }}" method="POST" class="comment-form">
                                    @csrf
                                    <input type="hidden" name="task_id" value="{{$task->id}}">
                                    <textarea name="comment" required placeholder="Write a comment..."></textarea>
                                    <button type="submit">Add Comment</button>
                                </form>
                                </div>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-tasks">
                No tasks have been assigned yet.
            </div>
        @endif
    </div>
</div>

<style>
.tasks-container{
    padding: 40px 20px;
    display:flex;
    justify-content:center;
}

.tasks-card{
    width:100%;
    max-width:1100px;
    background: rgba(15, 23, 42, 0.9);
    border-radius:14px;
    padding:35px 40px;
    box-shadow:0 30px 70px rgba(0,0,0,.6);
    border:1px solid #1f2937;
    color:#e5e7eb;
}

.tasks-title{
    text-align:center;
    font-size:28px;
    font-weight:700;
    margin-bottom:30px;
    color:#ffffff;
}

.table-responsive{
    overflow-x:auto;
}

.tasks-table{
    width:100%;
    border-collapse:collapse;
    font-size:14px;
}

.tasks-table thead{
    background:#111827;
    color:#cbd5e1;
}

.tasks-table th,
.tasks-table td{
    padding:14px 12px;
    border-bottom:1px solid #1f2937;
    text-align:left;
}

.tasks-table tbody tr{
    transition:0.2s;
}

.tasks-table tbody tr:hover{
    background:#1e293b;
}

.bold{
    font-weight:600;
    color:#ffffff;
}

.status-badge{
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.status-pending{
    background:#3f3f1a;
    color:#fde68a;
}

.status-completed{
    background:#064e3b;
    color:#6ee7b7;
}

.no-tasks{
    text-align:center;
    padding:50px;
    color:#94a3b8;
    font-style:italic;
}
</style>

@endsection
