@extends('groupe.layouts.app')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Etat des <span
                    class="text-onpc-orange">Lieux</span></h1>
            <p class="text-slate-500 mt-2 font-medium">Renseignez le constat terrain de l'intervention.</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('caserne.groupe.interventions.index') }}"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-3 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] transition-all">
                Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        <div class="xl:col-span-8 bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-8">
            <form id="etat-des-lieux-form" action="{{ route('caserne.groupe.interventions.etat-des-lieux.store', $sinistre) }}" method="POST"
                enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Rapport
                        d'intervention</label>
                    <textarea name="rapport_intervention" rows="7" required
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-onpc-blue">{{ old('rapport_intervention', $sinistre->rapport_intervention) }}</textarea>
                    @error('rapport_intervention')
                        <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Morts</label>
                        <input type="number" min="0" name="nb_morts"
                            value="{{ old('nb_morts', $sinistre->nb_morts ?? 0) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-onpc-blue">
                        @error('nb_morts')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Blesses</label>
                        <input type="number" min="0" name="nb_blesses"
                            value="{{ old('nb_blesses', $sinistre->nb_blesses ?? 0) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-onpc-blue">
                        @error('nb_blesses')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Evacues</label>
                        <input type="number" min="0" name="nb_evacues"
                            value="{{ old('nb_evacues', $sinistre->nb_evacues ?? 0) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-onpc-blue">
                        @error('nb_evacues')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between gap-3 mb-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Documents /
                            Photos</label>
                        <button type="button" id="addAttachmentBtn"
                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-onpc-blue text-white font-black text-sm shadow-sm hover:bg-blue-900 transition-all">
                            +
                        </button>
                    </div>
                    <div id="attachmentsWrapper" class="flex flex-nowrap gap-3 items-start overflow-x-auto pb-2">
                        <div class="attachment-row flex items-start gap-2 min-w-[320px] shrink-0">
                            <input type="file" name="etat_des_lieux_documents[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                class="w-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-4 text-sm font-medium text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-onpc-blue file:px-4 file:py-2 file:text-xs file:font-black file:uppercase file:tracking-widest file:text-white hover:bg-slate-100 transition-all">
                        </div>
                    </div>
                    <p class="mt-2 text-xs font-medium text-slate-400">Ajoutez plusieurs documents ou photos. PDF, DOC,
                        DOCX, JPG ou PNG, 10 Mo max chacun.</p>
                    @error('etat_des_lieux_documents')
                        <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                    @error('etat_des_lieux_documents.*')
                        <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @php
                    $documents = is_array($sinistre->etat_des_lieux_documents)
                        ? $sinistre->etat_des_lieux_documents
                        : [];
                @endphp

                @if (!empty($documents))
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Documents déjà joints</p>
                        <div class="mt-3 flex flex-nowrap gap-2 overflow-x-auto pb-1">
                            @foreach ($documents as $document)
                                <a href="{{ asset('storage/' . $document) }}" target="_blank"
                                    class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-bold text-onpc-blue border border-slate-200 hover:border-onpc-blue hover:shadow-sm transition-all">
                                    Ouvrir le fichier {{ $loop->iteration }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="pt-2">
                    <button type="submit"
                        class="bg-onpc-orange hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] transition-all shadow-sm">
                        Enregistrer l'etat des lieux
                    </button>
                </div>
            </form>
        </div>

        <div class="xl:col-span-4 bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <p class="text-xs font-black text-slate-500 uppercase tracking-widest">Intervention</p>
            <h2 class="mt-2 text-lg font-black text-slate-900">{{ $sinistre->reference ?? 'SN-' . $sinistre->id }}</h2>

            <div class="mt-6 space-y-4 text-sm">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Declarant</p>
                    <p class="mt-1 font-semibold text-slate-700">{{ $sinistre->nom_complet }}</p>
                    <p class="text-xs font-semibold text-slate-500">{{ $sinistre->contact }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Type</p>
                    <p class="mt-1 font-semibold text-slate-700">{{ $sinistre->type_sinistre }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Lieu</p>
                    <p class="mt-1 font-semibold text-slate-700">{{ $sinistre->lieu ?? 'Non renseigne' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Date declaration</p>
                    <p class="mt-1 font-semibold text-slate-700">{{ $sinistre->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            {{-- Doublons / Regroupement --}}
            @if($autresSinistres->count() > 0)
            <div class="mt-8 pt-8 border-t border-slate-100">
                <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Déclarations Groupées (Doublons)</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($autresSinistres as $autre)
                    <label class="block p-4 rounded-2xl border border-slate-100 bg-slate-50 hover:bg-white hover:border-onpc-orange transition-all cursor-pointer group">
                        <div class="flex items-start gap-3">
                            <div class="mt-1">
                                <input type="checkbox" name="merged_sinistres[]" value="{{ $autre->id }}" 
                                    form="etat-des-lieux-form"
                                    class="w-5 h-5 rounded-lg border-slate-300 text-onpc-orange focus:ring-onpc-orange">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start gap-2">
                                    <span class="text-[10px] font-black text-onpc-blue uppercase truncate">{{ $autre->reference ?? '#SN-'.$autre->id }}</span>
                                    <span class="text-[9px] font-bold text-slate-400 shrink-0">{{ $autre->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs font-black text-slate-800 mt-1 truncate">{{ $autre->type_sinistre }}</p>
                                <p class="text-[10px] font-medium text-slate-500 mt-1 line-clamp-1 italic">"{{ $autre->description }}"</p>
                                <div class="flex items-center gap-1 mt-2">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    <span class="text-[9px] font-bold text-slate-400 truncate">{{ $autre->lieu ?? 'Localisation GPS' }}</span>
                                </div>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                <p class="mt-4 p-3 bg-blue-50 rounded-xl text-[10px] font-bold text-blue-700 leading-relaxed border border-blue-100">
                    <svg class="w-4 h-4 inline mr-1 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Cochez les déclarations qui concernent le même incident. Elles seront marquées comme terminées automatiquement.
                </p>
            </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addBtn = document.getElementById('addAttachmentBtn');
            const wrapper = document.getElementById('attachmentsWrapper');

            if (!addBtn || !wrapper) return;

            addBtn.addEventListener('click', function() {
                const row = document.createElement('div');
                row.className = 'attachment-row flex items-start gap-2 min-w-[320px] shrink-0';
                row.innerHTML = `
                    <input type="file" name="etat_des_lieux_documents[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                        class="w-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-4 text-sm font-medium text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-onpc-blue file:px-4 file:py-2 file:text-xs file:font-black file:uppercase file:tracking-widest file:text-white hover:bg-slate-100 transition-all">
                    <button type="button"
                        class="remove-attachment-btn inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-100 text-slate-500 hover:bg-red-100 hover:text-red-600 transition-all font-black">×</button>
                `;

                row.querySelector('.remove-attachment-btn').addEventListener('click', function() {
                    row.remove();
                });

                wrapper.appendChild(row);
            });
        });
    </script>
@endsection
