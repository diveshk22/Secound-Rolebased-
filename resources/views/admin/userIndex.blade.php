@extends('layout.app')

@section('content')

<style>
    body{ background:#0f172a; }

    .page-title{
        font-size: 38px;
        font-weight: 800;
        color: white;
        letter-spacing: 1px;
    }

    .table-wrapper{
        backdrop-filter: blur(20px);
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 25px 60px rgba(0,0,0,0.6);
    }

    table{ width:100%; border-collapse: collapse; color:#e5e7eb; }

    thead{
        background: rgba(255,255,255,0.08);
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
    }

    thead th{
        padding:18px 24px;
        position: sticky;
        top: 0;
        backdrop-filter: blur(10px);
    }

    tbody tr{
        transition: 0.3s ease;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    tbody tr:hover{
        background: rgba(255,255,255,0.08);
        transform: scale(1.01);
    }

    td{ padding:18px 24px; }

    .email{ color:#60a5fa; font-weight:600; }

    .role-btn, .delete-btn{
        padding:10px 18px;
        border-radius:10px;
        font-weight:600;
        border:none;
        cursor:pointer;
        transition:.3s;
        color:white;
    }

    .btn-admin{ background:#dc2626; }
    .btn-admin:hover{ box-shadow:0 0 20px #dc2626; }

    .btn-user{ background:#2563eb; }
    .btn-user:hover{ box-shadow:0 0 20px #2563eb; }

    .delete-btn{ background:#ef4444; }
    .delete-btn:hover{ box-shadow:0 0 20px #ef4444; }
</style>

<div class="p-8">

    <h2 class="page-title mb-10">👥 Users List</h2>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role Action</th>
                    <th class="text-center">Delete</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="font-semibold">{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td class="email">{{ $user->email }}</td>

                    <td>
                        @role('admin')
                        <form action="/user/{{ $user->id }}/make-manager" method="POST">
                            @csrf
                            <button type="submit">Make Manager</button>
                        </form>
                        @endrole

                        <form action="{{ route('admin.users.changeRole', $user->id) }}" method="POST">
                            @csrf
                            <button class="role-btn {{ $user->hasRole('admin') ? 'btn-admin' : 'btn-user' }}">
                                {{ $user->hasRole('admin') ? 'Admin (Make User)' : 'User (Make Admin)' }}
                            </button>
                        </form>
                    </td>

                    <td class="text-center">
                        <form id="delete-form-{{ $user->id }}"
                              action="{{ route('admin.users.destroy', $user->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="button"
                                    onclick="confirmDelete({{ $user->id }})"
                                    class="delete-btn">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This user will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

@if(session('deleted'))
<script>
    Swal.fire({
        title: 'Deleted 🗑️',
        text: "{{ session('deleted') }}",
        icon: 'success',
        confirmButtonColor: '#ef4444',
        background: '#0f172a',
        color: '#fff'
    });
</script>
@endif

@endsection
