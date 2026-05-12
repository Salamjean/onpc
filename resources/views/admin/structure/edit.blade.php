@extends('admin.layouts.app')

@section('content')
<div class="mb-10 flex flex-col items-center justify-center text-center">
    <div class="relative w-full">
        <a href="{{ route('admin.structure.index') }}" class="group inline-flex items-center text-xs font-black text-slate-400 uppercase tracking-[0.2em] hover:text-onpc-blue transition-all mb-4">
            <div class="bg-white p-2 rounded-lg shadow-sm border border-slate-100 mr-3 group-hover:-translate-x-1 transition-transform">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </div>
            Retour à la liste
        </a>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none uppercase">
            Modifier la <span class="text-onpc-blue">Structure</span>
        </h1>
        <div class="flex justify-center">
            <p class="text-slate-500 mt-3 font-bold text-sm uppercase tracking-widest flex items-center gap-2">
                <span class="w-8 h-[2px] bg-onpc-orange"></span>
                Mise à jour partenaire
                <span class="w-8 h-[2px] bg-onpc-orange"></span>
            </p>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto relative">
    <form action="{{ route('admin.structure.update', $structure) }}" method="POST" class="relative bg-white/80 backdrop-blur-xl rounded-[3rem] shadow-2xl shadow-slate-300/30 border border-white overflow-hidden">
        @csrf
        @method('PUT')
        
        <div class="flex flex-col lg:flex-row">
            
            <!-- Left Info Panel -->
            <div class="lg:w-1/3 bg-gradient-to-br from-slate-900 to-onpc-blue p-10 text-white flex flex-col justify-between relative overflow-hidden">
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/10 rounded-[1.5rem] flex items-center justify-center mb-8 border border-white/20 text-onpc-orange">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black uppercase tracking-tight leading-tight mb-4">Edition <br>Compte</h3>
                    <p class="text-blue-100/60 text-sm font-medium leading-relaxed">
                        Modifiez les informations de la structure. Les modifications seront prises en compte instantanément.
                    </p>
                </div>
            </div>

            <!-- Right Form Panel -->
            <div class="flex-1 p-8 md:p-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                    <!-- Nom -->
                    <div class="space-y-3 group">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 group-focus-within:text-onpc-blue">Nom complet</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <input type="text" name="nom" required value="{{ old('nom', $structure->nom) }}"
                                class="w-full pl-14 pr-6 py-4.5 bg-slate-50 border-2 border-slate-50 rounded-2xl outline-none focus:border-onpc-blue focus:bg-white transition-all font-bold text-slate-800 shadow-inner">
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="space-y-3 group">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 group-focus-within:text-onpc-blue">Contact Pro</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <input type="tel" name="contact" required value="{{ old('contact', $structure->contact) }}"
                                class="w-full pl-14 pr-6 py-4.5 bg-slate-50 border-2 border-slate-50 rounded-2xl outline-none focus:border-onpc-blue focus:bg-white transition-all font-bold text-slate-800 shadow-inner">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="md:col-span-2 space-y-3 group">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 group-focus-within:text-onpc-blue">Adresse Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="email" name="email" required value="{{ old('email', $structure->email) }}"
                                class="w-full pl-14 pr-6 py-4.5 bg-slate-50 border-2 border-slate-50 rounded-2xl outline-none focus:border-onpc-blue focus:bg-white transition-all font-bold text-slate-800 shadow-inner">
                        </div>
                    </div>

                    <!-- Ville -->
                    <div class="space-y-3 group">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 group-focus-within:text-onpc-blue">Ville</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <input type="text" name="ville" required value="{{ old('ville', $structure->ville) }}"
                                class="w-full pl-14 pr-6 py-4.5 bg-slate-50 border-2 border-slate-50 rounded-2xl outline-none focus:border-onpc-blue focus:bg-white transition-all font-bold text-slate-800 shadow-inner">
                        </div>
                    </div>

                    <!-- Commune -->
                    <div class="space-y-3 group">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 group-focus-within:text-onpc-blue">Commune</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            </div>
                            <input type="text" name="commune" required value="{{ old('commune', $structure->commune) }}"
                                class="w-full pl-14 pr-6 py-4.5 bg-slate-50 border-2 border-slate-50 rounded-2xl outline-none focus:border-onpc-blue focus:bg-white transition-all font-bold text-slate-800 shadow-inner">
                        </div>
                    </div>

                    <!-- Adresse -->
                    <div class="md:col-span-2 space-y-3 group">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 group-focus-within:text-onpc-blue">Localisation détaillée</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7l5-2.5 5.553 2.776a1 1 0 01.447.894v10.764a1 1 0 01-1.447.894L15 17l-6 3z"></path></svg>
                            </div>
                            <input type="text" name="adresse" required value="{{ old('adresse', $structure->adresse) }}"
                                class="w-full pl-14 pr-6 py-4.5 bg-slate-50 border-2 border-slate-50 rounded-2xl outline-none focus:border-onpc-blue focus:bg-white transition-all font-bold text-slate-800 shadow-inner">
                        </div>
                    </div>
                </div>

                <div class="mt-12 flex justify-end">
                    <button type="submit" class="group relative flex items-center bg-onpc-blue text-white px-12 py-5 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.3em] shadow-2xl shadow-blue-900/30 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        Sauvegarder les modifications
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
