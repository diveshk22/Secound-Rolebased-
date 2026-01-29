@extends('layout.app')

@section('content')

<style>
    body{
        background: #0f172a;
    }

    .task-card{
        max-width: 700px;
        margin: 60px auto;
        padding: 40px;
        border-radius: 18px;
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        color: white;
    }

    .task-card h2{
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .form-group{
        margin-bottom: 22px;
        display: flex;
        flex-direction: column;
    }

    .form-group label{
        margin-bottom: 8px;
        font-size: 14px;
        color: #cbd5e1;
    }

    .form-group input{
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.15);
        background: rgba(255,255,255,0.05);
        color: white;
        font-size: 14px;
        outline: none;
        transition: 0.3s ease;
    }

    .form-group select{
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.15);
        background: rgba(255,255,255,0.05);
        color: white;
        font-size: 14px;
        outline: none;
        transition: 0.3s ease;
        width: 100%;
    }

    .form-group select option{
        background: #1e293b;
        color: white;
    }

    .form-group input:focus, .form-group select:focus{
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56,189,248,0.3);
        background: rgba(255,255,255,0.08);
    }

    .submit-btn{
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #38bdf8, #6366f1);
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s ease;
        margin-top: 10px;
    }

    .submit-btn:hover{
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(56,189,248,0.4);
    }
</style>

<div class="task-card">
    <h2>Create New Task</h2>

    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 10px; padding: 15px; margin-bottom: 20px; color: #fca5a5;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.task.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Task Name</label>
            <input type="text" name="title" placeholder="Enter Task Name" required />
        </div>

        <div class="form-group">
            <label>Task Description</label>
            <input type="text" name="description" placeholder="Enter Task Description" />
        </div>

        <div class="form-group">
            <label>Due Date</label>
            <input type="date" name="due_date" />
        </div>


        <div class="form-group">
            <label>Assign To</label>
            <select name="assigned_to" required>
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="submit-btn">Create Task</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        title: 'Success 🎉',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK',
        background: '#0f172a',
        color: '#fff',
        confirmButtonColor: '#3b82f6'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        title: 'Error ❌',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'OK',
        background: '#0f172a',
        color: '#fff',
        confirmButtonColor: '#ef4444'
    });
</script>
@endif


@endsection
