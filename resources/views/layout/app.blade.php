<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b, #0f172a);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        /* Glass main container */
        .main-wrapper {
            backdrop-filter: blur(18px);
            background: rgba(255, 255, 255, 0.05);
            border-left: 1px solid rgba(255,255,255,0.08);
        }

        /* Smooth scroll */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }

        .content-area {
            min-height: 100vh;
        }
    </style>
</head>

<body>

<div class="flex min-h-screen text-white">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Content Area --}}
    <div class="flex-1 p-10 main-wrapper content-area">
        @yield('content')
    </div>

</div>

</body>
</html>
