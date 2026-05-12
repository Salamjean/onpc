<div class="overflow-x-auto rounded-3xl border border-slate-100">
    <table class="w-full text-left border-separate border-spacing-y-2 min-w-[980px]">
        <thead>
            <tr class="bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">
                <th class="px-6 py-4 text-center">ID / Date</th>
                <th class="px-6 py-4 text-center">Déclarant</th>
                <th class="px-6 py-4 text-center">Type Sinistre</th>
                <th class="px-6 py-4 text-center">Localisation / Distance</th>
                <th class="px-6 py-4 text-center">Statut</th>
                <th class="px-6 py-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sinistres as $sinistre)
                <tr class="bg-white hover:bg-slate-50 transition-all group shadow-sm rounded-3xl ring-1 ring-slate-100">
                    <td class="px-6 py-5 first:rounded-l-4xl text-center">
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
                                class="text-onpc-blue font-black text-xs mt-1 flex items-center gap-1 hover:underline">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                {{ $sinistre->contact }}
                            </a>
                        </div>
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
                        <div class="flex flex-col items-center">
                            <span class="text-xs font-bold text-slate-600 italic">Position capturée</span>
                            @if ($sinistre->pivot)
                                <span class="text-[10px] font-black text-caserne-red mt-1 uppercase tracking-tighter">
                                    À {{ number_format($sinistre->pivot->distance, 2) }} KM de vous
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                            @if ($sinistre->assigned_caserne_id == auth()->id() && $sinistre->status == 'en_attente') bg-blue-100 text-blue-600
                            @elseif($sinistre->assigned_caserne_id == auth()->id() && $sinistre->status == 'en_cours') bg-emerald-100 text-emerald-700
                            @else bg-orange-100 text-orange-600 @endif">
                            @if ($sinistre->assigned_caserne_id == auth()->id() && $sinistre->status == 'en_attente')
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <span class="text-[10px] font-black uppercase tracking-widest">Assigné</span>
                            @elseif($sinistre->assigned_caserne_id == auth()->id() && $sinistre->status == 'en_cours')
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span class="text-[10px] font-black uppercase tracking-widest">En
                                    cours</span>
                            @elseif(!$sinistre->assigned_caserne_id)
                                <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                <span class="text-[10px] font-black uppercase tracking-widest">Disponible</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-5 last:rounded-r-4xl text-center">
                        <div class="flex items-center justify-center gap-3">
                            {{-- Sinistre assigné ou libre → démarrer l'intervention --}}
                            @if (
                                ($sinistre->assigned_caserne_id == auth()->id() && $sinistre->status == 'en_attente') ||
                                    !$sinistre->assigned_caserne_id)
                                <form action="{{ route('caserne.sinistre.claim', $sinistre) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-caserne-red hover:bg-red-700 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:shadow-md">
                                        Démarrer
                                    </button>
                                </form>
                            @elseif($sinistre->assigned_caserne_id == auth()->id() && $sinistre->status == 'en_cours')
                                <a href="{{ route('caserne.sinistre.rapport', $sinistre) }}"
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:shadow-md">
                                    État des lieux
                                </a>
                            @endif

                            <a href="{{ route('caserne.sinistre.show', $sinistre) }}"
                                class="bg-caserne-dark hover:bg-slate-700 text-white p-2.5 rounded-xl transition-all shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-20 text-center">
                        <div class="flex flex-col items-center opacity-20">
                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p class="font-black uppercase tracking-widest">Aucune déclaration pour le moment</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
