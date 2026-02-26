@extends('layout.app')

@section('content')

<style>
    body{
        background:#0f172a;
        font-family: 'Segoe UI', sans-serif;
    }

    .view-card{
        max-width: 750px;
        margin: 60px auto;
        padding: 40px;
        border-radius: 20px;
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(25px);
        box-shadow: 0 10px 40px rgba(0,0,0,0.4);
        color: white;
    }

    .view-card h2{
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    label{
        display:block;
        margin-top:18px;
        margin-bottom:8px;
        font-weight:600;
        color:#cbd5e1;
    }

    input, textarea, select{
        width:100%;
        padding:12px 14px;
        border-radius:10px;
        border:1px solid rgba(255,255,255,0.15);
        background: rgba(255,255,255,0.08);
        color:white;
        font-size:14px;
        outline:none;
        transition: all .3s ease;
    }

    input:focus, textarea:focus, select:focus{
        border-color:#38bdf8;
        box-shadow:0 0 0 2px rgba(56,189,248,0.3);
        background: rgba(255,255,255,0.12);
    }

    textarea{
        resize:none;
    }

    select option{
        background:#0f172a;
        color:white;
    }

    .btn-update{
        margin-top:30px;
        width:100%;
        padding:14px;
        border:none;
        border-radius:12px;
        background: linear-gradient(135deg,#38bdf8,#0ea5e9);
        color:white;
        font-weight:700;
        font-size:15px;
        cursor:pointer;
        transition: all .3s ease;
    }

    .btn-update:hover{
        transform: translateY(-2px);
        box-shadow:0 10px 25px rgba(56,189,248,0.4);
    }

    .btn-delete{
        margin-top:15px;
        width:100%;
        padding:12px;
        border:none;
        border-radius:12px;
        background: linear-gradient(135deg,#ef4444,#dc2626);
        color:white;
        font-weight:700;
        font-size:14px;
        cursor:pointer;
        transition: all .3s ease;
    }

    .btn-delete:hover{
        transform: translateY(-2px);
        box-shadow:0 10px 25px rgba(239,68,68,0.4);
    }
</style>

<a href="{{ route('projects.tasks.index', $task->project_id) }}" style="color:white;">Back</a>

<div class="view-card">
    <h2>Edit Task</h2>

    <form action="{{ auth()->user()->hasRole('user') ? route('user.projects.task.update', $task->id) : route('projects.task.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Task Title</label>
        <input type="text" name="title" value="{{ $task->title }}" required>

        <label>Description</label>
        <textarea name="description" rows="5">{{ $task->description }}</textarea>

        <label>Due Date</label>
        <input type="date" name="due_date" value="{{ $task->due_date }}">

        @php
        $user = auth()->user();
        @endphp

        @if($user->hasRole(['admin', 'super_admin', 'manager']))
        <label>Assign User</label>
        <select name="assigned_to">
            @foreach($users as $u)
                <option value="{{ $u->id }}" {{ $task->assigned_to==$u->id?'selected':'' }}>
                    {{ $u->name }}
                </option>
            @endforeach
        </select>
        @endif

        <label>Status</label>
        <select name="status">
            <option value="Pending" {{ $task->status=='Pending'?'selected':'' }}>Pending</option>
            <option value="In Progress" {{ $task->status=='In Progress'?'selected':'' }}>In Progress</option>
            <option value="Completed" {{ $task->status=='Completed'?'selected':'' }}>Completed</option>
        </select>

        <button type="submit" class="btn-update">Update Task</button>
    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session("success") }}',
        confirmButtonColor: '#0ea5e9',
        background: '#1e293b',
        color: '#fff'
    });
</script>
@endif

@endsection