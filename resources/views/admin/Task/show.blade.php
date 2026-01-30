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

    .description-box{
        background:#111827;
        border:1px solid #374151;
        border-radius:8px;
        padding:20px;
        margin:20px 0;
        line-height:1.6;
    }
</style>

<div class="view-card">
    <h2>📄 Task Description</h2>
    
    <div class="description-box">
        {{ $task->description ?? 'No description provided.' }}
    </div>

    <a href="{{ route('admin.task.index') }}" 
       style="padding:10px 20px; background:#6b7280; border-radius:6px; text-decoration:none; color:white;">
       Back to Tasks
    </a>
</div>

@endsection