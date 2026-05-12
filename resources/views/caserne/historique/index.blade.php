@extends('caserne.layouts.app')

@section('content')
    <div class="mb-10 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">
                Historique <span class="text-caserne-red">Sinistres Termines</span>
            </h1>
            <p class="text-slate-500 mt-2 font-bold text-xs uppercase tracking-widest">
                Liste complete des interventions cloturees par votre caserne
            </p>
        </div>
        <div class="bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total</p>
            <p class="text-xl font-black text-caserne-red leading-none mt-1">{{ $sinistres->total() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] p-6 shadow-xl shadow-slate-200/50 border border-slate-100">
        <div class="overflow-x-auto rounded-3xl border border-slate-100">
            <table class="w-full text-left border-separate border-spacing-y-2 min-w-[980px]">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">
                        <th class="px-6 py-4 text-center">Reference / Date</th>
                        <th class="px-6 py-4 text-center">Declarant</th>
                        <th class="px-6 py-4 text-center">Type</th>
                        <th class="px-6 py-4 text-center">Statut</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sinistres as $sinistre)
                        <tr
                            class="bg-white hover:bg-slate-50 transition-all group shadow-sm rounded-3xl ring-1 ring-slate-100">
                            <td class="px-6 py-5 first:rounded-l-4xl text-center">
                                <div class="font-black text-slate-900 text-sm">
                                    {{ $sinistre->reference ?? '#SN-' . $sinistre->id }}
                                </div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase mt-1 tracking-wider">
                                    {{ optional($sinistre->date_cloture)->format('d/m/Y H:i') ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="font-bold text-slate-800">{{ $sinistre->nom_complet }}</div>
                                <div class="text-xs text-slate-500">{{ $sinistre->contact }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest
                                @if ($sinistre->type_sinistre == 'incendie') bg-red-100 text-red-600
                                @elseif($sinistre->type_sinistre == 'accident') bg-orange-100 text-orange-600
                                @else bg-blue-100 text-blue-600 @endif">
                                    {{ $sinistre->type_sinistre }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span
                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-700">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Termine</span>
                                </span>
                            </td>
                            <td class="px-6 py-5 last:rounded-r-4xl text-center">
                                <a href="{{ route('caserne.sinistre.show', $sinistre) }}"
                                    class="inline-flex items-center gap-2 bg-caserne-dark hover:bg-slate-700 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:shadow-md">
                                    Voir details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center">
                                <p class="font-black text-slate-400 uppercase tracking-widest">Aucun sinistre termine</p>
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
