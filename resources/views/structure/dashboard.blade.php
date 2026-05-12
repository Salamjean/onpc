@extends('structure.layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-onpc-blue uppercase tracking-tight">Tableau de bord</h1>
        <p class="text-gray-500 mt-2 font-medium">Bienvenue sur votre espace partenaire, <span class="font-bold text-slate-800">{{ $structure->nom }}</span>.</p>
    </div>

    <!-- Cartes statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Carte 1 -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg transition-shadow">
            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-onpc-blue mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest leading-none mb-1">Total Déclarations</h3>
                <p class="text-3xl font-black text-gray-800">{{ $stats['total'] }}</p>
            </div>
        </div>

        <!-- Carte 2 -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg transition-shadow">
            <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-onpc-orange mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest leading-none mb-1">Alertes Actives</h3>
                <p class="text-3xl font-black text-gray-800">{{ $stats['en_cours'] }}</p>
            </div>
        </div>

        <!-- Carte 3 -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg transition-shadow">
            <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-green-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest leading-none mb-1">Alertes Résolues</h3>
                <p class="text-3xl font-black text-gray-800">{{ $stats['resolus'] }}</p>
            </div>
        </div>
    </div>

    <!-- Section contenu principal -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
            <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Activités Récentes</h2>
            <div class="w-2 h-2 rounded-full bg-onpc-orange animate-pulse"></div>
        </div>
        <div class="p-0">
            @if($recentSinistres->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Référence</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Type / Lieu</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Statut</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($recentSinistres as $sinistre)
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-4 font-black text-sm text-slate-900">{{ $sinistre->reference }}</td>
                                    <td class="px-8 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-xs text-slate-700">{{ $sinistre->type_sinistre }}</span>
                                            <span class="text-[10px] text-slate-400 font-medium italic truncate max-w-[200px]">{{ $sinistre->lieu }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-4">
                                        @php
                                            $statusColors = [
                                                'en_attente' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                'en_cours'   => 'bg-orange-50 text-orange-600 border-orange-100',
                                                'resolu'     => 'bg-green-50 text-green-600 border-green-100',
                                                'termine'    => 'bg-slate-50 text-slate-600 border-slate-100',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $statusColors[$sinistre->status] ?? 'bg-slate-50 text-slate-500 border-slate-100' }}">
                                            {{ str_replace('_', ' ', $sinistre->status) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-right">
                                        <a href="{{ route('structure.sinistre.show', $sinistre) }}" class="inline-flex items-center gap-2 text-onpc-blue font-black text-[10px] uppercase tracking-widest hover:underline">
                                            Suivre
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-20 p-12">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <p class="text-gray-400 font-bold uppercase text-[10px] tracking-[0.2em]">Aucune mission récente à afficher.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
