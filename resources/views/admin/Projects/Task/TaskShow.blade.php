@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>{{ $task->title }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $task->description ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ $task->status ?? 'N/A' }}</p>
            <p><strong>Due Date:</strong> {{ $task->due_date ?? 'N/A' }}</p>
            <p><strong>Created By:</strong> {{ $task->user->name ?? 'N/A' }}</p>
            <p><strong>Assigned To:</strong> {{ $task->assignedUser->name ?? 'N/A' }}</p>
            <p><strong>Project:</strong> {{ $task->project->name ?? 'N/A' }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('projects.tasks.index', $task->project_id) }}" class="btn btn-secondary">Back to Tasks</a>
        </div>
    </div>
</div>
@endsection
