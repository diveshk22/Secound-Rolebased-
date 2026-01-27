@extends('layout.app')

@section('content')
@if(session('deleted'))
    <script>
        alert("{{ session('deleted') }}");
    </script>
@endif
<!-- User Index Page -->
<div class="p-8">

    <h2 class="text-3xl font-extrabold text-white mb-10 tracking-wide">
        👥 Users List
    </h2>
<!-- User Index Table -->
    <div class="overflow-x-auto rounded-2xl shadow-2xl
                backdrop-blur-xl bg-white/10 border border-white/20">
<!-- User Index Table Body -->
        <table class="min-w-full text-left text-gray-200">
            <thead class="bg-white/10 text-gray-300 uppercase text-sm tracking-wider">
                <tr>
                    <th class="py-4 px-6">ID</th>
                    <th class="py-4 px-6">Name</th>
                    <th class="py-4 px-6">Email</th>
                    <th class="py-4 px-6">Role</th>
                    <th class="py-4 px-6 text-center">Action</th>
                </tr>
            </thead>
    <!-- User Index Table Body -->
            <tbody class="divide-y divide-white/10">
                @foreach($users as $user)
                    <tr class="hover:bg-white/10 transition duration-200">

                        {{-- ID --}}
                        <td class="py-4 px-6 font-semibold">
                            {{ $user->id }}
                        </td>

                        {{-- Name --}}
                        <td class="py-4 px-6">
                            {{ $user->name }}
                        </td>

                        {{-- Email --}}
                        <td class="py-4 px-6 text-blue-300">
                            {{ $user->email }}
                        </td>
        <!-- Action Role Button -->
                        {{-- Role Button --}}
                        <td class="py-4 px-6">
                            <form action="{{ route('admin.users.changeRole', $user->id) }}" method="POST">
                                @csrf
                                <button
                                    class="px-4 py-2 rounded-lg text-white font-semibold transition
                                    {{ $user->hasRole('admin')
                                        ? 'bg-red-600 hover:bg-red-700'
                                        : 'bg-blue-600 hover:bg-blue-700' }}">
                                    
                                    @if($user->hasRole('admin'))
                                        Admin (Make User)
                                    @else
                                        User (Make Admin)
                                    @endif
                                </button>
                            </form>
                        </td>
                <!--  Delete Role Action -->
                        {{-- Delete Action --}}
                        <td class="py-4 px-6 text-center">
                            <form id="delete-form-{{ $user->id }}"
                                  action="{{ route('admin.users.destroy', $user->id) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                <!-- Delete Button -->
                                <button type="button"
                                        onclick="confirmDelete({{ $user->id }})"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                                    Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
<!-- User Index Page || Delete button js script  -->
</div>
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this user?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>


@endsection
