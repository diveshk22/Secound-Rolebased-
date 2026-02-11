
    <div class="w-64 min-h-screen bg-slate-900 text-slate-200 flex flex-col shadow-xl">

    {{-- Logo / Title --}}
    <div class="p-6 border-b border-slate-700">
    <h2 class="text-2xl font-bold text-blue tracking-wide">
    My Dashboard
    </h2>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 p-4 space-y-2 text-sm">

    @role('superadmin')
    <a href="{{ route('superadmin.superdashboard') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    🔧 <span>Super Admin Dashboard</span>
    </a><br>
    <a href="{{ route('super.users') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    👥 <span>Manage Users</span>
    </a><br>
    @endrole

     @role('admin')
    <a href="{{ route('admin.dashboard') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    🛠️ <span>Admin Dashboard</span>
    </a><br>
    <a href="{{ route('admin.users.create') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
     ➕ <span>Create User</span>
    </a><br>
    <!-- create Project -->
    <a href="{{ route('projects.create') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    📝 <span>Create Project</span>
    </a><br>
    <!-- View All Project -->
    <a href="{{ route('projects.index') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    📁 <span>All Assigen Projects</span>
    </a><br>
     <div class="space-y-2">

    <!-- View Users -->
    <a href="{{ route('admin.users.index') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
    <span class="text-lg">👥</span>
    <span class="font-medium">View Users</span>
    </a><br>
    
    <!-- Create Tasks -->
    <a href="{{ route('admin.task.createtask') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
    <span class="text-lg">➕</span>
    <span class="font-medium">Create Tasks</span>
    </a><br>

    <!-- View Tasks -->
    <a href="{{ route('admin.task.index') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
    <span class="text-lg">📋</span><br>
    <span class="font-medium">View Tasks</span>
    </a>
    </div>
    @endrole
    @role('manager')

    <a href="{{ route('managers.managerdashboard') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    📊 <span>Manager Dashboard</span>
    </a><br>

    <a href="{{ route('managers.createuser') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    ➕ <span>Create User</span>
    </a><br>

    <a href="{{ route('projects.create') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    📝 <span>Create Project</span>
    </a><br>


    <a href="{{ route('managers.assigntask') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    📝 <span>Assign Task</span>
    </a><br>

    <a href="{{ route('managers.allusers') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    👥 <span>View Users</span>
    </a><br>

    <a href="{{ route('managers.viewassigntask') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    ✅ <span>View Assigned Tasks</span>
    </a><br>
    <!-- Project Show  -->
    <a href="{{ route('projects.index') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    📁 <span>My Projects</span>
    </a>
    @endrole

    @role('user')
    <a href="{{ route('user.dashboard') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    🏠 <span>User Dashboard</span>
     </a><br>

    <a href="{{ route('user.task.showtask') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    ✅ <span>My Tasks</span>
    </a><br>
    <a href="{{ route('task.profile') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    🙍 <span>My Profile</span>
    </a><br>
    
    <a href="{{ route('projects.index') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition">
    📁 <span>My Projects</span>
    </a></br>
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
