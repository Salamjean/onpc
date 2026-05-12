@extends('admin.layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Statistiques des casernes</h1>
        <p class="text-slate-400 mt-1 font-medium">Cliquez sur une carte pour consulter les statistiques globales d'une
            caserne.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($casernes as $caserne)
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 hover:shadow-lg transition-all">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-onpc-blue font-black">
                        {{ strtoupper(substr($caserne->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Caserne</p>
                        <h3 class="text-lg font-black text-slate-900 leading-tight">{{ $caserne->name }}</h3>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3 mb-5">
                    <div class="bg-slate-50 rounded-2xl p-3 text-center">
                        <p class="text-[9px] font-black text-slate-400 uppercase">Total</p>
                        <p class="text-xl font-black text-slate-900">{{ $caserne->sinistres_total }}</p>
                    </div>
                    <div class="bg-orange-50 rounded-2xl p-3 text-center">
                        <p class="text-[9px] font-black text-orange-400 uppercase">Non terminés</p>
                        <p class="text-xl font-black text-orange-600">{{ $caserne->sinistres_non_termines }}</p>
                    </div>
                    <div class="bg-green-50 rounded-2xl p-3 text-center">
                        <p class="text-[9px] font-black text-green-400 uppercase">Terminés</p>
                        <p class="text-xl font-black text-green-600">{{ $caserne->sinistres_termines }}</p>
                    </div>
                </div>

                <div
                    class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">
                    <span>Commune</span>
                    <span class="text-slate-700">{{ $caserne->commune ?? 'N/A' }}</span>
                </div>

                <a href="{{ route('admin.statistique.show', $caserne) }}"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-onpc-blue text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-slate-900 transition-all">
                    Voir les statistiques globales
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl shadow-sm border border-slate-100 py-16 text-center">
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Aucune caserne disponible</p>
            </div>
        @endforelse
    </div>
@endsection
