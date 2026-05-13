@extends('groupe.layouts.app')

@section('content')
    <div class="mb-8 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight uppercase">
                Onglet <span class="text-onpc-orange">Intervention</span>
            </h1>
            <p class="text-slate-500 mt-3 font-bold text-xs flex items-center gap-2 uppercase tracking-widest">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Sinistres récupérés et en attente d'intervention
            </p>
        </div>

        <div class="bg-white px-6 py-4 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Interventions en cours</p>
            <p class="text-3xl font-black text-slate-900 mt-2" id="intervention-counter">{{ $interventionsCount }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Groupe</p>
            <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $groupe->name }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Caserne de rattachement</p>
            <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $caserne ? $caserne->name : 'Non rattache' }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Statut</p>
            <p class="text-2xl font-extrabold text-slate-900 mt-2">Pris en charge</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 p-4 md:p-6">
        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Interventions</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">Liste des sinistres que le groupe a récupérés</p>
            </div>
        </div>

        <div id="interventions-container" class="transition-opacity duration-300">
            @include('groupe.partials.interventions_table')
        </div>
    </div>
@endsection
