@extends('layout.app')

@section('content')

<style>
/* Container */
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 50px;
}

/* Card */
.card {
    background: #ffffff;
    padding: 30px;
    width: 450px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* Heading */
.card h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

/* Form Group */
.form-group {
    margin-bottom: 15px;
}

/* Labels */
label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
}

/* Inputs & Textarea */
.form-control {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
    transition: 0.3s;
}

.form-control:focus {
    border-color: #4CAF50;
    outline: none;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
}

/* Hint Text */
/* .hint {
    font-size: 12px;
    color: #777;
} */

/* Button */
.btn-submit {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit:hover {
    background-color: #45a049;
}
</style>

<div class="container">
    <div class="card">
        <h2>Create Project</h2>

        <form action="{{ route('projects.store') }}" 
        method="POST">
        @csrf

            <div class="form-group">
                <label>Project Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter project name" required>
            </div>

            <div class="form-group">
                <label>Project Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Enter project description" required></textarea>
            </div>

            <div class="form-group">
                <label>Assign To</label>
                <select name="users[]" class="form-control" multiple required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                <!-- <small class="hint">
                    Hold Ctrl (Windows) or Cmd (Mac) to select multiple users
                </small> -->
            </div>

            <button type="submit" class="btn-submit">
                Create Project
            </button>

        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

@endsection
