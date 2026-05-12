@extends('caserne.layouts.app')

@section('content')
    <div class="mb-10 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">
                Rapports <span class="text-caserne-red">Effectues</span>
            </h1>
            <p class="text-slate-500 mt-2 font-bold text-xs uppercase tracking-widest">
                Tous les rapports de cloture rediges par votre caserne
            </p>
        </div>
        <div class="bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total</p>
            <p class="text-xl font-black text-caserne-red leading-none mt-1">{{ $rapports->total() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] p-6 shadow-xl shadow-slate-200/50 border border-slate-100">
        <div class="overflow-x-auto rounded-3xl border border-slate-100">
            <table class="w-full text-left border-separate border-spacing-y-2 min-w-[980px]">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">
                        <th class="px-6 py-4 text-center">Reference</th>
                        <th class="px-6 py-4 text-center">Type</th>
                        <th class="px-6 py-4 text-center">Bilan</th>
                        <th class="px-6 py-4 text-center">Date de cloture</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rapports as $sinistre)
                        <tr
                            class="bg-white hover:bg-slate-50 transition-all group shadow-sm rounded-3xl ring-1 ring-slate-100">
                            <td class="px-6 py-5 first:rounded-l-4xl text-center">
                                <div class="font-black text-slate-900 text-sm">
                                    {{ $sinistre->reference ?? '#SN-' . $sinistre->id }}
                                </div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase mt-1 tracking-wider">
                                    {{ $sinistre->nom_complet }}</div>
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
                                <div class="grid grid-cols-3 gap-2 max-w-xs mx-auto">
                                    <div class="bg-slate-100 rounded-xl px-3 py-2 text-center">
                                        <p class="text-[9px] font-black text-slate-400 uppercase">Morts</p>
                                        <p class="text-sm font-black text-slate-900">{{ $sinistre->nb_morts ?? 0 }}</p>
                                    </div>
                                    <div class="bg-slate-100 rounded-xl px-3 py-2 text-center">
                                        <p class="text-[9px] font-black text-slate-400 uppercase">Blesses</p>
                                        <p class="text-sm font-black text-slate-900">{{ $sinistre->nb_blesses ?? 0 }}</p>
                                    </div>
                                    <div class="bg-slate-100 rounded-xl px-3 py-2 text-center">
                                        <p class="text-[9px] font-black text-slate-400 uppercase">Evacues</p>
                                        <p class="text-sm font-black text-slate-900">{{ $sinistre->nb_evacues ?? 0 }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span
                                    class="text-sm font-bold text-slate-700">{{ optional($sinistre->date_cloture)->format('d/m/Y H:i') ?? '-' }}</span>
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
                                <p class="font-black text-slate-400 uppercase tracking-widest">Aucun rapport enregistre</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $rapports->links() }}
        </div>
    </div>
@endsection
