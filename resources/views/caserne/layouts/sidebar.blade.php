@php
    $caserne = Auth::user();
    $sinistresEnAttente = \App\Models\Sinistre::where('status', 'en_attente')
        ->whereHas('casernes', function ($query) use ($caserne) {
            $query->where('users.id', $caserne->id);
        })
        ->count();
@endphp

<!-- Sidebar -->
<aside class="flex flex-col text-white transition-all duration-300 z-20 shadow-2xl relative"
    style="background: linear-gradient(to bottom, #0000cc, #000066);" :class="sidebarOpen ? 'w-72' : 'w-20'">

    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 rounded-full bg-white opacity-5 pointer-events-none">
    </div>

    <div class="flex items-center justify-center h-24 border-b border-white/10 px-4 relative z-10">
        <div
            class="bg-white/10 backdrop-blur-md rounded-xl p-1.5 border border-white/20 shadow-sm shrink-0 transition-all duration-300">
            <div class="bg-white rounded-lg p-1">
                @if (Auth::user()->logo)
                    <img src="{{ asset('storage/' . Auth::user()->logo) }}" alt="Logo"
                        class="w-10 h-10 object-contain rounded-md">
                @else
                    <img src="{{ asset('assets/images/logo_onpc.png') }}" alt="ONPC"
                        class="w-10 h-10 object-contain">
                @endif
            </div>
        </div>
        <div class="ml-4 overflow-hidden transition-all duration-300"
            :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0'">
            <span
                class="block font-bold text-base leading-tight tracking-wide truncate max-w-[150px]">{{ Auth::user()->name }}</span>
            <span class="block text-xs text-blue-200 uppercase tracking-wider font-semibold">Espace Caserne</span>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto py-6 px-3 relative z-10">
        <ul class="space-y-1.5">
            <li>
                <a href="{{ route('caserne.dashboard') }}"
                    class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('caserne.dashboard') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div
                        class="{{ request()->routeIs('caserne.dashboard') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200 relative">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300" x-show="sidebarOpen">Tableau de
                        bord</span>
                </a>
            </li>

            <li>
                <a href="{{ route('caserne.sinistres.index') }}"
                    class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('caserne.sinistres.*') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div
                        class="{{ request()->routeIs('caserne.sinistres.*') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200 relative">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        @if ($sinistresEnAttente > 0)
                            <span
                                class="absolute -top-2 -right-2 min-w-5 h-5 px-1 rounded-full bg-onpc-orange text-white text-[10px] font-black flex items-center justify-center border border-white/30">
                                {{ $sinistresEnAttente }}
                            </span>
                        @endif
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300"
                        x-show="sidebarOpen">Sinistres</span>
                </a>
            </li>

            <li>
                <a href="{{ route('caserne.historique.index') }}"
                    class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('caserne.historique.*') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div
                        class="{{ request()->routeIs('caserne.historique.*') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300"
                        x-show="sidebarOpen">Historique</span>
                </a>
            </li>

            <li>
                <a href="{{ route('caserne.assistance', Auth::user()->url_name) }}" target="_blank"
                    class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group text-orange-200 hover:bg-white/10 hover:text-white border border-dashed border-white/20 mt-4 bg-white/5">
                    <div class="bg-onpc-orange p-1.5 rounded-lg shadow-lg group-hover:scale-110 transition-transform duration-200 relative">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-white rounded-full animate-ping"></span>
                    </div>
                    <span class="ml-3 font-bold truncate transition-all duration-300 uppercase text-[11px] tracking-widest"
                        x-show="sidebarOpen">Assistance <span class="text-[8px] bg-red-500 px-1 rounded ml-1">LIVE</span></span>
                </a>
            </li>

            <li x-data="{ openGroupe: {{ request()->routeIs('caserne.groupes.*') ? 'true' : 'false' }} }">
                <button type="button" @click="openGroupe = !openGroupe"
                    class="w-full flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('caserne.groupes.*') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div
                        class="{{ request()->routeIs('caserne.groupes.*') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-1a4 4 0 00-5-3.87M17 20H7m10 0v-1c0-1.657-1.343-3-3-3H10c-1.657 0-3 1.343-3 3v1m0 0H2v-1a4 4 0 015-3.87M9 7a3 3 0 106 0 3 3 0 00-6 0zm8 1a2 2 0 11-4 0 2 2 0 014 0zM7 8a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300 flex-1 text-left"
                        x-show="sidebarOpen">Groupe</span>
                    <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform"
                        :class="openGroupe ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="openGroupe && sidebarOpen" x-transition
                    class="mt-2 ml-4 space-y-1.5 bg-white/5 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                    <a href="{{ route('caserne.groupes.create') }}"
                        class="flex items-center px-3 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-200 {{ request()->routeIs('caserne.groupes.create') ? 'bg-onpc-orange text-white shadow-md' : 'text-blue-100 hover:bg-white/15 hover:text-white' }}">
                        <svg class="w-4 h-4 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span>Ajouter</span>
                    </a>
                    <a href="{{ route('caserne.groupes.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-200 {{ request()->routeIs('caserne.groupes.index') ? 'bg-onpc-orange text-white shadow-md' : 'text-blue-100 hover:bg-white/15 hover:text-white' }}">
                        <svg class="w-4 h-4 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3">
                            </path>
                        </svg>
                        <span>Listes</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>

    <div class="p-4 relative z-10" x-show="sidebarOpen" x-transition>
        <div class="bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl p-4 text-center">
            <div
                class="bg-onpc-orange/20 text-onpc-orange w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
