@extends('layout.app')

@section('content')

<style>
    body{ background:#0f172a; }

    .view-card{
        max-width:600px;
        margin:60px auto;
        padding:40px;
        border-radius:18px;
        background:rgba(255,255,255,0.06);
        backdrop-filter:blur(20px);
        border:1px solid rgba(255,255,255,0.1);
        color:white;
    }

    .form-group{
        margin-bottom:20px;
    }

    textarea{
        width:100%;
        padding:12px;
        border-radius:6px;
        border:1px solid #374151;
        background:#111827;
        color:white;
        resize:vertical;
        min-height:120px;
    }

    .btn{
        padding:10px 20px;
        border-radius:6px;
        text-decoration:none;
        margin-right:10px;
        border:none;
        cursor:pointer;
    }
</style>

   <div class="view-card">
    <h2>✏️ Edit Task Description</h2>
    
    <form action="{{ route('admin.task.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')
        
    <div class="form-group">
    <textarea name="description" placeholder="Enter task description...">{{ $task->description }}</textarea>
    </div>

    <button type="submit" class="btn" style="background:#10b981; color:white;">
    Update Description
    </button>
        
    <a href="{{ route('admin.task.index') }}" class="btn" style="background:#6b7280; color:white;">
    Cancel
    </a>
    </form>
    </div>

    @endsection