@extends('admin.layouts.app')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.sinistre.index') }}" class="p-3 bg-white border border-gray-100 rounded-2xl text-gray-400 hover:text-onpc-blue hover:border-onpc-blue transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 leading-none">Détails de l'alerte <span class="text-onpc-blue">{{ $sinistre->reference ?? '#SN-'.$sinistre->id }}</span></h1>
            <p class="text-gray-500 mt-2 font-medium">Informations complètes sur le sinistre et l'intervention.</p>
        </div>
    </div>
    
    <div class="flex items-center gap-3">
        <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest 
            @if($sinistre->status == 'en_attente' || is_null($sinistre->status)) bg-yellow-100 text-yellow-700 
            @elseif($sinistre->status == 'en_cours') bg-blue-100 text-blue-700 
            @elseif($sinistre->status == 'termine') bg-green-100 text-green-700 
            @else bg-gray-100 text-gray-600 @endif">
            @if($sinistre->status == 'en_attente' || is_null($sinistre->status)) Alerte reçue
            @elseif($sinistre->status == 'en_cours') Intervention en cours
            @elseif($sinistre->status == 'termine') Résolu
            @else {{ $sinistre->status }} @endif
        </span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Informations Principales -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Carte Détails -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="p-8 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-2">Déclarant</label>
                            <p class="text-xl font-bold text-gray-900">{{ $sinistre->nom_complet }}</p>
                            <div class="flex items-center gap-2 mt-2 text-onpc-blue font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $sinistre->contact }}
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-2">Nature de l'incident</label>
                            <div class="inline-flex items-center gap-2 bg-slate-50 border border-slate-100 px-4 py-2 rounded-2xl">
                                <span class="w-3 h-3 rounded-full 
                                    @if($sinistre->type_sinistre == 'incendie') bg-red-500 
                                    @elseif($sinistre->type_sinistre == 'accident') bg-orange-500 
                                    @else bg-blue-500 @endif"></span>
                                <span class="font-black text-gray-800 uppercase text-xs tracking-widest">{{ $sinistre->type_sinistre }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-2">Description</label>
                            <p class="text-gray-600 leading-relaxed font-medium bg-gray-50 p-6 rounded-3xl border border-gray-100">
                                {{ $sinistre->description }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-2">Localisation</label>
                            <div class="bg-blue-50 p-6 rounded-3xl border border-blue-100">
                                <p class="text-blue-900 font-bold flex items-center gap-2">
                                    <svg class="w-5 h-5 text-onpc-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    Position GPS Capturée
                                </p>
                                <p class="text-[11px] text-blue-700/70 mt-1 font-bold">Lat: {{ $sinistre->latitude }} | Long: {{ $sinistre->longitude }}</p>
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $sinistre->latitude }},{{ $sinistre->longitude }}" target="_blank" 
                                   class="mt-4 inline-flex items-center gap-2 bg-onpc-blue text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest hover:scale-[1.02] transition-all">
                                    Voir sur Google Maps
                                </a>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-2">Date et Heure</label>
                            <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <div class="bg-white p-2.5 rounded-xl shadow-sm border border-gray-100">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="font-bold text-gray-700 uppercase text-xs tracking-wider">
                                    Le {{ $sinistre->created_at->format('d F Y') }} à {{ $sinistre->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Galerie Photos -->
        <div class="space-y-4">
            <h3 class="text-sm font-black text-gray-400 uppercase tracking-[0.3em] ml-1">Preuves visuelles</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach(['image1', 'image2', 'image3'] as $imgField)
                    @if($sinistre->$imgField)
                        <div class="group relative bg-white p-3 rounded-[2rem] shadow-lg border border-gray-100 overflow-hidden">
                            <img src="{{ asset('storage/' . $sinistre->$imgField) }}" class="w-full h-48 object-cover rounded-[1.5rem] transition-transform duration-500 group-hover:scale-110">
                            <a href="{{ asset('storage/' . $sinistre->$imgField) }}" target="_blank" class="absolute inset-0 bg-onpc-blue/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <div class="bg-white p-3 rounded-full shadow-xl">
                                    <svg class="w-6 h-6 text-onpc-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Sidebar : Intervention -->
    <div class="space-y-8">
        
        <!-- Caserne Assignée -->
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-[2.5rem] p-8 text-white shadow-2xl">
            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6">Secours en charge</h3>
            @php
                $targetCaserneOrGroup = $sinistre->caserneOrGroup;
            @endphp
            @if($targetCaserneOrGroup)
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/10">
                        <svg class="w-8 h-8 text-onpc-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold">{{ $targetCaserneOrGroup->name }}</p>
                        <p class="text-xs text-gray-400 uppercase tracking-widest mt-0.5">
                            @if($targetCaserneOrGroup->role === 'groupe')
                                Groupe d'intervention
                            @else
                                Caserne notifiée (En attente de groupe)
                            @endif
                        </p>
                    </div>
                </div>
                <div class="space-y-3 pt-6 border-t border-white/5">
                    <div class="flex items-center gap-3 text-sm font-medium">
                        <svg class="w-4 h-4 text-onpc-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        {{ $targetCaserneOrGroup->telephone }}
                    </div>
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/10 border-dashed">
                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Aucune caserne n'a encore pris en charge ce sinistre.</p>
                </div>
            @endif
        </div>

        <!-- Rapport d'intervention -->
        @if($sinistre->status == 'termine')
            <div class="bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-xl shadow-gray-200/50">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6">Bilan de l'intervention</h3>
                
                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div class="text-center p-4 bg-red-50 rounded-2xl border border-red-100">
                        <p class="text-2xl font-black text-red-600">{{ $sinistre->nb_morts }}</p>
                        <p class="text-[8px] font-black text-red-400 uppercase tracking-widest mt-1">Morts</p>
                    </div>
                    <div class="text-center p-4 bg-orange-50 rounded-2xl border border-orange-100">
                        <p class="text-2xl font-black text-orange-600">{{ $sinistre->nb_blesses }}</p>
                        <p class="text-[8px] font-black text-orange-400 uppercase tracking-widest mt-1">Blessés</p>
                    </div>
                    <div class="text-center p-4 bg-blue-50 rounded-2xl border border-blue-100">
                        <p class="text-2xl font-black text-onpc-blue">{{ $sinistre->nb_evacues }}</p>
                        <p class="text-[8px] font-black text-blue-400 uppercase tracking-widest mt-1">Évacués</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block">Rapport complet</label>
                    <p class="text-sm font-medium text-gray-600 leading-relaxed bg-gray-50 p-6 rounded-3xl border border-gray-100 italic">
                        "{{ $sinistre->rapport_intervention }}"
                    </p>
                    <div class="flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest mt-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Clôturé le {{ $sinistre->date_cloture ? \Carbon\Carbon::parse($sinistre->date_cloture)->format('d/m/Y à H:i') : 'N/A' }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
