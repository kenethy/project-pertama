<!DOCTYPE html>
<html lang="id">
<head>
    <title>@yield('title', 'My Project')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="https://unpkg.com/alpinejs" defer></script>

</head>

<body class ="bg-gray-100">

</body>
<nav>
    


<nav class="bg-white border-gray-200 dark:bg-gray-900">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="{{route ('home')}}" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="{{asset('images/yonopedia.png')}}" class="h-8" alt="Flowbite Logo" />
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Yonopedia</span>
    </a>
    <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
      <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
        <li>
          <a href="{{route ('home')}}" class="block py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500
           dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent md:text-blue-700 md:p-0 dark:text-white {{$activePage === 'home' ? 'md:dark:text-blue-500' : 'md:dark:text-white' }}" aria-current="page">Home</a>
        </li>
        <li>
          <a href="{{route ('etalase')}}" class="block py-2 px-3 {{$activePage === 'etalase' ? 'md:dark:text-blue-500' : 'md:dark:text-white' }} text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500
           dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Katalog</a>
        </li>
       
      </ul>
    </div>
  </div>
</nav>

</nav>

<main>
@yield('content')
</main>

<footer>


<footer class="bg-white rounded-lg shadow-sm dark:bg-gray-900 m-4">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="{{route ('home')}}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <img src="{{asset('images/yonopedia.png')}}" class="h-12 transition-transform duration-200 hover:scale-130" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white transition-transform duration-200 hover:scale-120">Yonopedia</span>
            </a>
            <!-- Perbaikan bagian social icons -->
            <ul class="flex items-center space-x-4">
                <li>
                    <a href="https://github.com/kenethy" target="_blank" class="flex items-center">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733553.png" alt="Github" class="w-12 h-12 transition-transform duration-200 hover:scale-140">
                    </a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/in/yona-as-a0758b296/" target="_blank" class="flex items-center">
                        <img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" alt="LinkedIn" class="w-12 h-12 transition-transform duration-200 hover:scale-140">
                    </a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">
            © 2025 <a href="{{route ('home')}}" class="hover:underline">Yonapedia™</a>. All rights reserved.
        </span>
    </div>
</footer>



</footer>


</body>

