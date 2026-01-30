@extends('layout.app')

@section('content')

<style>
    body{
        background:#0f172a;
        font-family:'Segoe UI', sans-serif;
    }

    .desc-wrapper{
        max-width:900px;
        margin:70px auto;
        padding:45px;
        border-radius:24px;
        background:rgba(255,255,255,0.06);
        backdrop-filter:blur(25px);
        box-shadow:0 30px 90px rgba(0,0,0,0.6);
        color:#fff;
        animation:fadeIn 0.4s ease-in-out;
    }

    .desc-title{
        font-size:30px;
        font-weight:800;
        text-align:center;
        margin-bottom:30px;
        letter-spacing:1px;
        background:linear-gradient(90deg,#0ea5e9,#6366f1);
        -webkit-background-clip:text;
        -webkit-text-fill-color:transparent;
    }

    .desc-content{
        background:rgba(255,255,255,0.05);
        padding:25px;
        border-radius:16px;
        line-height:1.8;
        font-size:15px;
        border:1px solid rgba(255,255,255,0.08);
    }

    .back-btn{
        display:inline-block;
        margin-top:30px;
        padding:10px 18px;
        border-radius:10px;
        background:linear-gradient(90deg,#334155,#1e293b);
        color:white;
        text-decoration:none;
        font-weight:600;
        transition:0.3s;
    }

    .back-btn:hover{
        transform:translateY(-2px);
        box-shadow:0 10px 25px rgba(0,0,0,0.4);
    }

    @keyframes fadeIn{
        from{opacity:0; transform:translateY(15px);}
        to{opacity:1; transform:translateY(0);}
    }

    @media(max-width:768px){
        .desc-wrapper{
            padding:25px;
        }
        .desc-title{
            font-size:22px;
        }
    }
</style>

<div class="desc-wrapper">
    <div class="desc-title">Task Description</div>

    <div class="desc-content">
        {!! $task->description !!}
    </div>

    <a href="{{ url()->previous() }}" class="back-btn">← Back</a>
</div>

@endsection
