<div class="w-64 min-h-screen bg-slate-900 text-slate-200 flex flex-col shadow-xl">

    {{-- Logo / Title --}}
    <div class="p-6 border-b border-slate-700">
        <h2 class="text-2xl font-bold text-blue tracking-wide">
            My Dashboard
        </h2>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 p-4 space-y-2 text-sm">

        @role('admin')
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
                🛠️ <span>Admin Dashboard</span>
            </a><br>
        <a href="{{ route('admin.users.create') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800">
   ➕ <span>Create User</span>
</a><br>
<a href="{{ route('admin.users.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800">
    📋 <span>View Users</span></a>
        @endrole


        @role('user')
            <a href="{{ route('user.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
                🏠 <span>User Dashboard</span>
            </a><br>

            <a href="#"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
                🙍 <span>My Profile</span>
            </a><br>

<br>
        @endrole

    </nav>

    {{-- Logout --}}
    <div class="p-4 border-t border-slate-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg transition font-semibold">
                Logout
            </button>
        </form>
    </div>
</div>
