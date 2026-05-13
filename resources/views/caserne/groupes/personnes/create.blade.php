@extends('caserne.layouts.app')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 uppercase tracking-tight">
                Ajouter des <span class="text-onpc-orange">Personnes</span>
            </h1>
            <p class="text-slate-500 mt-2 font-medium">
                Groupe: <span class="font-black text-slate-700">{{ $groupe->name }}</span>
            </p>
        </div>
        <a href="{{ route('caserne.groupes.index') }}"
            class="bg-white border border-slate-200 text-slate-700 px-5 py-3 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] hover:bg-slate-50 transition-all">
            Retour aux listes
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
        <div class="xl:col-span-6">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
                <div class="px-8 py-7 border-b border-slate-50 bg-slate-50">
                    <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">
                        {{ $personneEnEdition ? 'Modifier une personne du groupe' : 'Nouvelle personne du groupe' }}
                    </h2>
                </div>

                <form method="POST" action="{{ route('caserne.groupes.personnes.store', $groupe) }}" class="p-8 space-y-6">
                    @csrf
                    @if ($personneEnEdition)
                        <input type="hidden" name="personne_id" value="{{ $personneEnEdition->id }}">
                    @endif

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nom
                            complet *</label>
                        <input type="text" name="nom_complet"
                            value="{{ old('nom_complet', $personneEnEdition?->nom_complet) }}" required
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-base font-semibold text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/10 focus:border-onpc-blue">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Téléphone</label>
                            <input type="text" name="telephone"
                                value="{{ old('telephone', $personneEnEdition?->telephone) }}"
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-base font-semibold text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/10 focus:border-onpc-blue">
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Fonction</label>
                            <input type="text" name="fonction"
                                value="{{ old('fonction', $personneEnEdition?->fonction) }}"
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-base font-semibold text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/10 focus:border-onpc-blue">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-2 bg-onpc-orange hover:bg-orange-600 text-white py-4 rounded-2xl font-black text-[12px] uppercase tracking-[0.25em] transition-all shadow-xl shadow-orange-900/20">
                        {{ $personneEnEdition ? 'Mettre a jour la personne' : 'Ajouter la personne' }}
                    </button>

                    @if ($personneEnEdition)
                        <a href="{{ route('caserne.groupes.personnes.create', $groupe) }}"
                            class="block w-full text-center mt-2 bg-white border border-slate-200 text-slate-700 py-3 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] hover:bg-slate-50 transition-all">
                            Annuler la modification
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <div class="xl:col-span-6">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50 bg-slate-50 flex items-center justify-between">
                    <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Personnes enregistrées</h2>
                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-black">
                        {{ $groupe->personnesDuGroupe->count() }}
                    </span>
                </div>

                <div class="p-6 space-y-3 max-h-[580px] overflow-y-auto">
                    @forelse ($groupe->personnesDuGroupe as $personne)
                        <div
                            class="px-4 py-3 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <p class="text-sm font-black text-slate-800">{{ $personne->nom_complet }}</p>
                                    @if ($personne->archived_at)
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-700">
                                            Archivee
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs font-semibold text-slate-500">
                                    {{ $personne->fonction ?? 'Sans fonction' }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2 flex-wrap sm:justify-end">
                                <span class="text-xs font-semibold text-slate-500">{{ $personne->telephone ?? '-' }}</span>

                                <a href="{{ route('caserne.groupes.personnes.create', ['groupe' => $groupe, 'edit_personne' => $personne->id]) }}"
                                    class="px-2.5 py-1 rounded-lg bg-amber-100 text-amber-700 text-[10px] font-black uppercase tracking-wide hover:bg-amber-200 transition-colors">
                                    Modifier
                                </a>

                                <form method="POST"
                                    action="{{ route('caserne.groupes.personnes.destroy', [$groupe, $personne]) }}"
                                    onsubmit="return confirm('Supprimer cette personne ? Cette action est irreversible.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-2.5 py-1 rounded-lg bg-red-100 text-red-700 text-[10px] font-black uppercase tracking-wide hover:bg-red-200 transition-colors">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm font-semibold text-slate-400 italic">Aucune personne enregistrée pour ce groupe.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-50 bg-slate-50">
            <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Statistiques du groupe</h2>
            <p class="text-[11px] font-semibold text-slate-500 mt-1">Synthèse indépendante des effectifs et interventions.
            </p>
        </div>

        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <div
                class="rounded-2xl border border-slate-100 bg-slate-50 px-5 py-5 min-h-[118px] flex flex-col justify-between">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Interventions total</p>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $stats['interventions_total'] }}</p>
            </div>

            <div
                class="rounded-2xl border border-slate-100 bg-slate-50 px-5 py-5 min-h-[118px] flex flex-col justify-between">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">En cours</p>
                <p class="text-3xl font-black text-amber-600 mt-1">{{ $stats['interventions_en_cours'] }}</p>
            </div>

            <div
                class="rounded-2xl border border-slate-100 bg-slate-50 px-5 py-5 min-h-[118px] flex flex-col justify-between">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Terminées</p>
                <p class="text-3xl font-black text-emerald-600 mt-1">{{ $stats['interventions_terminees'] }}</p>
            </div>

            <div
                class="rounded-2xl border border-slate-100 bg-slate-50 px-5 py-5 min-h-[118px] flex flex-col justify-between">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Aujourd'hui</p>
                <p class="text-3xl font-black text-onpc-blue mt-1">{{ $stats['interventions_aujourdhui'] }}</p>
            </div>
        </div>

        <div class="px-6 pb-6">
            <div class="border border-slate-100 rounded-2xl overflow-hidden">
                <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between gap-3">
                    <h3 class="text-xs font-black text-slate-700 uppercase tracking-widest">3 dernieres interventions</h3>
                    <a href="{{ route('caserne.groupes.interventions.index', $groupe) }}"
                        class="inline-flex items-center px-3 py-1.5 rounded-lg bg-onpc-blue text-white text-[10px] font-black uppercase tracking-widest hover:bg-blue-900 transition-colors">
                        Voir toutes interventions
                    </a>
                </div>

                <div class="divide-y divide-slate-100 bg-white">
                    @forelse ($dernieresInterventions as $intervention)
                        <div class="px-4 py-3 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                            <div>
                                <p class="text-sm font-black text-slate-800">
                                    {{ $intervention->reference ?? 'Sans reference' }} -
                                    {{ $intervention->type_sinistre ?? 'Sinistre' }}
                                </p>
                                <p class="text-xs font-semibold text-slate-500">
                                    {{ $intervention->lieu ?? 'Lieu non renseigne' }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-[11px] font-semibold text-slate-500">{{ $intervention->created_at?->format('d/m/Y H:i') }}</span>
                                <span
                                    class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide
                                    {{ $intervention->status === 'en_cours' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ in_array($intervention->status, ['resolu', 'termine']) ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ !in_array($intervention->status, ['en_cours', 'resolu', 'termine']) ? 'bg-slate-100 text-slate-600' : '' }}">
                                    {{ str_replace('_', ' ', $intervention->status ?? 'inconnu') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-6 text-center text-sm font-semibold text-slate-400">
                            Aucune intervention recente pour ce groupe.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
