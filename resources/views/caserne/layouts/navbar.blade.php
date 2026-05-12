<header class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-slate-200 z-10 transition-all duration-300">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <!-- Bouton Menu Mobile / Toggle Sidebar -->
            <div class="flex items-center">
                <button @click.stop="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-caserne-red p-2 rounded-xl hover:bg-slate-100 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center space-x-4">
                
                <!-- Notifications -->
                <button class="relative p-2.5 text-slate-400 hover:text-caserne-red hover:bg-slate-100 rounded-xl transition-all">
                    <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-caserne-red rounded-full border-2 border-white"></span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </button>

                <div class="h-8 w-[1px] bg-slate-200 mx-2"></div>

                <!-- User Profile Dropdown -->
                <div class="relative" x-data="{ userOpen: false }">
                    <button @click="userOpen = !userOpen" @click.away="userOpen = false" class="flex items-center gap-3 p-1.5 pr-3 rounded-2xl hover:bg-slate-100 transition-all group">
                        <div class="h-10 w-10 rounded-xl bg-caserne-dark text-white flex items-center justify-center font-bold shadow-lg shadow-slate-200 group-hover:scale-105 transition-transform">
                            @if(Auth::user()->logo)
                                <img src="{{ asset('storage/' . Auth::user()->logo) }}" alt="Logo" class="h-full w-full object-cover rounded-xl">
                            @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-sm font-bold text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-wider">Caserne Opérationnelle</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-caserne-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="userOpen" x-transition class="absolute right-0 mt-3 w-56 bg-white border border-slate-100 rounded-3xl shadow-2xl shadow-slate-200/50 p-2 z-50">
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-caserne-red transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Mon Profil
                        </a>
                        <div class="my-2 border-t border-slate-50"></div>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold text-red-600 hover:bg-red-50 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
