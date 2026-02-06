@extends('layout.app')

@section('content')

<div class="p-8 text-slate-200">

    {{-- Welcome --}}
    <div class="bg-slate-800 border border-slate-700 rounded-xl p-6 shadow-lg mb-8">
        <h1 class="text-3xl font-bold mb-2">
            Welcome, {{ auth()->user()->name }}
        </h1>
        <p class="text-slate-400">Here is your team & task overview</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">

        {{-- Users --}}
        <div class="stat-card">
            <h3>Total Users</h3>
            <p class="stat-number text-indigo-400">{{ $totalUsers }}</p>
        </div>

        {{-- Total Tasks --}}
        <div class="stat-card">
            <h3>Total Tasks</h3>
            <p class="stat-number text-blue-400">{{ $totalTasks }}</p>
        </div>

        {{-- Pending --}}
        <div class="stat-card">
            <h3>Pending</h3>
            <p class="stat-number text-yellow-400">{{ $pendingTasks }}</p>
        </div>

        {{-- In Progress --}}
        <div class="stat-card">
            <h3>In Progress</h3>
            <p class="stat-number text-orange-400">{{ $inProgressTasks }}</p>
        </div>

        {{-- Completed --}}
        <div class="stat-card">
            <h3>Completed</h3>
            <p class="stat-number text-green-400">{{ $completedTasks }}</p>
        </div>

    </div>

    {{-- Recent Tasks --}}
    <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-lg">
        <div class="p-6 border-b border-slate-700 flex justify-between">
            <h2 class="text-xl font-semibold">Recent Assigned Tasks</h2>
            <a href="{{ route('managers.viewassigntask') }}" class="text-blue-400 text-sm">
                View All
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-900 text-slate-400 text-sm">
                    <tr>
                        <th class="p-4">Title</th>
                        <th class="p-4">Assigned To</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Due</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr class="border-b border-slate-700 hover:bg-slate-700/40">
                            <td class="p-4 font-medium">{{ $task->title }}</td>
                            <td class="p-4">{{ $task->assignedUser->name ?? 'N/A' }}</td>
                            <td class="p-4">
                                <span class="status {{ $task->status }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td class="p-4">
                                {{ $task->due_date ?? 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-slate-500">
                                No tasks yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
.stat-card{
    background:#0f172a;
    border:1px solid #1e293b;
    border-radius:12px;
    padding:20px;
    text-align:center;
    transition:.3s;
}
.stat-card:hover{
    transform:translateY(-4px);
}
.stat-card h3{
    color:#94a3b8;
    font-size:14px;
}
.stat-number{
    font-size:32px;
    font-weight:700;
    margin-top:8px;
}

.status{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
}
.status.pending{ background:#78350f; color:#fde68a; }
.status.in_progress{ background:#1e40af; color:#bfdbfe; }
.status.completed{ background:#064e3b; color:#6ee7b7; }
</style>

@endsection
