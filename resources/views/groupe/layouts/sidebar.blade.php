@php
    $groupe = Auth::user();
    $interventionsCount = \App\Models\Sinistre::where('assigned_caserne_id', $groupe->id)
        ->where('status', 'en_cours')
        ->count();
@endphp

<!-- Sidebar Groupe -->
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
            <span class="block text-xs text-blue-200 uppercase tracking-wider font-semibold">Espace Groupe</span>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto py-6 px-3 relative z-10">
        <ul class="space-y-1.5">
            <li>
                <a href="{{ route('caserne.groupe.dashboard') }}"
                    class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('caserne.groupe.dashboard') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div
                        class="{{ request()->routeIs('caserne.groupe.dashboard') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200">
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
                <a href="{{ route('caserne.groupe.interventions.index') }}"
                    class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('caserne.groupe.interventions.index') || request()->routeIs('caserne.groupe.interventions.etat-des-lieux.*') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div
                        class="{{ request()->routeIs('caserne.groupe.interventions.index') || request()->routeIs('caserne.groupe.interventions.etat-des-lieux.*') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200 relative">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        @if ($interventionsCount > 0)
                            <span
                                class="absolute -top-2 -right-2 min-w-5 h-5 px-1 rounded-full bg-onpc-orange text-white text-[10px] font-black flex items-center justify-center border border-white/30">
                                {{ $interventionsCount }}
                            </span>
                        @endif
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300"
                        x-show="sidebarOpen">Intervention</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/caserne/groupe/interventions-terminees') }}"
                    class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group {{ request()->is('caserne/groupe/interventions-terminees') ? 'bg-white/20 text-white shadow-sm border border-white/10' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <div
                        class="{{ request()->is('caserne/groupe/interventions-terminees') ? 'bg-onpc-orange' : 'bg-white/10' }} p-1.5 rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 shrink-0 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium truncate transition-all duration-300"
                        x-show="sidebarOpen">Interventions terminées</span>
                </a>
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
            <p class="text-xs text-blue-200 mb-3">Contactez votre caserne de rattachement.</p>
            <a href="#"
                class="block w-full py-2 px-4 bg-onpc-orange hover:bg-orange-600 text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                Assistance
            </a>
        </div>
    </div>
</aside>
