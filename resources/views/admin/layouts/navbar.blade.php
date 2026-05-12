<header class="sticky top-0 bg-white/80 backdrop-blur-lg border-b border-gray-100 z-30 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)]">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 -mb-px">
            
            <!-- Left side -->
            <div class="flex items-center">
                <!-- Hamburger button -->
                <button class="text-gray-400 hover:text-onpc-orange focus:outline-none focus:ring-2 focus:ring-onpc-orange/50 rounded-lg p-2 transition-colors bg-gray-50/50" @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                    <span class="sr-only">Menu</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                </button>
                
                <!-- Page Title -->
                <h2 class="ml-4 text-xl font-bold text-gray-800 hidden sm:block">
                    <!-- On pourrait injecter le titre dynamiquement ici -->
                    Espace Administrateur
                </h2>
            </div>

            <!-- Right side -->
            <div class="flex items-center space-x-4">
                
                <!-- Notification Button -->
                <button class="relative text-gray-400 hover:text-onpc-blue transition-colors p-2 rounded-full hover:bg-blue-50 focus:outline-none">
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </button>

                <!-- Divider -->
                <div class="w-px h-8 bg-gray-200 hidden sm:block"></div>

                <!-- User Profile Dropdown -->
                <div class="relative inline-flex" x-data="{ open: false }">
                    <button class="inline-flex justify-center items-center group focus:outline-none" aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open">
                        <img class="w-10 h-10 rounded-full object-cover border-2 border-gray-100 group-hover:border-onpc-orange transition-colors shadow-sm" src="https://ui-avatars.com/api/?name=Admin+ONPC&background=0000cc&color=fff&bold=true" alt="Admin" />
                        <div class="flex items-center truncate ml-3 hidden md:flex">
                            <span class="truncate text-sm font-semibold text-gray-700 group-hover:text-onpc-orange transition-colors">Admin ONPC</span>
                            <svg class="w-4 h-4 shrink-0 ml-1 text-gray-400 group-hover:text-onpc-orange transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="origin-top-right z-10 absolute top-full right-0 min-w-[200px] bg-white border border-gray-100 py-2 rounded-2xl shadow-xl overflow-hidden mt-2"
                         x-show="open"
                         x-transition:enter="transition ease-out duration-200 transform"
                         x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.outside="open = false"
                         style="display: none;">
                        <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50">
                            <p class="text-sm font-medium text-gray-900 truncate">Administrateur</p>
                            <p class="text-xs text-gray-500 truncate mt-0.5">admin@onpc.ci</p>
                        </div>
                        <ul class="py-2">
                            <li>
                                <a class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-onpc-orange transition-colors" href="#">
                                    <svg class="mr-3 h-4 w-4 text-gray-400 group-hover:text-onpc-orange transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Mon Profil
                                </a>
                            </li>
                            <li>
                                <a class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-onpc-orange transition-colors" href="#">
                                    <svg class="mr-3 h-4 w-4 text-gray-400 group-hover:text-onpc-orange transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Paramètres
                                </a>
                            </li>
                        </ul>
                        <div class="border-t border-gray-100 pt-1">
                            <form method="POST" action="{{ route('admin.logout') }}" x-data>
                                @csrf
                                <a class="group flex items-center px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors" 
                                   href="#" @click.prevent="$root.submit();">
                                    <svg class="mr-3 h-4 w-4 text-red-500 group-hover:text-red-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Se déconnecter
                                </a>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
