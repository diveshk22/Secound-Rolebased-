@extends('layout.app')

@section('content')

<style>
    body{
        font-family: 'Inter', sans-serif;
        background: linear-gradient(120deg, #0f172a, #1e293b);
        margin: 0;
        padding: 0;
        color: #fff;
    }

    .projects-container{
        width: 92%;
        max-width: 1150px;
        margin: 40px auto;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 28px;
    }

    .project-card{
        background: #1e293b;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.4);
        transition: all 0.3s ease;
        position: relative;
        border: 1px solid rgba(255,255,255,0.05);
    }

    .project-card:hover{
        transform: translateY(-8px);
        box-shadow: 0 20px 45px rgba(0,0,0,0.6);
    }

    .project-card::before{
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #38bdf8, #6366f1);
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }

    .project-title{
        font-size: 21px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #38bdf8;
    }

    .project-desc{
        font-size: 14px;
        color: #cbd5e1;
        margin-bottom: 14px;
        line-height: 1.6;
        min-height: 55px;
    }

    .creator{
        font-size: 13px;
        color: #94a3b8;
        margin-bottom: 14px;
    }

    .creator span{
        color: #e2e8f0;
        font-weight: 600;
    }

    .users-title{
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .users-list{
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .users-list li{
        background: rgba(255,255,255,0.06);
        padding: 6px 10px;
        border-radius: 6px;
        margin-bottom: 6px;
        font-size: 13px;
        color: #e2e8f0;
    }

    .no-project{
        text-align: center;
        margin-top: 80px;
        font-size: 20px;
        color: #94a3b8;
    }
</style>

    @if($projects->count() > 0)
    <div class="projects-container">
    @foreach($projects as $project)
    <div class="project-card">
    <div class="project-title">{{ $project->name }}</div>            
    <div class="project-desc">
    {{ $project->description }}
    </div>
    <div class="creator">
    <strong>Created By:</strong>
    <span>{{ $project->creator->name }}</span>
    ({{ $project->creator->getRoleNames()->first() }})
    </div>

    <div class="users-title">Users in this project</div>
    <ul class="users-list">
    @role('manager|admin')
    @foreach($project->users as $user)
    <li>{{ $user->name }}</li>
    @endforeach
    @elserole('user')
    <li>{{ auth()->user()->name }}</li>
    @endrole
    </ul>
    </div>
    @endforeach
    </div>
    @else
    <div class="no-project">
    No projects available.
    </div>
@endif

@endsection
