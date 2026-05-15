<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Animal Haven')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
        }
    </style>
</head>

<body class="bg-orange-50/50 text-gray-800">

    {{-- Navbar --}}
    @include('components.navbar')

    <div class="max-w-7xl mx-auto flex justify-between mt-6 px-4">

        {{-- Left Sidebar --}}
        @include('components.left-sidebar')

        {{-- Main Content --}}
        <main class="w-full lg:w-1/2 px-2">
            @yield('content')
        </main>

        {{-- Right Sidebar --}}
        @include('components.right-sidebar')

    </div>

</body>
</html>