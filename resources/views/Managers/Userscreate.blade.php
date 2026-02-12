@extends('layout.app')

@section('content')

<style>
    body{
        background: linear-gradient(135deg,#0f172a,#1e293b);
        font-family: 'Segoe UI', sans-serif;
    }

    .form-wrapper {
        max-width: 520px;
        margin: 60px auto;
        padding: 35px 40px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn{
        from{opacity:0; transform:translateY(15px);}
        to{opacity:1; transform:translateY(0);}
    }

    .form-title {
        text-align: center;
        font-size: 26px;
        margin-bottom: 25px;
        font-weight: 700;
        color: #1e293b;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #334155;
    }

    .form-group input {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
        transition: 0.3s;
        outline: none;

        background: #ffffff !important;
        color: #0f172a !important;
        caret-color: #0f172a;
    }

    .form-group input::placeholder{
        color: #94a3b8;
    }

    .form-group input:focus{
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
    }

    .btn-submit {
        width: 100%;
        padding: 12px;
        border: none;
        background: #3b82f6;
        color: #fff;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-submit:hover {
        background: #2563eb;
    }

    .error {
        color: #ef4444;
        font-size: 13px;
        margin-top: 4px;
    }

    /* Success Popup */
    .popup {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #22c55e;
        color: white;
        padding: 14px 22px;
        border-radius: 8px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        display: none;
        font-weight: 600;
        z-index: 9999;
        animation: slideIn 0.5s ease forwards;
    }

    @keyframes slideIn{
        from{opacity:0; transform:translateX(100%);}
        to{opacity:1; transform:translateX(0);}
    }
</style>

<div class="form-wrapper">
    <div class="form-title">Create New User</div>

    <form action="{{ route('managers.storeUser') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" placeholder="Enter name" value="{{ old('name') }}" required>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">Create User</button>
    </form>
</div>

<!-- Success Popup -->
<div id="successPopup" class="popup">
    ✅ User Created Successfully!
</div>

<script>
    @if(session('success'))
        const popup = document.getElementById('successPopup');
        popup.style.display = 'block';

        setTimeout(() => {
            popup.style.display = 'none';
}, 3000);
@endif
</script>

@endsection
