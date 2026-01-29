@extends('layout.app')
@section('content')
<style>
    body{ background:#0f172a; color:white; }
    table{
        width: 95%;
        margin:40px auto;
        border-collapse: collapse;
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(10px);
    }
    th, td{
        padding:12px;
        border:1px solid rgba(255,255,255,0.1);
        text-align:center;
    }
    th{
        background:#1e293b;
    }
    .delete-btn{
        background:#ef4444;
        padding:6px 12px;
        border:none;
        color:white;
        border-radius:6px;
        cursor:pointer;
    }
</style>

<h2 style="text-align:center">Today's Tasks</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Due Date</th>
        <th>Assigned To</th>
        <th>Status</th>
        <th>Delete</th>
    </tr>

    @foreach($tasks as $task)
    <tr>
        <td>{{ $task->id }}</td>
        <td>{{ $task->title }}</td>
        <td>{{ $task->description }}</td>
        <td>{{ $task->due_date }}</td>
        <td>{{ $task->assignedUser->name ?? 'N/A' }}</td>
        <td>
            <span style="font-weight:bold;
                @if($task->status == 'Done') color:green;
                @elseif($task->status == 'In Progress') color:orange;
                @elseif($task->status == 'Reject') color:red;
                @else color:white;
                @endif
            ">{{ $task->status ?? 'Not Set' }}</span>
        </td>
        <td>
            <form action="{{ route('admin.task.destroy', $task->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="delete-btn">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire('Success','{{ session('success') }}','success');
</script>
@endif
@endsection
