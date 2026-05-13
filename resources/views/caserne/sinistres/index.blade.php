{{-- Liste des sinistres en attente --}}
@extends('caserne.layouts.app')

@section('content')
    <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight uppercase">
                Sinistres <span class="text-caserne-red">En Attente / Récupérés</span>
            </h1>
            <p class="text-slate-500 mt-3 font-bold text-xs uppercase tracking-widest">
                Liste des declarations en attente et de celles déjà récupérées par un groupe
            </p>
        </div>

        <div class="bg-white px-6 py-4 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total</p>
            <p class="text-3xl font-black text-slate-900 mt-2">{{ $sinistres->total() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-4xl p-4 md:p-6 shadow-xl shadow-slate-200/50 border border-slate-100">
        <div class="overflow-x-auto rounded-3xl border border-slate-100">
            <table class="w-full text-left border-separate border-spacing-y-2 min-w-[900px]">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">
                        <th class="px-6 py-4 text-center">ID / Date</th>
                        <th class="px-6 py-4 text-center">Déclarant</th>
                        <th class="px-6 py-4 text-center">Type Sinistre</th>
                        <th class="px-6 py-4 text-center">Localisation</th>
                        <th class="px-6 py-4 text-center">Statut</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sinistres as $sinistre)
                        <tr
                            class="bg-white hover:bg-slate-50 transition-all group shadow-sm rounded-3xl ring-1 ring-slate-100">
                            <td class="px-6 py-5 text-center">
                                <div class="flex flex-col">
                                    <span
                                        class="font-black text-slate-900 text-sm">{{ $sinistre->reference ?? '#SN-' . $sinistre->id }}</span>
                                    <span
                                        class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-wider">{{ $sinistre->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="font-bold text-slate-800">{{ $sinistre->nom_complet }}</span>
                                    <a href="tel:{{ $sinistre->contact }}"
                                        class="text-onpc-blue font-black text-xs mt-1 hover:underline">
                                        {{ $sinistre->contact }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-100 text-slate-700">
                                    {{ $sinistre->type_sinistre }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex flex-col items-center">
                                    <span
                                        class="text-xs font-bold text-slate-600 italic">{{ $sinistre->lieu ?? ($sinistre->latitude . ', ' . $sinistre->longitude) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @if ($sinistre->status === 'en_cours' && $sinistre->caserneAssignee)
                                    <span
                                        class="inline-flex flex-col items-center gap-1 px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-700">
                                        <span class="inline-flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            <span class="text-[10px] font-black uppercase tracking-widest">Récupéré</span>
                                        </span>
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-wider text-emerald-700">{{ $sinistre->caserneAssignee->name }}</span>
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 text-slate-700">
                                        <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                                        <span class="text-[10px] font-black uppercase tracking-widest">En attente</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-center">
                                <a href="{{ route('caserne.sinistre.show', $sinistre) }}"
                                    class="inline-flex items-center justify-center bg-caserne-dark hover:bg-slate-700 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:shadow-md">
                                    Voir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center">
                                <div class="flex flex-col items-center opacity-30">
                                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="font-black uppercase tracking-widest">Aucun sinistre en attente ou récupéré
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $sinistres->links() }}
        </div>
    </div>
@endsection
