@extends('caserne.layouts.app')

@section('content')
<div class="mb-10">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none uppercase">
                Interventions <span class="text-caserne-red">À Faire</span>
            </h1>
            <p class="text-slate-500 mt-3 font-bold text-xs flex items-center gap-2 uppercase tracking-widest">
                <span class="w-2 h-2 rounded-full bg-caserne-red"></span>
                Liste des incidents que vous avez pris en charge
            </p>
        </div>
        <div class="bg-caserne-red/10 px-6 py-4 rounded-2xl border border-caserne-red/20 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-caserne-red flex items-center justify-center font-black text-white text-xs">
                {{ $sinistres->count() }}
            </div>
            <p class="text-[10px] font-black text-caserne-red uppercase tracking-widest">Missions actives</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] p-4 shadow-xl shadow-slate-200/50 border border-slate-100">
    @include('caserne.partials.sinistres_table', ['isInterventionPage' => true])
</div>
@endsection
