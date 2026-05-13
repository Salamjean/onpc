@extends('groupe.layouts.app')

@section('content')
    @php
        $documents = is_array($sinistre->etat_des_lieux_documents) ? $sinistre->etat_des_lieux_documents : [];
        $images = array_filter([$sinistre->image1, $sinistre->image2, $sinistre->image3]);
    @endphp

    <div class="mb-8 flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
        <div class="flex items-start gap-4">
            <a href="{{ route('caserne.groupe.interventions.completed.index') }}"
                class="p-3 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-onpc-orange hover:shadow-lg transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>

            <div>
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight uppercase">
                    Intervention <span class="text-onpc-orange">Clôturée</span>
                </h1>
                <p class="text-slate-500 mt-3 font-bold text-xs flex items-center gap-2 uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    {{ $sinistre->reference ?? 'SN-' . $sinistre->id }}
                </p>
            </div>
        </div>

        <div class="bg-white px-6 py-4 rounded-2xl border border-slate-100 shadow-sm min-w-[260px]">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Clôturée le</p>
            <p class="text-xl font-black text-slate-900 mt-2">
                {{ optional($sinistre->date_cloture)->format('d/m/Y H:i') ?? '-' }}</p>
            <a href="{{ route('caserne.groupe.interventions.completed.pdf', $sinistre) }}"
                class="mt-4 inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm hover:shadow-md w-full">
                Télécharger PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        <div class="xl:col-span-8 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-8">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Détails du sinistre</h2>
                        <p class="text-sm text-slate-500 font-medium mt-1">Informations de la déclaration initiale</p>
                    </div>
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-[10px] font-black uppercase tracking-widest">Terminée</span>
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Déclarant</p>
                        <p class="mt-2 text-lg font-bold text-slate-900">{{ $sinistre->nom_complet }}</p>
                        <p class="text-sm font-semibold text-slate-500">{{ $sinistre->contact }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Type d'incident</p>
                        <p class="mt-2 text-lg font-bold text-slate-900 uppercase">{{ $sinistre->type_sinistre }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5 md:col-span-2">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Lieu</p>
                        <p class="mt-2 text-base font-semibold text-slate-700">
                            {{ $sinistre->lieu ?? ($sinistre->latitude && $sinistre->longitude ? $sinistre->latitude . ', ' . $sinistre->longitude : 'Non renseigné') }}
                        </p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5 md:col-span-2">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Description citoyenne</p>
                        <p class="mt-2 text-sm font-medium text-slate-700 leading-relaxed">
                            {{ $sinistre->description ?: 'Aucune description fournie.' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-8">
                <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Rapport d'intervention</h2>
                <div
                    class="mt-5 rounded-2xl bg-slate-50 border border-slate-100 p-6 text-sm font-medium text-slate-700 leading-relaxed whitespace-pre-line">
                    {{ $sinistre->rapport_intervention ?: 'Aucun rapport enregistré.' }}</div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-8">
                <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Pièces jointes</h2>

                @if (!empty($documents))
                    <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach ($documents as $document)
                            <a href="{{ asset('storage/' . $document) }}" target="_blank"
                                class="inline-flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm font-bold text-onpc-blue hover:border-onpc-blue hover:bg-white transition-all">
                                <span>Document {{ $loop->iteration }}</span>
                                <span class="text-xs font-black uppercase tracking-widest">Ouvrir</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="mt-5 text-sm font-medium text-slate-500">Aucune pièce jointe n'a été ajoutée.</p>
                @endif
            </div>
        </div>

        <div class="xl:col-span-4 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight">Bilan</h2>
                <div class="mt-5 grid grid-cols-1 gap-3">
                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Morts</p>
                        <p class="mt-2 text-3xl font-black text-slate-900">{{ $sinistre->nb_morts ?? 0 }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Blessés</p>
                        <p class="mt-2 text-3xl font-black text-slate-900">{{ $sinistre->nb_blesses ?? 0 }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Evacués</p>
                        <p class="mt-2 text-3xl font-black text-slate-900">{{ $sinistre->nb_evacues ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight">Chronologie</h2>
                <div class="mt-5 space-y-4 text-sm">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Déclaré le</p>
                        <p class="mt-1 font-semibold text-slate-700">
                            {{ optional($sinistre->created_at)->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Clôturé le</p>
                        <p class="mt-1 font-semibold text-slate-700">
                            {{ optional($sinistre->date_cloture)->format('d/m/Y H:i') ?? '-' }}</p>
                    </div>
                </div>
            </div>

            @if (!empty($images))
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                    <h2 class="text-lg font-black text-slate-900 uppercase tracking-tight">Photos initiales</h2>
                    <div class="mt-5 grid grid-cols-1 gap-3">
                        @foreach ($images as $image)
                            <div class="overflow-hidden rounded-2xl border border-slate-100 bg-slate-50">
                                <img src="{{ asset('storage/' . $image) }}" alt="Photo du sinistre"
                                    class="w-full h-48 object-cover cursor-pointer hover:scale-105 transition-transform duration-300"
                                    onclick="window.open(this.src, '_blank')">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
