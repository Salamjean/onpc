<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
    @forelse($sinistres as $sinistre)
        <div class="alert-card glass-card rounded-[2.8rem] overflow-hidden group">
            <!-- Status Header -->
            <div class="px-8 py-6 flex justify-between items-center border-b border-slate-200/50 
                @if($sinistre->status == 'en_attente' || is_null($sinistre->status)) bg-red-50/50 @else bg-blue-50/50 @endif">
                <div class="flex items-center gap-3">
                    <div class="w-3.5 h-3.5 rounded-full @if($sinistre->status == 'en_attente' || is_null($sinistre->status)) bg-red-500 pulse-orange @else bg-onpc-blue @endif"></div>
                    <span class="text-[11px] font-black uppercase tracking-widest text-slate-800">
                        @if($sinistre->status == 'en_attente' || is_null($sinistre->status)) Alerte Prioritaire @else En intervention @endif
                    </span>
                </div>
                <span class="text-[10px] font-black text-slate-400 font-mono tracking-tighter">REF: {{ $sinistre->reference }}</span>
            </div>

            <div class="p-8">
                <!-- Main Content -->
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 rounded-full bg-slate-100 text-[10px] font-black text-slate-500 uppercase tracking-widest border border-slate-200/50">{{ $sinistre->type_sinistre }}</span>
                        @if($sinistre->declarations_count > 1)
                            <span class="px-3 py-1 rounded-full bg-red-500 text-white text-[10px] font-black uppercase tracking-widest flex items-center gap-1.5 shadow-lg shadow-red-500/20 animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                {{ $sinistre->declarations_count }} Signalements
                            </span>
                        @endif
                        <span class="text-[10px] font-bold text-slate-400 italic">Reçu il y a {{ $sinistre->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 mb-6">
                        <!-- Location -->
                        <div class="flex-1 flex items-start gap-3 bg-slate-50/50 p-4 rounded-3xl border border-slate-100">
                            <div class="onpc-gradient-blue p-2.5 rounded-xl shadow-lg shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Localisation</p>
                                <h2 class="text-base font-black text-slate-900 leading-tight tracking-tight group-hover:text-onpc-blue transition-colors line-clamp-1">{{ $sinistre->lieu ?? 'GPS Uniquement' }}</h2>
                            </div>
                        </div>

                        <!-- Unité Engagée -->
                        @if($sinistre->status == 'en_cours' && $sinistre->caserneAssignee)
                            <div class="flex-1 flex items-start gap-3 bg-white p-4 rounded-3xl shadow-xl shadow-blue-900/5 border-2 border-onpc-blue">
                                <div class="bg-onpc-orange p-2.5 rounded-xl shadow-lg shrink-0 mt-0.5">
                                    <span class="text-base">🚒</span>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-onpc-blue uppercase tracking-widest mb-0.5">Unité sur le terrain</p>
                                    <h2 class="text-base font-black text-slate-900 uppercase tracking-tight line-clamp-1">{{ $sinistre->caserneAssignee->name }}</h2>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-slate-50/80 p-5 rounded-3xl border border-slate-200/50 relative overflow-hidden group-hover:bg-white transition-colors duration-300">
                        <div class="absolute left-0 top-0 w-1 h-full bg-onpc-orange opacity-20"></div>
                        <p class="text-sm font-semibold text-slate-600 leading-relaxed italic">"{{ $sinistre->description }}"</p>
                    </div>
                </div>

                <!-- Footer / CTA -->
                <div class="flex items-center gap-4">
                    <!-- GPS (Primary) -->
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $sinistre->latitude }},{{ $sinistre->longitude }}" target="_blank"
                        class="flex-1 flex items-center justify-center gap-3 onpc-gradient-orange text-white py-5 rounded-[1.8rem] text-xs font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-orange-900/20 hover:shadow-orange-900/40 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Itinéraire GPS
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="lg:col-span-3 py-48 text-center">
            <div class="inline-flex p-10 bg-white/50 backdrop-blur-md rounded-[4rem] border border-white/40 mb-8 shadow-inner">
                <svg class="w-20 h-20 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <h3 class="text-4xl font-black text-slate-300 uppercase tracking-tighter">Secteur Pacifié</h3>
            <p class="text-slate-400 font-bold text-sm mt-4 uppercase tracking-[0.4em]">Veille active - Aucune alerte</p>
        </div>
    @endforelse
</div>
