<div class="overflow-x-auto rounded-3xl border border-slate-100">
    <table class="w-full text-left border-separate border-spacing-y-2 min-w-[900px]">
        <thead>
            <tr class="bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">
                <th class="px-6 py-4 text-center">Référence</th>
                <th class="px-6 py-4 text-center">Déclarant</th>
                <th class="px-6 py-4 text-center">Type</th>
                <th class="px-6 py-4 text-center">Lieu</th>
                <th class="px-6 py-4 text-center">Date</th>
                <th class="px-6 py-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sinistres as $sinistre)
                <tr class="bg-white hover:bg-slate-50 transition-all group shadow-sm rounded-3xl ring-1 ring-slate-100">
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
                            class="text-sm font-semibold text-slate-600">{{ $sinistre->lieu ?? ($sinistre->latitude . ', ' . $sinistre->longitude) }}</span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span
                            class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ $sinistre->created_at->format('d/m/Y H:i') }}</span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <form action="{{ route('caserne.groupe.sinistre.claim', $sinistre) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center justify-center bg-onpc-orange hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:shadow-md">
                                    Démarrer
                                </button>
                            </form>

                            <a href="{{ route('caserne.groupe.sinistre.show', $sinistre) }}"
                                class="inline-flex items-center justify-center bg-onpc-blue hover:bg-blue-800 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:shadow-md">
                                Voir
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
                            <p class="font-black uppercase tracking-widest">Aucun sinistre en attente</p>
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
