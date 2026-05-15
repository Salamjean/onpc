@extends('admin.layouts.app')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-500">
                Historique des sinistres terminés</h1>
            <p class="text-gray-500 mt-2 font-medium">Consultez tous les sinistres clôturés.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                <span class="text-xs font-bold text-gray-600 uppercase tracking-widest">{{ $sinistres->total() }}
                    Terminés</span>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-8">
        <form action="{{ route('admin.sinistre.historique') }}" method="GET"
            class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nature du
                        sinistre</label>
                    <select name="type"
                        class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-onpc-blue/20 outline-none transition-all">
                        <option value="">Tous les types</option>
                        <option value="incendie" {{ request('type') == 'incendie' ? 'selected' : '' }}>Incendie / Feu
                        </option>
                        <option value="accident" {{ request('type') == 'accident' ? 'selected' : '' }}>Accident de la route
                        </option>
                        <option value="inondation" {{ request('type') == 'inondation' ? 'selected' : '' }}>Inondation /
                            Crues</option>
                        <option value="medical" {{ request('type') == 'medical' ? 'selected' : '' }}>Urgence Médicale
                        </option>
                        <option value="autre" {{ request('type') == 'autre' ? 'selected' : '' }}>Autre Sinistre</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Date précise</label>
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-onpc-blue/20 outline-none transition-all">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Caserne</label>
                    <select name="caserne_id"
                        class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-onpc-blue/20 outline-none transition-all">
                        <option value="">Toutes les casernes</option>
                        @foreach ($casernes as $caserne)
                            <option value="{{ $caserne->id }}"
                                {{ request('caserne_id') == $caserne->id ? 'selected' : '' }}>
                                {{ $caserne->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.sinistre.historique') }}"
                    class="bg-gray-100 text-gray-600 p-3.5 rounded-2xl hover:bg-gray-200 transition-all shadow-sm"
                    title="Réinitialiser">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                </a>
                <button type="submit"
                    class="bg-onpc-blue text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg shadow-onpc-blue/20 hover:bg-blue-700 transition-all">Filtrer</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-onpc-blue/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100">
                        <th class="py-5 px-8 font-bold text-xs uppercase tracking-wider text-gray-500 text-left">ID / Date
                        </th>
                        <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-gray-500">Déclarant</th>
                        <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-gray-500">Type</th>
                        <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-gray-500">Caserne Assignée</th>
                        <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-gray-500">Statut</th>
                        <th class="py-5 px-8 font-bold text-xs uppercase tracking-wider text-gray-500 text-right">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($sinistres as $sinistre)
                        <tr class="hover:bg-green-50/40 transition-all duration-200 group">
                            <td class="py-5 px-8 text-left">
                                <div class="flex flex-col">
                                    <span
                                        class="font-black text-gray-900">{{ $sinistre->reference ?? '#SN-' . $sinistre->id }}</span>
                                    <span
                                        class="text-[10px] font-bold text-gray-400 mt-1 uppercase">{{ $sinistre->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="flex flex-col items-center">
                                    <span
                                        class="text-sm font-bold text-gray-700 leading-none">{{ $sinistre->nom_complet }}</span>
                                    <span
                                        class="text-[11px] text-onpc-blue font-bold mt-1.5">{{ $sinistre->contact }}</span>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <span
                                    class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest
                            @if ($sinistre->type_sinistre == 'incendie') bg-red-100 text-red-600
                            @elseif($sinistre->type_sinistre == 'accident') bg-orange-100 text-orange-600
                            @elseif($sinistre->type_sinistre == 'inondation') bg-blue-100 text-blue-600
                            @else bg-gray-100 text-gray-600 @endif">
                                    {{ $sinistre->type_sinistre }}
                                </span>
                            </td>
                            <td class="py-5 px-6">
                                @if ($sinistre->caserneAssignee)
                                    <div class="flex flex-col items-center">
                                        <span class="text-xs font-black text-gray-800">{{ $sinistre->caserneAssignee->name }}</span>
                                        @if($sinistre->caserneAssignee->role === 'groupe' && $sinistre->caserneAssignee->caserneParent)
                                            <span class="text-[9px] text-onpc-blue font-bold uppercase mt-0.5 px-2 py-0.5 bg-blue-50 rounded-full border border-blue-100">
                                                {{ $sinistre->caserneAssignee->caserneParent->name }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-[10px] font-bold text-gray-400 uppercase italic">Non assignée</span>
                                @endif
                            </td>
                            <td class="py-5 px-6">
                                <span
                                    class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700">Résolu</span>
                            </td>
                            <td class="py-5 px-8 text-right">
                                <a href="{{ route('admin.sinistre.show', $sinistre) }}"
                                    class="p-2.5 rounded-xl bg-blue-50 text-onpc-blue hover:bg-onpc-blue hover:text-white transition-all duration-300 shadow-sm"
                                    title="Détails">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center">
                                <p class="text-gray-500 font-bold uppercase tracking-widest text-sm">Aucun sinistre terminé.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($sinistres->hasPages())
            <div class="px-8 py-6 bg-gray-50 border-t border-gray-100">
                {{ $sinistres->links() }}
            </div>
        @endif
    </div>
@endsection
