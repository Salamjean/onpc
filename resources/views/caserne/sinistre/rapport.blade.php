@extends('caserne.layouts.app')

@section('content')
    <div class="mb-10 flex items-center gap-4">
        <a href="{{ route('caserne.dashboard') }}"
            class="p-3 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-caserne-red hover:shadow-lg transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Rapport d'intervention <span
                    class="text-caserne-red">#SN-{{ $sinistre->id }}</span></h1>
            <p class="text-slate-500 font-bold text-xs uppercase tracking-widest mt-1">État des lieux final et bilan des
                victimes</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Détails du Sinistre (Rappel) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100">
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">
                    Rappel des faits</h3>

                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Type d'incident</p>
                        <p class="text-lg font-bold text-slate-800 uppercase">{{ $sinistre->type_sinistre }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Lieu de l'incident</p>
                        <p class="text-sm font-bold text-slate-700 leading-tight">
                            {{ $sinistre->lieu ?? $sinistre->latitude . ', ' . $sinistre->longitude }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Déclarant & Contact</p>
                        <p class="text-sm font-bold text-slate-700">{{ $sinistre->nom_complet }}</p>
                        <p class="text-caserne-red font-black text-sm">{{ $sinistre->contact }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Description initiale</p>
                        <p
                            class="text-sm text-slate-600 font-medium italic mt-2 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            "{{ $sinistre->description }}"
                        </p>
                    </div>

                    @if ($sinistre->image1)
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Photos du
                                terrain</p>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="aspect-square rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                                    <img src="{{ asset('storage/' . $sinistre->image1) }}"
                                        class="w-full h-full object-cover cursor-zoom-in" onclick="window.open(this.src)">
                                </div>
                                @if ($sinistre->image2)
                                    <div
                                        class="aspect-square rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                                        <img src="{{ asset('storage/' . $sinistre->image2) }}"
                                            class="w-full h-full object-cover cursor-zoom-in"
                                            onclick="window.open(this.src)">
                                    </div>
                                @endif
                                @if ($sinistre->image3)
                                    <div
                                        class="aspect-square rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                                        <img src="{{ asset('storage/' . $sinistre->image3) }}"
                                            class="w-full h-full object-cover cursor-zoom-in"
                                            onclick="window.open(this.src)">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Formulaire de Rapport -->
        <div class="lg:col-span-7">
            <div
                class="bg-white rounded-[2.5rem] p-10 shadow-2xl shadow-slate-200/60 border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-caserne-red opacity-[0.03] rounded-full -mr-16 -mt-16">
                </div>

                <form action="{{ route('caserne.sinistre.complete', $sinistre) }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="flex items-center gap-4 mb-2">
                        <div
                            class="w-10 h-10 bg-caserne-red/10 rounded-xl flex items-center justify-center text-caserne-red">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Rédaction du Bilan</h3>
                    </div>

                    <!-- Bilan humain -->
                    <div class="grid grid-cols-3 gap-6">
                        <div class="space-y-3">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Morts</label>
                            <input type="number" name="nb_morts" value="0" min="0" required
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-onpc-blue/10 focus:border-onpc-blue transition-all font-black text-slate-800 text-center text-xl">
                        </div>
                        <div class="space-y-3">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Blessés</label>
                            <input type="number" name="nb_blesses" value="0" min="0" required
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-onpc-blue/10 focus:border-onpc-blue transition-all font-black text-slate-800 text-center text-xl">
                        </div>
                        <div class="space-y-3">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Évacués</label>
                            <input type="number" name="nb_evacues" value="0" min="0" required
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-onpc-blue/10 focus:border-onpc-blue transition-all font-black text-slate-800 text-center text-xl">
                        </div>
                    </div>

                    <!-- Observations -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Observations
                            détaillées et État des lieux</label>
                        <textarea name="rapport_intervention" required rows="8"
                            placeholder="Décrivez le déroulement de l'intervention, les moyens déployés et le constat final..."
                            class="w-full px-8 py-6 bg-slate-50 border border-slate-200 rounded-[2rem] outline-none focus:ring-4 focus:ring-onpc-blue/10 focus:border-onpc-blue transition-all font-medium text-slate-800 leading-relaxed"></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-caserne-dark hover:bg-caserne-red text-white py-6 rounded-[2rem] font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/20 hover:scale-[1.01] active:scale-[0.99] transition-all">
                            Enregistrer et Clôturer l'incident
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
