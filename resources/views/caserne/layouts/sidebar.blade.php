<!-- Sidebar -->
<aside class="flex flex-col bg-caserne-dark text-white transition-all duration-300 z-20 shadow-2xl relative shrink-0"
    :class="sidebarOpen ? 'w-72' : 'w-24'">

    <!-- Header Logo -->
    <div class="flex items-center justify-center h-24 border-b border-white/5 px-6 relative z-10">
        <div
            class="bg-white/10 backdrop-blur-md rounded-2xl p-2 border border-white/10 shadow-sm shrink-0 transition-all duration-300">
            <div class="bg-white rounded-xl p-1.5 shadow-inner">
                @if (Auth::user()->logo)
                    <img src="{{ asset('storage/' . Auth::user()->logo) }}" alt="Logo"
                        class="w-10 h-10 object-contain rounded-lg">
                @else
                    <div
                        class="w-10 h-10 bg-caserne-dark flex items-center justify-center text-white font-black rounded-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
        </div>
        <div class="ml-4 overflow-hidden transition-all duration-300"
            :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0'">
            <span
                class="block font-black text-sm leading-tight tracking-tighter uppercase truncate w-32">{{ Auth::user()->name }}</span>
            <span class="block text-[10px] text-caserne-red uppercase tracking-[0.2em] font-black">Caserne Active</span>
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-8 px-4 custom-scrollbar relative z-10">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('caserne.dashboard') }}"
                    class="flex items-center px-4 py-4 rounded-2xl transition-all duration-200 group {{ request()->routeIs('caserne.dashboard') ? 'bg-caserne-red text-white shadow-lg shadow-red-900/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <div class="p-1 rounded-lg group-hover:scale-110 transition-transform relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        @php
                            $caserne = Auth::user();

                            $sinistresAssignes = \App\Models\Sinistre::where('assigned_caserne_id', $caserne->id)
                                ->whereIn('status', ['en_attente', 'en_cours'])
                                ->get();

                            $sinistresZone = $caserne->sinistresAssignes()->whereNull('assigned_caserne_id')->get();

                            $interventionsCount = $sinistresAssignes->merge($sinistresZone)->unique('id')->count();
                        @endphp
                        @if ($interventionsCount > 0)
                            <span
                                class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-caserne-red text-[10px] font-black text-white border-2 border-caserne-dark">
                                {{ $interventionsCount }}
                            </span>
                        @endif
                    </div>
                    <span class="ml-4 font-bold text-sm tracking-tight truncate transition-all duration-300"
                        x-show="sidebarOpen">Tableau de bord</span>
                </a>
            </li>

            <!-- Rapports -->
            <li>
                <a href="{{ route('caserne.rapports.index') }}"
                    class="flex items-center px-4 py-4 rounded-2xl transition-all duration-200 group {{ request()->routeIs('caserne.rapports.index') ? 'bg-white/10 text-white shadow-lg' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <div class="p-1 rounded-lg group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="ml-4 font-bold text-sm tracking-tight truncate transition-all duration-300"
                        x-show="sidebarOpen">Rapports</span>
                </a>
            </li>

            <!-- Historique -->
            <li>
                <a href="{{ route('caserne.historique.index') }}"
                    class="flex items-center px-4 py-4 rounded-2xl transition-all duration-200 group {{ request()->routeIs('caserne.historique.index') ? 'bg-white/10 text-white shadow-lg' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <div class="p-1 rounded-lg group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="ml-4 font-bold text-sm tracking-tight truncate transition-all duration-300"
                        x-show="sidebarOpen">Historique</span>
                </a>
            </li>

            <!-- Paramètres -->
            <li>
                <a href="#"
                    class="flex items-center px-4 py-4 rounded-2xl text-slate-400 hover:bg-white/5 hover:text-white transition-all duration-200 group">
                    <div class="p-1 rounded-lg group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span class="ml-4 font-bold text-sm tracking-tight truncate transition-all duration-300"
                        x-show="sidebarOpen">Paramètres</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Help Box -->
    <div class="p-6 relative z-10" x-show="sidebarOpen" x-transition>
        <div class="bg-caserne-red/10 border border-caserne-red/20 rounded-3xl p-5 text-center">
            <div
                class="bg-caserne-red text-white w-10 h-10 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-red-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h4 class="text-sm font-black mb-1 uppercase tracking-tighter">Assistance</h4>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-4 leading-relaxed">Besoin d'aide
                pour vos rapports ?</p>
            <a href="#"
                class="block w-full py-2.5 px-4 bg-white text-caserne-dark text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-caserne-red hover:text-white transition-all shadow-sm">
                Documentation
            </a>
        </div>
    </div>
</aside>
