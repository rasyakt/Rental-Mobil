<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rental Mobil Premium')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <!-- FontAwesome 6 for professional icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --primary: #dc2626;      /* Crimson Red */
            --primary-dark: #b91c1c; 
            --primary-light: #fef2f2;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            @apply bg-gray-50 text-slate-900;
        }
        
        /* Premium Components */
        .btn-primary {
            @apply px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl transition duration-300 font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5;
        }
        .btn-secondary {
            @apply px-6 py-3 bg-white hover:bg-gray-50 text-slate-700 rounded-xl transition duration-300 font-bold border border-gray-200 shadow-sm hover:shadow-md;
        }
        .btn-outline {
            @apply px-6 py-3 border-2 border-red-600 text-red-600 hover:bg-red-600 hover:text-white rounded-xl transition duration-300 font-bold;
        }
        .hero-gradient {
            @apply bg-linear-to-br from-red-600 via-red-700 to-red-900;
        }
        .card-hover {
            @apply hover:shadow-xl hover:-translate-y-1 transition duration-300 border border-transparent hover:border-gray-100;
        }
        .glass-panel {
            @apply bg-white/80 backdrop-blur-md border border-white/40 shadow-sm;
        }
        
        /* Badges */
        .badge-success {
            @apply px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold tracking-wide uppercase;
        }
        .badge-warning {
            @apply px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold tracking-wide uppercase;
        }
        .badge-danger {
            @apply px-3 py-1 bg-rose-100 text-rose-800 rounded-full text-xs font-bold tracking-wide uppercase;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased animate-fade-in text-slate-800">
    @yield('content')
    @stack('scripts')
</body>
</html>
