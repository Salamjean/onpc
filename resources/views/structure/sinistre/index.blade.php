@extends('structure.layouts.app')

@section('content')

{{-- Header --}}
<div class="mb-8 flex items-center justify-between">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Portail / Historique</span>
        </div>
        <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Mes <span class="text-onpc-blue">Déclarations</span></h1>
    </div>
    <a href="{{ route('structure.sinistre.create') }}" 
       class="bg-onpc-orange hover:bg-orange-600 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-orange-500/20 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Nouvelle Alerte
    </a>
</div>

{{-- Statistiques Rapides --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Déclarations</p>
        <p class="text-2xl font-black text-slate-900">{{ $sinistres->total() }}</p>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1">En attente</p>
        <p class="text-2xl font-black text-blue-600">{{ $sinistres->where('status', 'en_attente')->count() }}</p>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <p class="text-[10px] font-black text-orange-500 uppercase tracking-widest mb-1">En cours</p>
        <p class="text-2xl font-black text-orange-600">{{ $sinistres->where('status', 'en_cours')->count() }}</p>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <p class="text-[10px] font-black text-green-500 uppercase tracking-widest mb-1">Terminées</p>
        <p class="text-2xl font-black text-green-600">{{ $sinistres->whereIn('status', ['resolu', 'termine'])->count() }}</p>
    </div>
</div>

{{-- Liste des déclarations --}}
<div class="bg-white rounded-[1.5rem] md:rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100 border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-4 md:px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-left">Référence</th>
                        <th class="px-4 md:px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-left">Type / Lieu</th>
                        <th class="hidden md:table-cell px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-left">Date</th>
                        <th class="px-4 md:px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-left">Statut</th>
                        <th class="hidden lg:table-cell px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-left">Caserne</th>
                        <th class="px-4 md:px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($sinistres as $sinistre)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-5">
                        <span class="font-black text-slate-900 text-sm">{{ $sinistre->reference }}</span>
                    </td>
                    <td class="px-4 md:px-6 py-5">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-800 text-sm">{{ $sinistre->type_sinistre }}</span>
                            <span class="text-[10px] text-slate-400 font-medium italic">{{ $sinistre->lieu ?? ($sinistre->latitude . ', ' . $sinistre->longitude) }}</span>
                        </div>
                    </td>
                    <td class="hidden md:table-cell px-6 py-5 text-sm font-medium text-slate-500">
                        {{ $sinistre->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-4 md:px-6 py-5">
                        @php
                            $statusColors = [
                                'en_attente' => 'bg-blue-50 text-blue-600 border-blue-100',
                                'en_cours'   => 'bg-orange-50 text-orange-600 border-orange-100',
                                'resolu'     => 'bg-green-50 text-green-600 border-green-100',
                                'termine'    => 'bg-slate-50 text-slate-600 border-slate-100',
                            ];
                            $statusLabels = [
                                'en_attente' => 'En attente',
                                'en_cours'   => 'En cours',
                                'resolu'     => 'Résolu',
                                'termine'    => 'Terminé',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $statusColors[$sinistre->status] ?? 'bg-slate-50 text-slate-500 border-slate-100' }}">
                            {{ $statusLabels[$sinistre->status] ?? $sinistre->status }}
                        </span>
                    </td>
                    <td class="hidden lg:table-cell px-6 py-5">
                        @php
                            $targetSecours = $sinistre->caserneOrGroup;
                        @endphp
                        @if($targetSecours)
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                <span class="text-xs font-bold text-slate-700">{{ $targetSecours->name }}</span>
                            </div>
                        @else
                            <span class="text-[10px] font-bold text-slate-400 italic">Recherche de secours...</span>
                        @endif
                    </td>
                    <td class="px-4 md:px-6 py-5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('structure.sinistre.show', $sinistre) }}" 
                               class="flex items-center gap-2 px-3 md:px-4 py-2 bg-slate-100 hover:bg-onpc-blue hover:text-white rounded-xl transition-all text-slate-600 font-black text-[10px] uppercase tracking-widest">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span class="hidden sm:inline">Suivre</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-200">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-400">Aucune déclaration effectuée pour le moment.</p>
                            <a href="{{ route('structure.sinistre.create') }}" class="text-onpc-blue font-black text-xs uppercase tracking-widest hover:underline">Lancer une alerte maintenant</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($sinistres->hasPages())
    <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
        {{ $sinistres->links() }}
    </div>
    @endif
</div>

@endsection
