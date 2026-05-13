@extends('caserne.layouts.app')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 uppercase tracking-tight">
                Toutes les <span class="text-onpc-orange">Interventions</span>
            </h1>
            <p class="text-slate-500 mt-2 font-medium">
                Groupe: <span class="font-black text-slate-700">{{ $groupe->name }}</span>
            </p>
        </div>

        <a href="{{ route('caserne.groupes.personnes.create', $groupe) }}"
            class="bg-white border border-slate-200 text-slate-700 px-5 py-3 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] hover:bg-slate-50 transition-all">
            Retour statistiques
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-50 bg-slate-50 flex items-center justify-between gap-3">
            <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Historique des interventions du groupe
            </h2>
            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-black">
                {{ $interventions->total() }}
            </span>
        </div>

        <div class="p-6 space-y-3">
            @forelse ($interventions as $intervention)
                <div
                    class="px-4 py-3 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <p class="text-sm font-black text-slate-800">
                            {{ $intervention->reference ?? 'Sans reference' }} -
                            {{ $intervention->type_sinistre ?? 'Sinistre' }}
                        </p>
                        <p class="text-xs font-semibold text-slate-500 mt-1">
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
                <div class="py-12 text-center">
                    <p class="text-sm font-semibold text-slate-400">Aucune intervention disponible pour ce groupe.</p>
                </div>
            @endforelse
        </div>

        <div class="px-6 pb-6">
            {{ $interventions->links() }}
        </div>
    </div>
@endsection
