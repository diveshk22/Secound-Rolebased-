@extends('layout.app')

@section('content')

<style>
    .form-input {
        background-color: #111827;
        color: #ffffff;
        border: 1px solid #4b5563;
    }
    .form-input::placeholder {
        color: #9ca3af;
    }
    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px #3b82f6;
        background-color: #0f172a;
        color: #ffffff;
    }
    input:-webkit-autofill,
    input:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0 1000px #111827 inset !important;
        -webkit-text-fill-color: #ffffff !important;
    }
</style>

<div class="flex justify-center items-center min-h-screen">

    <div class="w-full max-w-2xl p-10 rounded-2xl shadow-2xl
                backdrop-blur-xl bg-white/10 border border-white/20">

        <h2 class="text-3xl font-extrabold text-white mb-8 tracking-wide">
            ➕ Create New User
        </h2>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block mb-2 font-semibold text-gray-200">Name</label>
                <input type="text" name="name" class="form-input w-full p-3 rounded-lg"
                       placeholder="Enter name" required>
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-200">Email</label>
                <input type="email" name="email" class="form-input w-full p-3 rounded-lg"
                       placeholder="Enter email" required>
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-200">Password</label>
                <input type="password" name="password" class="form-input w-full p-3 rounded-lg"
                       placeholder="Enter password" required>
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-200">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-input w-full p-3 rounded-lg"
                       placeholder="Confirm password" required>
            </div>

<style>
    .btn-premium {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        transition: all 0.35s ease;
        box-shadow: 0 10px 25px rgba(59,130,246,0.35);
    }

    .btn-premium:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 40px rgba(99,102,241,0.55);
    }

    .btn-premium::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            120deg,
            transparent,
            rgba(255,255,255,0.35),
            transparent
        );
        transition: all 0.6s ease;
    }

    .btn-premium:hover::before {
        left: 100%;
    }
</style>

<button type="submit"
    class="btn-premium w-full mt-6 py-3 rounded-xl
           font-bold text-lg text-white tracking-wide">
    🚀 Create User
</button>

        </form>

    </div>

</div>

@endsection
