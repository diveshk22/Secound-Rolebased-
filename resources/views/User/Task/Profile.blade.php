@extends('layout.app')

@section('title', 'My Profile')

@section('content')

<style>
body{
    background: radial-gradient(circle at top left, #0f172a, #020617);
    font-family: 'Segoe UI', sans-serif;
}

/* Main Card */
.profile-card{
    max-width:780px;
    margin:60px auto;
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(35px);
    border-radius:24px;
    padding:45px;
    color:white;
    box-shadow:0 40px 120px rgba(0,0,0,0.8);
    border:1px solid rgba(255,255,255,0.12);
    position: relative;
    overflow: hidden;
}

/* Gradient Glow Border */
.profile-card::before{
    content:'';
    position:absolute;
    inset:0;
    border-radius:24px;
    padding:1px;
    background:linear-gradient(135deg,#0ea5e9,#6366f1,#8b5cf6);
    -webkit-mask:
        linear-gradient(#000 0 0) content-box,
        linear-gradient(#000 0 0);
    -webkit-mask-composite: xor;
            mask-composite: exclude;
    pointer-events:none;
}

/* Heading */
.profile-card h3{
    font-size:32px;
    font-weight:800;
    letter-spacing:1px;
    margin-bottom:30px;
    text-align:center;
    background:linear-gradient(to right,#38bdf8,#818cf8);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

/* Profile Image */
.profile-img{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
    border:5px solid #6366f1;
    box-shadow:0 15px 40px rgba(99,102,241,0.6);
    transition:0.4s ease;
}

.profile-img:hover{
    transform:scale(1.08) rotate(2deg);
    box-shadow:0 20px 60px rgba(99,102,241,0.9);
}

/* Inputs */
.form-control{
    background:rgba(255,255,255,0.06) !important;
    border:1px solid rgba(255,255,255,0.15) !important;
    border-radius:12px;
    padding:13px 14px;
    color:white !important;
    transition:all 0.3s ease;
    font-size:15px;
}

.form-control:focus{
    background:rgba(255,255,255,0.12) !important;
    border-color:#818cf8 !important;
    box-shadow:0 0 0 3px rgba(129,140,248,0.35);
}

/* Labels */
label{
    font-weight:600;
    margin-bottom:8px;
    color:#cbd5e1;
    letter-spacing:.3px;
}

/* Button */
.btn-update{
    background:linear-gradient(135deg,#0ea5e9,#6366f1,#8b5cf6);
    border:none;
    padding:14px;
    font-weight:700;
    border-radius:12px;
    letter-spacing:1px;
    transition:all .35s ease;
    color:white;
    font-size:16px;
}

.btn-update:hover{
    transform:translateY(-4px);
    box-shadow:0 15px 40px rgba(99,102,241,0.7);
}

/* Alerts */
.alert{
    border-radius:12px;
    text-align:center;
    font-weight:600;
    background:rgba(34,197,94,0.15);
    border:1px solid rgba(34,197,94,0.4);
    color:#86efac;
    padding:12px;
}

/* Responsive */
@media(max-width:768px){
    .profile-card{
        margin:25px;
        padding:30px;
    }
}
</style>

<div class="profile-card">

    <h3>Update Profile</h3>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Profile Image --}}
        <div class="text-center mb-4">
            @if(Auth::user()->photo)
                <img src="{{ asset('profile_photos/'.Auth::user()->photo) }}" class="profile-img" id="previewImg">
            @else
                <img src="https://via.placeholder.com/140" class="profile-img" id="previewImg">
            @endif
        </div>

        <div class="mb-3">
            <label>Profile Photo</label>
            <input type="file" name="photo" class="form-control" onchange="previewImage(event)">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>New Password (optional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn-update w-100 mt-3">Update Profile</button>
    </form>
</div>
<script>
function previewImage(event){
    let reader = new FileReader();
    reader.onload = function(){
        document.getElementById('previewImg').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
