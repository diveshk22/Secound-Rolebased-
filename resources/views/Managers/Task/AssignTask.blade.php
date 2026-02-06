@extends('layout.app')
@section('content')

<style>
    .page-bg{
        min-height: 92vh;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:40px 15px;
        background: radial-gradient(circle at top,#0f172a,#020617);
    }

    .task-card{
        width:100%;
        max-width:720px;
        padding:45px 50px;
        border-radius:16px;
        background: rgba(15,23,42,0.85);
        backdrop-filter: blur(14px);
        border:1px solid rgba(255,255,255,0.08);
        box-shadow:0 30px 80px rgba(0,0,0,0.6);
        color:#e2e8f0;
        animation:fade .4s ease;
    }

    @keyframes fade{
        from{opacity:0; transform:translateY(20px);}
        to{opacity:1; transform:translateY(0);}
    }

    .title{
        text-align:center;
        font-size:28px;
        font-weight:700;
        margin-bottom:35px;
        color:#ffffff;
        letter-spacing:.5px;
    }

    .form-group{
        margin-bottom:22px;
    }

    label{
        display:block;
        margin-bottom:8px;
        font-weight:600;
        font-size:14px;
        color:#cbd5e1;
    }

    select, textarea, input[type="date"]{
        width:100%;
        padding:13px 14px;
        border-radius:8px;
        border:1px solid #334155;
        background:#0f172a;
        color:#f1f5f9;
        font-size:14px;
        transition:.25s;
    }

    select:focus, textarea:focus, input:focus{
        outline:none;
        border-color:#3b82f6;
        box-shadow:0 0 0 3px rgba(59,130,246,0.25);
        background:#0b1220;
    }

    textarea{ resize:none; }

    .btn-assign{
        margin-top:10px;
        width:100%;
        padding:14px;
        border:none;
        border-radius:8px;
        background:linear-gradient(135deg,#3b82f6,#2563eb);
        color:white;
        font-size:16px;
        font-weight:600;
        cursor:pointer;
        transition:.3s;
    }

    .btn-assign:hover{
        transform:translateY(-2px);
        box-shadow:0 15px 35px rgba(37,99,235,.4);
    }

    /* Success Popup */
    .popup{
        position: fixed;
        top: 25px;
        right: 25px;
        background: #22c55e;
        color: white;
        padding: 14px 22px;
        border-radius: 8px;
        font-weight: 600;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        display: none;
        z-index: 9999;
        animation: slideIn .4s ease forwards;
    }

    @keyframes slideIn{
        from{opacity:0; transform:translateX(120%);}
        to{opacity:1; transform:translateX(0);}
    }
</style>

<div class="page-bg">
    <div class="task-card">
        <div class="title">Assign Task to Employee</div>
                <form action="/managers/Task/Assign" method="POST">
                 @csrf

            <div class="form-group">
                <label>Select Employee</label>
                <select name="employee_id" required>
                    <option value="" disabled selected>Select an employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Task Description</label>
                <textarea name="task_description" rows="4" placeholder="Enter task details..." required></textarea>
            </div>

            <div class="form-group">
                <label>Due Date</label>
                <input type="date" name="due_date" required>
            </div>

            <button type="submit" class="btn-assign">Assign Task</button>
        </form>
    </div>
</div>

<!-- Success Popup -->
<div id="successPopup" class="popup">
    ✅ Task Assigned Successfully!
</div>

<script>
    @if(session('success'))
        const popup = document.getElementById('successPopup');
        popup.style.display = 'block';
        setTimeout(() => popup.style.display = 'none', 3000);
    @endif
</script>

@endsection
