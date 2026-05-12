@extends('admin.layouts.app')

@section('content')

{{-- Header --}}
<div class="mb-8">
    <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Tableau de bord</h1>
    <p class="text-slate-400 mt-1 font-medium">Vue d'ensemble de la plateforme ONPC.</p>
</div>

{{-- ── Cartes statistiques ── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    {{-- Total --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-onpc-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Total</span>
        </div>
        <p class="text-4xl font-black text-slate-900">{{ $totalSinistres }}</p>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Sinistres déclarés</p>
    </div>

    {{-- En attente --}}
    <div class="bg-white rounded-3xl shadow-sm border border-red-100 p-6 relative overflow-hidden">
        @if($enAttente > 0)
        <div class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 rounded-full animate-ping"></div>
        <div class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 rounded-full"></div>
        @endif
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-4xl font-black text-red-600">{{ $enAttente }}</p>
        <p class="text-[10px] font-black text-red-400 uppercase tracking-widest mt-1">Non traités</p>
    </div>

    {{-- En cours --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-onpc-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-4xl font-black text-slate-900">{{ $enCours }}</p>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">En intervention</p>
    </div>

    {{-- Résolus --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-4xl font-black text-slate-900">{{ $resolus }}</p>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Résolus</p>
    </div>
</div>

{{-- ── Corps principal ── --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- ---- Déclarations non traitées (2/3) ---- --}}
    <div class="xl:col-span-2">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

            {{-- Header table --}}
            <div class="px-8 py-5 border-b border-slate-50 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center {{ $enAttente > 0 ? 'bg-red-50' : 'bg-slate-50' }}">
                        @if($enAttente > 0)
                        <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                        @else
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Déclarations en attente</h2>
                        <p class="text-[9px] text-slate-400 font-bold">Interventions non encore assignées</p>
                    </div>
                </div>
                @if($enAttente > 0)
                <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 border border-red-100 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                    {{ $enAttente }} urgentes
                </span>
                @else
                <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-600 border border-green-100 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest">
                    ✓ Tout est traité
                </span>
                @endif
            </div>

            {{-- Table --}}
            @if($sinistresNonTraites->isEmpty())
            <div class="py-20 flex flex-col items-center justify-center text-center px-8">
                <div class="w-20 h-20 rounded-full bg-green-50 flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Aucune déclaration en attente</p>
                <p class="text-xs text-slate-300 mt-1">Toutes les alertes ont été prises en charge.</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-[9px] font-black text-slate-400 uppercase tracking-[0.15em] border-b border-slate-50">
                            <th class="py-4 px-8 text-left">Référence</th>
                            <th class="py-4 px-4 text-left">Type</th>
                            <th class="py-4 px-4 text-left">Lieu</th>
                            <th class="py-4 px-4 text-left">Source</th>
                            <th class="py-4 px-4 text-left">Date</th>
                            <th class="py-4 px-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($sinistresNonTraites as $sinistre)
                        <tr class="hover:bg-red-50/30 transition-colors group">
                            <td class="py-4 px-8">
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                                    <span class="text-xs font-black text-slate-800">{{ $sinistre->reference ?? 'N/A' }}</span>
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 bg-orange-50 text-onpc-orange border border-orange-100 rounded-lg text-[9px] font-black uppercase tracking-tight">
                                    {{ Str::limit($sinistre->type_sinistre, 16) }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <p class="text-xs font-bold text-slate-600 truncate max-w-[120px]">{{ $sinistre->lieu ?? '—' }}</p>
                            </td>
                            <td class="py-4 px-4">
                                @if($sinistre->structure)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-onpc-blue border border-blue-100 rounded-lg text-[9px] font-black">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                                        {{ Str::limit($sinistre->structure->nom, 14) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 text-slate-500 border border-slate-100 rounded-lg text-[9px] font-black">
                                        Citoyen
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <p class="text-[10px] font-bold text-slate-400">{{ $sinistre->created_at->format('d/m H:i') }}</p>
                                <p class="text-[9px] text-slate-300">{{ $sinistre->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.sinistre.show', $sinistre) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-onpc-blue text-white rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-slate-900 transition-all hover:scale-105 shadow-lg shadow-blue-900/10">
                                    Voir
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($enAttente > 10)
            <div class="px-8 py-4 border-t border-slate-50 flex justify-end">
                <a href="{{ route('admin.sinistre.index') }}" class="text-[9px] font-black text-onpc-blue hover:text-onpc-orange uppercase tracking-widest transition-colors">
                    Voir les {{ $enAttente - 10 }} autres →
                </a>
            </div>
            @endif
            @endif
        </div>
    </div>

    {{-- ---- Colonne droite (1/3) ---- --}}
    <div class="space-y-6">

        {{-- Structures --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-5">Structures partenaires</h3>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-5xl font-black text-onpc-blue">{{ $totalStructures }}</p>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Enregistrées</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-black text-green-500">{{ $structuresActive }}</p>
                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Actives</p>
                </div>
            </div>
            <div class="mt-4 h-2 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-onpc-blue to-onpc-orange rounded-full transition-all"
                     style="width: {{ $totalStructures > 0 ? ($structuresActive / $totalStructures * 100) : 0 }}%"></div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.structure.index') }}" class="flex items-center justify-between text-[9px] font-black text-slate-400 uppercase tracking-widest hover:text-onpc-blue transition-colors">
                    <span>Gérer les structures</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>

        {{-- Raccourcis --}}
        <div class="bg-gradient-to-br from-onpc-blue to-slate-900 rounded-3xl p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-6 -mr-6 w-24 h-24 bg-onpc-orange/20 rounded-full blur-2xl pointer-events-none"></div>
            <h3 class="text-[10px] font-black uppercase tracking-widest text-blue-200 mb-5 relative z-10">Actions rapides</h3>
            <div class="relative z-10 space-y-3">
                <a href="{{ route('admin.sinistre.index') }}" class="flex items-center gap-3 bg-white/10 hover:bg-white/20 border border-white/10 rounded-2xl px-4 py-3.5 transition-all hover:translate-x-1">
                    <div class="w-8 h-8 rounded-xl bg-onpc-orange/20 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-onpc-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-white">Tous les sinistres</span>
                </a>
                <a href="{{ route('admin.structure.create') }}" class="flex items-center gap-3 bg-white/10 hover:bg-white/20 border border-white/10 rounded-2xl px-4 py-3.5 transition-all hover:translate-x-1">
                    <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-white">Ajouter une structure</span>
                </a>
                <a href="{{ route('admin.caserne.create') }}" class="flex items-center gap-3 bg-white/10 hover:bg-white/20 border border-white/10 rounded-2xl px-4 py-3.5 transition-all hover:translate-x-1">
                    <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-white">Ajouter une caserne</span>
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
