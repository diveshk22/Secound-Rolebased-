@extends('layout.app')

@section('content')

<style>
    /* ===== Dark Card ===== */
    .card-dark{
        border-radius:16px;
        overflow:hidden;
        background:#0f172a;
        border:1px solid #1e293b;
        box-shadow:0 10px 25px rgba(0,0,0,0.4);
    }

    /* ===== Status Badges ===== */
    .badge{
        padding:6px 14px;
        border-radius:30px;
        font-size:12px;
        font-weight:700;
        letter-spacing:.3px;
        text-transform:uppercase;
        display:inline-block;
    }

    .pending  { background:#78350f; color:#fde68a; }
    .completed{ background:#064e3b; color:#a7f3d0; }
    .uat      { background:#312e81; color:#c7d2fe; }
    .backlog  { background:#7f1d1d; color:#fecaca; }

    /* ===== Table Style ===== */
    .task-table th{
        background:#1e293b;
        color:#e2e8f0;
        font-size:12px;
        letter-spacing:1px;
        text-transform:uppercase;
    }

    .task-table td{
        color:#cbd5e1;
        vertical-align:middle;
    }

    .task-row:hover{
        background:#1e293b;
        transition:0.2s ease;
    }
</style>


<div class="max-w-7xl mx-auto mt-10 px-6 text-slate-200">

    {{-- ===== Title ===== --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold">
            📋 All Tasks
        </h2>
        <p class="text-slate-400 mt-1">Tasks created by Admin / Manager</p>
    </div>


    {{-- ===== Dark Card ===== --}}
    <div class="card-dark">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left task-table">

                {{-- ===== Table Head ===== --}}
                <thead>
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4">Assigned By</th>
                        <th class="px-6 py-4">Assigned To</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Created</th>
                    </tr>
                </thead>

                {{-- ===== Table Body ===== --}}
                <tbody class="divide-y divide-slate-700">

                    @forelse($tasks as $task)
                    <tr class="task-row">

                        <td class="px-6 py-5 font-semibold">
                            #{{ $task->id }}
                        </td>

                        <td class="px-6 py-5 font-bold">
                            {{ $task->title }}
                        </td>

                        <td class="px-6 py-5 max-w-xs truncate">
                            {!! $task->description !!}
                        </td>

                        <td class="px-6 py-5">
                            {{ $task->user->name ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-5">
                            {{ $task->assignedUser->name ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-5">
                            <span class="badge {{ $task->status }}">
                                {{ $task->status }}
                            </span>
                        </td>

                        <td class="px-6 py-5 text-slate-400">
                            {{ $task->created_at->format('d M Y') }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 text-slate-500 text-lg">
                            🚫 No tasks available
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
