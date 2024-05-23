{{-- 
| ETML
| Autheur : Samuel Dos Santos, FIN2
| Date : 20.05.2024
|
|
| Template de la navbar : https://tailwindui.com/components/application-ui/navigation/navbars
|    
--}}

<!DOCTYPE html>
<html lang="fr" class="h-full">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Freeman&display=swap" rel="stylesheet">
        @vite('resources/css/app.css')
        <title>@yield('title')</title>

        <script>
            // Ensures the code runs only after the entire HTML document have been loaded
            document.addEventListener('DOMContentLoaded', () => {

                // Selecting the elements by their IDs
                const mobileMenuButton  = document.getElementById('mobile-menu-button');
                const mobileMenu        = document.getElementById('mobile-menu');
                const userMenuButton    = document.getElementById('user-menu-button');
                const userMenu          = document.getElementById('user-menu');
                
                // Event listener for when moibleMenuButtoon is clicked
                mobileMenuButton.addEventListener('click',() => {
                    const isExpanded = mobileMenuButton.getAttribute('aria-expanded')=== 'true';
                    mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
                    mobileMenu.classList.toggle('hidden');

                    // Switch between the hamburger and close icons
                    mobileMenuButton.querySelectorAll('svg').forEach(svg => {
                        svg.classList.toggle('hidden');
                    });
                });
                
                // profilwe dropdown menu
                userMenuButton.addEventListener('click', () => {
                    const isExpanded = userMenuButton.getAttribute('aria-expanded') === 'true';
                    userMenuButton.setAttribute('aria-expanded', !isExpanded);
                    userMenu.classList.toggle('hidden');
                });
            
                // Close user menu when clicking outside
                document.addEventListener('click', (event) => {
                    if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) 
                    {
                        userMenuButton.setAttribute('aria-expanded', 'false');
                        userMenu.classList.add('hidden');
                    }
                });
            });
        </script>

    </head>
    <body class="bg-gray-100 font-sans leading-normal tracking-normal flex flex-col min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-10xl px-2 sm:px-6 lg:px-8">
                <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" 
                        aria-controls="mobile-menu" aria-expanded="false" id="mobile-menu-button">

                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <!--
                            Icon when menu is closed.
                
                            Menu open: "hidden", Menu closed: "block"
                        -->
                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!--
                            Icon when menu is open.
                
                            Menu open: "block", Menu closed: "hidden"
                        -->
                        <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        <img class=" h-10 w-auto mr-4" src="{{ asset('SocialShuffleLogo.png') }}" alt="App Logo">
                        <h1 class="text-white text-lg">SocialShuffle</h1>
                    </div>
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <a href="{{ route('team.index') }}" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Liste des équipes</a>
                            <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">À propos</a>
                            <a href="{{ route('team.create') }}" class=" bg-indigo-500 text-white hover:bg-indigo-400 hover:text-white rounded-md px-3 py-2 text-sm font-medium">+ Nouvelle équipe</a>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">            
                    <!-- Profile dropdown -->
                    <div class="relative ml-3">
                    <div>
                        <button type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" 
                            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">Open user menu</span>
                            <a href="" class=" text-white">PROFILE NAME</a>
                        </button>
                    </div>
            
                    <!--
                        Dropdown menu, show/hide based on menu state.
            
                        Entering: "transition ease-out duration-100"
                        From: "transform opacity-0 scale-95"
                        To: "transform opacity-100 scale-100"
                        Leaving: "transition ease-in duration-75"
                        From: "transform opacity-100 scale-100"
                        To: "transform opacity-0 scale-95"
                    -->
                    <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" 
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" id="user-menu">

                        <!-- Active: "bg-gray-100", Not Active: "" -->
                        <a href="#" class="block px-4 py-2 text-sm text-red-500" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            
            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="sm:hidden hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pb-3 pt-2">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <a href="{{ route('team.create') }}" class=" bg-indigo-500 text-white block rounded-md px-3 py-2 mb-6 text-base font-medium" aria-current="page">+ Nouvelle équipe</a>
                    <a href="{{ route('team.index') }}" class="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Liste des équipes</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">À propos</a>
                </div>
            </div>
        </nav>

        <main class="flex-grow container mx-auto p-4">
            @yield('content')
        </main>

        <footer class="bg-gray-800 p-4 rounded-t-3xl">
            <div class="container mx-auto text-center text-white">
                ETML - SocialShuffle - TPI - Samuel Dos Santos
            </div>
        </footer>

    </body>
</html>
