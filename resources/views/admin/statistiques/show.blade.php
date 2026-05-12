@extends('admin.layouts.app')

@section('content')
    <div class="mb-8 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.statistique.index') }}"
                class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-slate-500 flex items-center justify-center hover:text-onpc-blue transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Statistiques globales</h1>
                <p class="text-slate-400 mt-1 font-medium">{{ $user->name }} - Vue consolidée des sinistres</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total sinistres</p>
            <p class="text-4xl font-black text-slate-900 mt-2">{{ $totalSinistres }}</p>
        </div>
        <div class="bg-white rounded-3xl shadow-sm border border-orange-100 p-6">
            <p class="text-[10px] font-black text-orange-400 uppercase tracking-widest">En attente</p>
            <p class="text-4xl font-black text-orange-600 mt-2">{{ $enAttente }}</p>
        </div>
        <div class="bg-white rounded-3xl shadow-sm border border-blue-100 p-6">
            <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">En cours</p>
            <p class="text-4xl font-black text-onpc-blue mt-2">{{ $enCours }}</p>
        </div>
        <div class="bg-white rounded-3xl shadow-sm border border-green-100 p-6">
            <p class="text-[10px] font-black text-green-400 uppercase tracking-widest">Terminés</p>
            <p class="text-4xl font-black text-green-600 mt-2">{{ $termines }}</p>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5 text-center">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Morts</p>
            <p class="text-3xl font-black text-slate-900 mt-2">{{ $nbMorts }}</p>
        </div>
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5 text-center">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Blessés</p>
            <p class="text-3xl font-black text-slate-900 mt-2">{{ $nbBlesses }}</p>
        </div>
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5 text-center">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Evacués</p>
            <p class="text-3xl font-black text-slate-900 mt-2">{{ $nbEvacues }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <h2 class="text-sm font-black text-slate-700 uppercase tracking-widest">Derniers sinistres de la caserne</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] border-b border-slate-100">
                        <th class="py-4 px-6 text-left">Référence</th>
                        <th class="py-4 px-4 text-left">Type</th>
                        <th class="py-4 px-4 text-left">Statut</th>
                        <th class="py-4 px-4 text-left">Date</th>
                        <th class="py-4 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($latestSinistres as $sinistre)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6 text-xs font-black text-slate-800">
                                {{ $sinistre->reference ?? '#SN-' . $sinistre->id }}</td>
                            <td class="py-4 px-4 text-xs font-bold text-slate-700">{{ $sinistre->type_sinistre }}</td>
                            <td class="py-4 px-4">
                                <span
                                    class="px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-tight
                                @if ($sinistre->status === 'termine') bg-green-100 text-green-600
                                @elseif($sinistre->status === 'en_cours') bg-blue-100 text-blue-600
                                @else bg-orange-100 text-orange-600 @endif">
                                    {{ str_replace('_', ' ', $sinistre->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-[10px] font-bold text-slate-500">
                                {{ $sinistre->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.sinistre.show', $sinistre) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-onpc-blue text-white rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-slate-900 transition-colors">
                                    Voir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="py-14 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Aucun sinistre trouvé pour cette caserne</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
