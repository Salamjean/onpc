<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSTE DE COMMANDEMENT LIVE - Caserne ONPC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #0f172a; 
            min-height: screen;
        }
        .onpc-gradient-blue { background: linear-gradient(135deg, #0000cc 0%, #000066 100%); }
        .onpc-gradient-orange { background: linear-gradient(135deg, #ff8300 0%, #e67600 100%); }
        .glass-card { 
            background: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .pulse-orange { animation: pulse 2s infinite; }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(255, 131, 0, 0.6); }
            70% { box-shadow: 0 0 0 15px rgba(255, 131, 0, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 131, 0, 0); }
        }
        .alert-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .alert-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 204, 0.15);
        }
    </style>
</head>
<body class="p-6 md:p-10">

    <!-- Top Bar / Command Center Header -->
    <header class="onpc-gradient-blue p-8 rounded-[3rem] shadow-2xl mb-10 flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full -ml-32 -mt-32"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-onpc-orange/10 rounded-full -mr-32 -mb-32"></div>

        <div class="flex items-center gap-6 relative z-10">
            <div class="bg-white p-3.5 rounded-2xl shadow-xl">
                <img src="{{ asset('assets/images/logo_onpc.png') }}" alt="Logo" class="w-12 h-12 object-contain">
            </div>
            <div class="text-white">
                <h1 class="text-3xl font-black tracking-tighter uppercase leading-none">Poste de Commandement <span class="text-onpc-orange">Live</span></h1>
                <div class="flex items-center gap-3 mt-2 text-blue-100/70">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-black bg-onpc-orange text-white uppercase tracking-widest">Opérationnel</span>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em]">{{ $caserne->name }}</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-6 relative z-10">
            <div class="text-right">
                <p class="text-[9px] font-black text-blue-200 uppercase tracking-[0.3em] mb-1">Actualisation</p>
                <div class="flex items-center gap-3">
                    <span class="text-2xl font-black text-white font-mono tracking-wider" id="clock">{{ now()->format('H:i:s') }}</span>
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></div>
                </div>
            </div>
            <div class="w-px h-12 bg-white/10 hidden md:block"></div>
            <div class="bg-white/10 backdrop-blur-md rounded-3xl px-8 py-3 border border-white/10 shadow-inner">
                <p class="text-[9px] font-black text-blue-100 uppercase tracking-[0.2em] mb-1 text-center">Alertes Actives</p>
                <p class="text-3xl font-black text-white text-center">{{ count($sinistres) }}</p>
            </div>
        </div>
    </header>

    <!-- Alert Grid -->
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

    <!-- Live Badge / Control Bar -->
    <div class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white px-10 py-5 rounded-full shadow-[0_20px_50px_rgba(0,0,0,0.3)] flex items-center gap-10 z-50 border border-white/10">
        <div class="flex items-center gap-4">
            <div class="w-3 h-3 bg-red-500 rounded-full animate-ping"></div>
            <span class="text-[11px] font-black uppercase tracking-[0.2em] text-blue-200">Live Monitor v2.0</span>
        </div>
        <div class="h-6 w-px bg-white/10"></div>
        <div class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-400">
            Auto-Sync: <span class="text-onpc-orange font-mono text-lg ml-2" id="countdown">10s</span>
        </div>
    </div>

    <script>
        let timeLeft = 10;
        const countdownEl = document.getElementById('countdown');
        
        setInterval(() => {
            timeLeft--;
            countdownEl.innerText = timeLeft + 's';
            if(timeLeft <= 0) {
                location.reload();
            }
        }, 1000);

        // Update clock
        setInterval(() => {
            const now = new Date();
            const timeStr = now.getHours().toString().padStart(2, '0') + ':' + 
                          now.getMinutes().toString().padStart(2, '0') + ':' + 
                          now.getSeconds().toString().padStart(2, '0');
            document.getElementById('clock').innerText = timeStr;
        }, 1000);

        // Sound alert if new incident
        const currentCount = {{ count($sinistres) }};
        const lastCount = localStorage.getItem('last_sinistre_count');
        
        if (lastCount !== null && currentCount > parseInt(lastCount)) {
            const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
            audio.play().catch(e => console.log('Audio bloqué'));
        }
        localStorage.setItem('last_sinistre_count', currentCount);
    </script>
</body>
</html>
