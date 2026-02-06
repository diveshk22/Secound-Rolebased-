@extends('layout.app')

@section('content')

<style>
    body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        background-color: #2f3542; /* Dark background */
    }

    .container {
        max-width: 750px;
        margin: 50px auto;
        background: #3d4452; /* Dark card */
        padding: 35px 40px;
        border-radius: 10px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        color: #f1f2f6;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #ffffff;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 6px;
        color: #dcdde1;
    }

    input[type="text"],
    textarea,
    select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #57606f;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
        background-color: #57606f;
        color: #fff;
    }

    input::placeholder,
    textarea::placeholder {
        color: #dfe4ea;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #1e90ff;
        outline: none;
        background-color: #6c757d;
    }

    textarea {
        height: 100px;
        resize: vertical;
    }

    /* Scrollable user list */
    select[multiple] {
        height: 120px;
        overflow-y: scroll;
    }

    /* Custom scrollbar */
    select[multiple]::-webkit-scrollbar {
        width: 8px;
    }

    select[multiple]::-webkit-scrollbar-thumb {
        background: #1e90ff;
        border-radius: 10px;
    }

    .btn-submit {
        width: 100%;
        padding: 12px;
        background-color: #1e90ff;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 10px;
    }

    .btn-submit:hover {
        background-color: #0d6efd;
    }
</style>

<div class="container">
    <h1>Create Project</h1>

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Project Name</label>
            <input type="text" id="name" name="name" placeholder="Enter project name" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Enter project description" required></textarea>
        </div>

        <div class="form-group">
            <label for="assigned_users">Assign Users</label>
            <select id="assigned_users" name="assigned_users[]" multiple required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-submit">Create Project</button>
    </form>
</div>

@endsection
