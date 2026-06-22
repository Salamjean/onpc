@extends('caserne.layouts.app')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 uppercase tracking-tight">
                Ajouter un <span class="text-onpc-orange">Groupe</span>
            </h1>
            <p class="text-slate-500 mt-2 font-medium">Créez un nouveau groupe d'intervention rattaché à votre caserne.</p>
        </div>
        <a href="{{ route('caserne.groupes.index') }}"
            class="bg-white border border-slate-200 text-slate-700 px-5 py-3 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] hover:bg-slate-50 transition-all">
            Voir les listes
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
        <div class="xl:col-span-7">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
                <div class="px-8 py-7 border-b border-slate-50 bg-slate-50">
                    <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Informations du groupe</h2>
                    <p class="text-[10px] text-slate-400 font-bold mt-1">Le groupe recevra un email OTP pour définir son mot
                        de passe.</p>
                </div>

                <form action="{{ route('caserne.groupes.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nom du
                            groupe *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-base font-semibold text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/10 focus:border-onpc-blue">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1.5 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Email
                                *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-base font-semibold text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/10 focus:border-onpc-blue">
                            @error('email')
                                <p class="text-xs text-red-500 mt-1.5 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Téléphone
                                *</label>
                            <input type="text" name="telephone" value="{{ old('telephone') }}" required
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-base font-semibold text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/10 focus:border-onpc-blue">
                            @error('telephone')
                                <p class="text-xs text-red-500 mt-1.5 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-2 bg-onpc-blue hover:bg-blue-900 text-white py-4 rounded-2xl font-black text-[12px] uppercase tracking-[0.25em] transition-all shadow-xl shadow-blue-900/20">
                        Enregistrer le groupe
                    </button>
                </form>
            </div>
        </div>

        <div class="xl:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Groupes existants</p>
                <p class="text-4xl font-black text-slate-900 mt-2">{{ $groupesCount }}</p>
            </div>

            <div class="bg-onpc-blue rounded-3xl border border-blue-900/20 shadow-sm p-6 text-white">
                <h3 class="text-sm font-black uppercase tracking-widest">Processus</h3>
                <ul class="mt-4 space-y-3 text-sm font-semibold text-blue-100">
                    <li>1. Créer le groupe</li>
                    <li>2. Le groupe configure son mot de passe</li>
                    <li>3. Ajouter les personnes d'intervention</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
