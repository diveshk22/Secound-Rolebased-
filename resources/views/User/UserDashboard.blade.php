    @extends('layout.app')

    @section('content')

    <div class="min-h-screen bg-slate-900 py-10 px-6">
        {{-- Welcome Header --}}
        <div class="max-w-7xl mx-auto mb-10">
            <div class="bg-black rounded-2xl shadow-xl p-8 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-white">
                        Welcome, {{ auth()->user()->name }} 👋
                    </h2>

                    <p class="mt-3 text-lg text-white">
                        Role:
                        <span class="px-4 py-1 rounded-full text-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600">
                        {{ auth()->user()->getRoleNames()->first() }}
                        </span>
                    </p>
                </div>

                <a href="{{ route('profile.edit') }}" class="hover:scale-105 transition">
                    <img src="{{ auth()->user()->photo ? asset('profile_photos/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=4f46e5&color=fff&size=50' }}" 
                        alt="Profile" 
                        class="rounded-full border-2 border-white/20 hover:border-white/40 transition object-cover"
                        style="width: 68px; height: 68px;">
                </a>
            </div>
        </div>

        {{-- Dashboard Intro --}}
        <div class="max-w-5xl mx-auto mb-12">
            <div class="bg-white/10 backdrop-blur-xl border border-white/10
                        rounded-3xl p-12 text-center text-white shadow-2xl">
                <h1 class="text-5xl font-extrabold mb-4 tracking-wide">
                    Dashboard
                </h1>
                <p class="text-gray-300 text-lg">
                    Everything you need is right here. Fast, clean and beautiful interface.
                </p>
            </div>
        </div>

        {{-- Task Summary --}}
        <!-- die($e); -->
        <div class="max-w-5xl mx-auto mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-8 text-white shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Total Tasks</h3>
                            <p class="text-4xl font-bold">{{ $totalTasksCount }}</p>
                        </div>
                        <div class="text-blue-200">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-8 text-white shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Pending Tasks</h3>
                            <p class="text-4xl font-bold">{{ $pendingTasksCount }}</p>
                        </div>
                        <div class="text-orange-200">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h4 class="text-white text-center">Rejected Tasks</h4>
            <p class="text-center text-gray-300">{{ $rejectedTasksCount }}
            </p>
        </div>



    </div>

    @endsection
