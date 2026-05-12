<!-- Sidebar -->
<aside
    class="flex flex-col bg-gradient-to-b from-[#0000cc] to-[#000066] text-white transition-all duration-300 z-20 shadow-2xl relative"
    :class="sidebarOpen ? 'w-72' : 'w-20'">

    <!-- Decorative element -->
    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 rounded-full bg-white opacity-5 pointer-events-none">
    </div>

    <!-- Logo -->
    <div class="flex items-center justify-center h-24 border-b border-white/10 px-4 relative z-10">
        <div
            class="bg-white/10 backdrop-blur-md rounded-xl p-1.5 border border-white/20 shadow-sm shrink-0 transition-all duration-300">
            <div class="bg-white rounded-lg p-1">
                <img src="{{ asset('assets/images/logo_onpc.png') }}" alt="ONPC" class="w-10 h-10 object-contain">
            </div>
        </div>
        <div class="ml-4 overflow-hidden transition-all duration-300"
            :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0'">
            <span class="block font-bold text-lg leading-tight tracking-wide">ONPC</span>
            <span class="block text-xs text-blue-200 uppercase tracking-wider font-semibold">Administration</span>
        </div>
    </div>

    <!-- Links -->
    <div class="flex-1 overflow-y-auto py-6 px-3 custom-scrollbar relative z-10">
        <ul class="space-y-1.5">
            <!-- Tableau de bord -->
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div
                        class="{{ request()->routeIs('admin.dashboard') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300" x-show="sidebarOpen">Tableau de
                        bord</span>
                </a>
            </li>



            <!-- Sinistres -->
            <li class="mt-2">
                <a href="{{ route('admin.sinistre.index') }}"
                    class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.sinistre.index') || request()->routeIs('admin.sinistre.show') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div
                        class="{{ request()->routeIs('admin.sinistre.*') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200 relative">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        @php
                            $sinistresNonTermines = \App\Models\Sinistre::where('status', '!=', 'termine')->count();
                        @endphp
                        @if ($sinistresNonTermines > 0)
                            <span
                                class="absolute -top-2 -right-2 min-w-5 h-5 px-1 rounded-full bg-onpc-orange text-white text-[10px] font-black flex items-center justify-center border border-white/30">
                                {{ $sinistresNonTermines }}
                            </span>
                        @endif
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300"
                        x-show="sidebarOpen">Sinistres</span>
                </a>
            </li>

            <!-- Historique Sinistres -->
            <li>
                <a href="{{ route('admin.sinistre.historique') }}"
                    class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.sinistre.historique') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div
                        class="{{ request()->routeIs('admin.sinistre.historique') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300"
                        x-show="sidebarOpen">Historique</span>
                </a>
            </li>

            {{-- <li>
                <a href="#" class="flex items-center px-3 py-3 rounded-xl text-blue-100 hover:bg-white/5 hover:text-white transition-all duration-200 group">
                    <div class="p-1.5 rounded-lg group-hover:bg-white/10 transition-colors duration-200">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300" x-show="sidebarOpen">Utilisateurs</span>
                </a>
            </li> --}}

            <!-- Statistiques -->
            <li>
                <a href="{{ route('admin.statistique.index') }}"
                    class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.statistique.*') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div
                        class="{{ request()->routeIs('admin.statistique.*') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300"
                        x-show="sidebarOpen">Statistiques</span>
                </a>
            </li>

            <!-- Casernes (Menu déroulant) -->
            @php $caserneActive = request()->routeIs('admin.caserne.*'); @endphp
            <li x-data="{ open: {{ $caserneActive ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-3 py-3 rounded-xl transition-all duration-200 group focus:outline-none {{ $caserneActive ? 'bg-white/10 text-white' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center">
                        <div
                            class="p-1.5 rounded-lg {{ $caserneActive ? 'bg-onpc-orange/20' : 'group-hover:bg-white/10' }} transition-colors duration-200">
                            <svg class="w-5 h-5 shrink-0 {{ $caserneActive ? 'text-onpc-orange' : '' }}" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <span class="ml-3 font-medium truncate transition-all duration-300"
                            x-show="sidebarOpen">Casernes</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                        x-show="sidebarOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <!-- Sous-menus -->
                <ul x-show="open && sidebarOpen" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0" class="mt-1 space-y-1 pl-11 pr-3"
                    :style="open ? '' : 'display: none;'">
                    <li>
                        <a href="{{ route('admin.caserne.create') }}"
                            class="block px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.caserne.create') ? 'text-white font-bold bg-white/10' : 'text-blue-200 hover:text-white hover:bg-white/5' }}">
                            Ajouter
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.caserne.index') }}"
                            class="block px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.caserne.index') ? 'text-white font-bold bg-white/10' : 'text-blue-200 hover:text-white hover:bg-white/5' }}">
                            Listes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.caserne.archived') }}"
                            class="block px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.caserne.archived') ? 'text-white font-bold bg-white/10' : 'text-blue-200 hover:text-white hover:bg-white/5' }}">
                            Archivés
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Structures -->
            <li>
                <a href="{{ route('admin.structure.index') }}"
                    class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.structure.*') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div
                        class="{{ request()->routeIs('admin.structure.*') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300"
                        x-show="sidebarOpen">Structures</span>
                </a>
            </li>


        </ul>
    </div>

    <!-- Support / Aide -->
    <div class="p-4 relative z-10" x-show="sidebarOpen" x-transition>
        <div class="bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl p-4 text-center">
            <div
                class="bg-onpc-orange/20 text-onpc-orange w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h4 class="text-sm font-semibold mb-1">Besoin d'aide ?</h4>
            <p class="text-xs text-blue-200 mb-3">Consultez la documentation.</p>
            <a href="#"
                class="block w-full py-2 px-4 bg-onpc-orange hover:bg-orange-600 text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                Documentation
            </a>
        </div>
    </div>
</aside>
