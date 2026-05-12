<!-- Sidebar -->
<aside class="flex flex-col h-full bg-gradient-to-b from-[#0000cc] to-[#000066] text-white transition-all duration-300 shadow-2xl relative w-72">
    
    <!-- Decorative element -->
    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 rounded-full bg-white opacity-5 pointer-events-none"></div>

    <!-- Logo -->
    <div class="flex items-center justify-center h-24 border-b border-white/10 px-4 relative z-10">
        <div class="bg-white/10 backdrop-blur-md rounded-xl p-1.5 border border-white/20 shadow-sm shrink-0 transition-all duration-300">
            <div class="bg-white rounded-lg p-1">
                <img src="{{ asset('assets/images/logo_onpc.png') }}" alt="ONPC" class="w-10 h-10 object-contain">
            </div>
        </div>
        <div class="ml-4 overflow-hidden transition-all duration-300">
            <span class="block font-bold text-lg leading-tight tracking-wide truncate max-w-[160px]">{{ Auth::guard('structure')->user()->nom }}</span>
            <span class="block text-xs text-blue-200 uppercase tracking-wider font-semibold">Portail Partenaire</span>
        </div>
    </div>

    <!-- Links -->
    <div class="flex-1 overflow-y-auto py-6 px-3 custom-scrollbar relative z-10">
        <ul class="space-y-1.5">
            <!-- Tableau de bord -->
            <li>
                <a href="{{ route('structure.dashboard') }}" 
                   class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('structure.dashboard') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div class="{{ request()->routeIs('structure.dashboard') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300">Tableau de bord</span>
                </a>
            </li>

            <!-- Déclarer un sinistre -->
            <li>
                <a href="{{ route('structure.sinistre.create') }}" 
                   class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('structure.sinistre.create') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div class="{{ request()->routeIs('structure.sinistre.create') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300">Lancer une alerte</span>
                </a>
            </li>

            <!-- Liste des déclarations -->
            <li>
                <a href="{{ route('structure.sinistre.index') }}" 
                   class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('structure.sinistre.index') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div class="{{ request()->routeIs('structure.sinistre.index') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300">Mes déclarations</span>
                </a>
            </li>

            <!-- Ressources -->
            <li>
                <a href="#" class="flex items-center px-3 py-3 rounded-xl text-blue-100 hover:bg-white/5 hover:text-white transition-all duration-200 group">
                    <div class="p-1.5 rounded-lg group-hover:bg-white/10 transition-colors duration-200">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300">Ressources</span>
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Déconnexion -->
    <div class="p-4 relative z-10">
        <form action="{{ route('structure.auth.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center px-3 py-3 rounded-xl text-red-200 hover:bg-red-500/20 hover:text-white transition-all duration-200 group">
                <div class="p-1.5 rounded-lg bg-red-500/10 group-hover:bg-red-500 transition-colors duration-200">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </div>
                <span class="ml-3 font-medium truncate transition-all duration-300">Déconnexion</span>
            </button>
        </form>
    </div>
</aside>
