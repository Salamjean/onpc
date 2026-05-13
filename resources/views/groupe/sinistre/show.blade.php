@extends('groupe.layouts.app')

@section('content')
    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('caserne.groupe.dashboard') }}"
                class="p-3 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-onpc-orange hover:shadow-lg transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Détails de l'incident <span
                        class="text-onpc-orange">#SN-{{ $sinistre->id }}</span></h1>
                <p class="text-slate-500 font-bold text-xs uppercase tracking-widest flex items-center gap-2 mt-1">
                    <span class="w-2 h-2 rounded-full bg-onpc-orange animate-pulse"></span>
                    Déclaré le {{ $sinistre->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>
        </div>

        <div class="px-8 py-4 bg-slate-50 border border-slate-100 rounded-2xl">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest leading-none">Statut actuel</p>
            <p class="text-sm font-bold text-slate-700 mt-1 uppercase">
                @if ($sinistre->status == 'en_cours')
                    En cours
                @elseif($sinistre->status == 'termine')
                    Terminé
                @else
                    En attente
                @endif
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Informations Principales -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Carte de description -->
            <div class="bg-white rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/50 border border-slate-100">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-onpc-orange">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Rapport de situation</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <div class="p-6 bg-slate-50 rounded-3xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Déclarant</p>
                        <p class="text-lg font-bold text-slate-900">{{ $sinistre->nom_complet }}</p>
                        <p class="text-onpc-orange font-black mt-1">{{ $sinistre->contact }}</p>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-3xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Type d'incident</p>
                        <p class="text-lg font-bold text-slate-900 uppercase tracking-tight">{{ $sinistre->type_sinistre }}
                        </p>
                        <p class="text-slate-500 text-xs font-bold mt-1">Gravité : Urgent</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Description citoyenne
                    </p>
                    <div
                        class="p-8 bg-slate-50 rounded-4xl border border-slate-100 italic text-slate-600 font-medium leading-relaxed">
                        "{{ $sinistre->description }}"
                    </div>
                </div>
            </div>

            <!-- Galerie Photos -->
            <div class="bg-white rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/50 border border-slate-100">
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-8">Photos du terrain</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="aspect-square rounded-3xl overflow-hidden shadow-lg shadow-slate-200">
                        <img src="{{ asset('storage/' . $sinistre->image1) }}"
                            class="w-full h-full object-cover hover:scale-110 transition-transform duration-500 cursor-zoom-in"
                            onclick="window.open(this.src)">
                    </div>
                    @if ($sinistre->image2)
                        <div class="aspect-square rounded-3xl overflow-hidden shadow-lg shadow-slate-200">
                            <img src="{{ asset('storage/' . $sinistre->image2) }}"
                                class="w-full h-full object-cover hover:scale-110 transition-transform duration-500 cursor-zoom-in"
                                onclick="window.open(this.src)">
                        </div>
                    @endif
                    @if ($sinistre->image3)
                        <div class="aspect-square rounded-3xl overflow-hidden shadow-lg shadow-slate-200">
                            <img src="{{ asset('storage/' . $sinistre->image3) }}"
                                class="w-full h-full object-cover hover:scale-110 transition-transform duration-500 cursor-zoom-in"
                                onclick="window.open(this.src)">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Navigation et Actions -->
        <div class="space-y-8">
            <div
                class="bg-onpc-blue rounded-[2.5rem] p-10 shadow-2xl shadow-slate-900/20 text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-onpc-orange opacity-10 rounded-full -mr-16 -mt-16 blur-2xl">
                </div>

                <h3 class="text-xl font-black uppercase tracking-tight mb-8 relative z-10">Localisation</h3>

                <div class="space-y-6 relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-onpc-orange">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Localisation précise
                            </p>
                            <p class="text-sm font-bold mt-1 text-white">
                                {{ $sinistre->lieu ?? $sinistre->latitude . ', ' . $sinistre->longitude }}</p>
                        </div>
                    </div>

                    <div class="p-6 bg-white/5 rounded-3xl border border-white/10">
                        <p class="text-xs font-bold text-slate-300">L'incident est situé à environ <span
                                class="text-onpc-orange font-black">{{ number_format($sinistre->casernes()->where('user_id', $caserne->id)->first()->pivot->distance ?? 0, 2) }}
                                KM</span> de votre groupe.</p>
                    </div>

                    <!-- Google Maps Navigation Button -->
                    <a href="https://www.google.com/maps/dir/?api=1&origin={{ $groupe->latitude }},{{ $groupe->longitude }}&destination={{ $sinistre->latitude }},{{ $sinistre->longitude }}&travelmode=driving"
                        target="_blank"
                        class="flex items-center justify-center gap-3 w-full bg-onpc-orange hover:bg-white hover:text-onpc-orange text-white py-5 rounded-3xl font-black text-sm uppercase tracking-widest transition-all shadow-xl shadow-orange-900/40">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A2 2 0 013 15.488V5.111a2 2 0 012.553-1.91l6.447 2.149 6.447-2.149A2 2 0 0121 5.111v10.377a2 2 0 01-1.553 1.91L14 20l-5 2z">
                            </path>
                        </svg>
                        Lancer l'itinéraire
                    </a>
                </div>
            </div>

            @if ($sinistre->status === 'en_attente' && $sinistre->assigned_caserne_id !== $groupe->id)
                <form action="{{ route('caserne.groupe.sinistre.claim', $sinistre) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-3 bg-onpc-blue hover:bg-blue-900 text-white py-5 rounded-3xl font-black text-sm uppercase tracking-widest transition-all shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z">
                            </path>
                        </svg>
                        Démarrer l'intervention
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
