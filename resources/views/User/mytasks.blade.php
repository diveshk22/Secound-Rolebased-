@extends('layout.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">My Tasks</h2>

    @if($tasks->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Task Title</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $key => $task)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>
                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'N/A' }}
                            </td>
                            <td>
                                @if($task->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($task->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($task->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            No tasks assigned to you.
        </div>
    @endif

</div>

@endsection
