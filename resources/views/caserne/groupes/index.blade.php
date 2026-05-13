@extends('caserne.layouts.app')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Gestion des <span
                    class="text-onpc-orange">Groupes</span></h1>
            <p class="text-slate-500 mt-2 font-medium">Liste des groupes d'intervention rattachés à votre caserne.
            </p>
        </div>
        <a href="{{ route('caserne.groupes.create') }}"
            class="bg-onpc-blue hover:bg-blue-900 text-white px-5 py-3 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] transition-all">
            Ajouter un groupe
        </a>
    </div>

    <div class="mb-4 flex items-center justify-between">
        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Cartes des groupes rattachés</p>
        <span
            class="px-3 py-1.5 bg-blue-50 border border-blue-100 text-onpc-blue rounded-full text-[10px] font-black uppercase tracking-widest">
            {{ $groupes->total() }} total
        </span>
    </div>

    @if ($groupes->isEmpty())
        <div class="bg-white rounded-3xl border border-slate-100 py-16 text-center">
            <p class="text-[11px] font-black text-slate-300 uppercase tracking-[0.3em]">Aucun groupe enregistré</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            @foreach ($groupes as $groupe)
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-black text-slate-900">{{ $groupe->name }}</h3>
                            <p class="text-xs font-semibold text-slate-500 mt-1">{{ $groupe->email }}</p>
                            <p class="text-xs font-semibold text-slate-500">{{ $groupe->telephone }}</p>
                        </div>
                        <span
                            class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide {{ $groupe->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $groupe->status }}
                        </span>
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Personnes du groupe</p>
                        <span class="text-sm font-black text-onpc-blue">{{ $groupe->personnes_du_groupe_count }}</span>
                    </div>

                    <div class="mt-5">
                        <a href="{{ route('caserne.groupes.personnes.create', $groupe) }}"
                            class="block w-full text-center bg-onpc-orange hover:bg-orange-600 text-white py-2.5 rounded-xl font-black text-[10px] uppercase tracking-widest transition-colors">
                            Ouvrir le groupe
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $groupes->links() }}
        </div>
    @endif
@endsection
