<!DOCTYPE html>
<html lang="id">
<head>
    <title>@yield('title', 'My Project')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<!-- Impor Font Montserrat -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">



</head>

<body class="bg-black flex flex-col min-h-screen overflow-x-hidden">

    <!-- Navbar -->
   <!-- Navbar -->
<nav class="bg-gray-900 border-b border-gray-700 shadow-md">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{route ('home')}}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{asset('images/yonopedia.png')}}" class="h-15" alt="Yonopedia Logo" />
            <span class="self-center text-2xl font-semibold text-white">Yonowatch</span>
        </a>
        <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-400 rounded-lg md:hidden hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-700 rounded-lg bg-gray-800 md:flex-row md:space-x-1 rtl:space-x-reverse md:mt-0 md:border-0">
                <li>
                    <a href="{{route ('home')}}" class="block py-2 px-3 text-white hover:bg-gray-700 rounded-md transition {{$activePage === 'home' ? 'bg-gray-700' : ''}}" aria-current="page">Home</a>
                </li>
                <li>
                    <a href="{{route ('etalase')}}" class="block py-2 px-3 text-white hover:bg-gray-700 rounded-md transition {{$activePage === 'etalase' ? 'bg-gray-700' : ''}}">Katalog</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <!-- Konten Utama -->
    <main class="flex-1 container mx-auto px-4 py-8 ">
        @yield('content')
    </main>

    <!-- Footer Sticky -->
   <!-- Footer -->
<footer class="bg-gray-900 border-b shadow-md w-full py-6 mt-auto">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="{{route ('home')}}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <img src="{{asset('images/yonopedia.png')}}" class="h-12 transition-transform duration-200 hover:scale-110" alt="Yonopedia Logo" />
                <span class="self-center text-2xl font-semibold text-white transition-transform duration-200 hover:scale-105">Yonowatch</span>
            </a>
            <ul class="flex items-center space-x-4">
                <li>
                    <a href="https://github.com/kenethy" target="_blank">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733553.png" alt="Github" class="w-10 h-10 transition-transform duration-200 hover:scale-110">
                    </a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/in/yona-as-a0758b296/" target="_blank">
                        <img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" alt="LinkedIn" class="w-10 h-10 transition-transform duration-200 hover:scale-110">
                    </a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-600 sm:mx-auto" />
        <p class="text-center text-sm text-gray-400">
            © 2025 <a href="{{route ('home')}}" class="hover:underline text-white">Yonopedia™</a>. All rights reserved.
        </p>
    </div>
</footer>


</body>
</html>
<style>
.container {
  padding-left: 0.5rem;
  padding-right: 0.5rem;
}

    </style>