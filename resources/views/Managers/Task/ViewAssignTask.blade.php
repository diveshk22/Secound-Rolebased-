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

.assign-wrapper{
    padding:50px 20px;
    display:flex;
    justify-content:center;
}

.assign-card{
    width:100%;
    max-width:700px;
    background:rgba(15,23,42,0.92);
    border-radius:18px;
    padding:40px;
    border:1px solid rgba(255,255,255,0.08);
    box-shadow:0 40px 90px rgba(0,0,0,.7);
    backdrop-filter:blur(16px);
    color:#e2e8f0;
}

.assign-title{
    text-align:center;
    font-size:30px;
    font-weight:700;
    margin-bottom:35px;
    color:#fff;
    letter-spacing:.6px;
}

.form-group{
    margin-bottom:24px;
}

.form-label{
    display:block;
    margin-bottom:8px;
    color:#94a3b8;
    font-weight:600;
    font-size:14px;
}

.form-control{
    width:100%;
    background:#0f172a;
    border:1px solid #334155;
    border-radius:8px;
    padding:12px;
    color:#fff;
    font-size:14px;
}

.form-control:focus{
    outline:none;
    border-color:#3b82f6;
}

textarea.form-control{
    resize:vertical;
    min-height:100px;
}

.btn-submit{
    width:100%;
    padding:14px;
    background:#2563eb;
    border:none;
    border-radius:8px;
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.btn-submit:hover{
    background:#1d4ed8;
}

.alert{
    padding:12px;
    border-radius:8px;
    margin-bottom:20px;
}

.alert-success{
    background:#064e3b;
    color:#6ee7b7;
    border:1px solid #065f46;
}
</style>

<div class="assign-wrapper">
    <div class="assign-card">
        <div class="assign-title">Assign Task to Employee</div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('managers.task.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Select Employee</label>
                <select name="employee_id" class="form-control" required>
                    <option value="">-- Choose Employee --</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
                @error('employee_id')
                    <small style="color:#f87171;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Task Description</label>
                <textarea name="task_description" class="form-control" required placeholder="Enter task details..."></textarea>
                @error('task_description')
                    <small style="color:#f87171;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control">
                @error('due_date')
                    <small style="color:#f87171;">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Assign Task</button>
        </form>
    </div>
</div>

@endsection
