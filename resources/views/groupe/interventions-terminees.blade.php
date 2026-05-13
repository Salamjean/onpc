@extends('groupe.layouts.app')

@section('content')
    <div class="mb-8 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight uppercase">
                Interventions <span class="text-onpc-orange">Terminées</span>
            </h1>
            <p class="text-slate-500 mt-3 font-bold text-xs flex items-center gap-2 uppercase tracking-widest">
                <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                Historique des sinistres clôturés par le groupe
            </p>
        </div>

        <div class="bg-white px-6 py-4 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Interventions terminées</p>
            <p class="text-3xl font-black text-slate-900 mt-2">{{ $interventionsTermineesCount }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Groupe</p>
            <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $groupe->name }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Caserne de rattachement</p>
            <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $caserne ? $caserne->name : 'Non rattache' }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Statut</p>
            <p class="text-2xl font-extrabold text-slate-900 mt-2">Clôturées</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 p-4 md:p-6">
        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Historique des interventions</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">Liste des sinistres terminés par le groupe</p>
            </div>
        </div>

        <div class="overflow-x-auto rounded-3xl border border-slate-100">
            <table class="w-full text-left border-separate border-spacing-y-2 min-w-[900px]">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">
                        <th class="px-6 py-4 text-center">Référence</th>
                        <th class="px-6 py-4 text-center">Déclarant</th>
                        <th class="px-6 py-4 text-center">Type</th>
                        <th class="px-6 py-4 text-center">Clôturée le</th>
                        <th class="px-6 py-4 text-center">Statut</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sinistres as $sinistre)
                        <tr
                            class="bg-white hover:bg-slate-50 transition-all group shadow-sm rounded-3xl ring-1 ring-slate-100">
                            <td class="px-6 py-5 text-center">
                                <span
                                    class="font-black text-slate-900 text-sm">{{ $sinistre->reference ?? '#SN-' . $sinistre->id }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="font-bold text-slate-800">{{ $sinistre->nom_complet }}</span>
                                    <span class="text-xs font-semibold text-slate-500">{{ $sinistre->contact }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-100 text-slate-700">
                                    {{ $sinistre->type_sinistre }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span
                                    class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ optional($sinistre->date_cloture)->format('d/m/Y H:i') ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span
                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-700">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Terminée</span>
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('caserne.groupe.interventions.completed.show', $sinistre) }}"
                                        class="inline-flex items-center justify-center bg-onpc-blue hover:bg-blue-800 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:shadow-md">
                                        Voir
                                    </a>
                                    <a href="{{ route('caserne.groupe.interventions.completed.pdf', $sinistre) }}"
                                        class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:shadow-md">
                                        PDF
                                    </a>
                                </div>
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
                                    <p class="font-black uppercase tracking-widest">Aucune intervention terminée</p>
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
