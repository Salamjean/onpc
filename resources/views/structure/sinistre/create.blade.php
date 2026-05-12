@extends('structure.layouts.app')

@section('content')

{{-- Header --}}
<div class="mb-8 flex items-center justify-between">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('structure.dashboard') }}"
               class="w-9 h-9 flex items-center justify-center bg-white rounded-xl shadow-sm border border-slate-100 hover:border-onpc-blue hover:text-onpc-blue text-slate-400 transition-all hover:-translate-x-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Portail / Lancer une alerte</span>
        </div>
        <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Déclaration <span class="text-onpc-orange">d'Urgence</span></h1>
    </div>
    <div class="hidden md:flex items-center gap-3 bg-red-50 border border-red-100 px-5 py-3 rounded-2xl">
        <div class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"></div>
        <span class="text-[10px] font-black text-red-600 uppercase tracking-widest">Alerte en temps réel</span>
    </div>
</div>

<form action="{{ route('structure.sinistre.store') }}" method="POST" enctype="multipart/form-data" 
    x-data="{ 
        previews: { 1: null, 2: null },
        cameraOpen: false, cameraTarget: null, stream: null,
        async startCamera(target) {
            this.cameraTarget = target;
            this.cameraOpen = true;
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
                this.$refs.video.srcObject = this.stream;
            } catch (e) {
                alert('Erreur accès caméra. Vérifiez les permissions.');
                this.cameraOpen = false;
            }
        },
        stopCamera() {
            if (this.stream) { this.stream.getTracks().forEach(t => t.stop()); this.stream = null; }
            this.cameraOpen = false;
        },
        capture() {
            const canvas = document.createElement('canvas');
            canvas.width = this.$refs.video.videoWidth;
            canvas.height = this.$refs.video.videoHeight;
            canvas.getContext('2d').drawImage(this.$refs.video, 0, 0);
            const dataUrl = canvas.toDataURL('image/jpeg');
            this.previews[this.cameraTarget] = dataUrl;
            
            canvas.toBlob(blob => {
                const file = new File([blob], 'camera_structure_' + Date.now() + '.jpg', { type: 'image/jpeg' });
                const container = new DataTransfer();
                container.items.add(file);
                this.$refs['file' + this.cameraTarget].files = container.files;
                this.stopCamera();
            }, 'image/jpeg');
        }
    }">
    @csrf

    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

        {{-- ============================================================ --}}
        {{-- COL GAUCHE (3/5) --}}
        {{-- ============================================================ --}}
        <div class="xl:col-span-3 space-y-6">

            {{-- Nature du sinistre --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-50 flex items-center gap-3 bg-gradient-to-r from-slate-50 to-white">
                    <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Nature du sinistre</h2>
                        <p class="text-[10px] text-slate-400 font-bold">Catégorisation et description de l'incident</p>
                    </div>
                </div>

                <div class="p-8 space-y-6">
                    {{-- Type de sinistre --}}
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Type d'incident <span class="text-onpc-orange">*</span></label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3" x-data="{ selected: '{{ old('type_sinistre') }}' }">
                            @php
                                $types = [
                                    ['val' => 'Incendie', 'icon' => '🔥', 'color' => 'text-orange-500 bg-orange-50 border-orange-200'],
                                    ['val' => 'Accident de la circulation', 'icon' => '🚗', 'color' => 'text-blue-500 bg-blue-50 border-blue-200'],
                                    ['val' => 'Inondation', 'icon' => '🌊', 'color' => 'text-cyan-500 bg-cyan-50 border-cyan-200'],
                                    ['val' => "Effondrement d'immeuble", 'icon' => '🏚️', 'color' => 'text-stone-500 bg-stone-50 border-stone-200'],
                                    ['val' => 'Noyade', 'icon' => '💧', 'color' => 'text-sky-500 bg-sky-50 border-sky-200'],
                                    ['val' => 'Autre', 'icon' => '⚠️', 'color' => 'text-slate-500 bg-slate-50 border-slate-200'],
                                ];
                            @endphp
                            @foreach($types as $type)
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="type_sinistre" value="{{ $type['val'] }}" class="hidden peer" @click="selected = '{{ $type['val'] }}'" {{ old('type_sinistre') === $type['val'] ? 'checked' : '' }}>
                                <div class="flex flex-col items-center gap-2 p-4 rounded-2xl border-2 border-slate-100 bg-slate-50 transition-all peer-checked:border-onpc-orange peer-checked:bg-orange-50 peer-checked:shadow-lg peer-checked:shadow-orange-100 group-hover:border-slate-200">
                                    <span class="text-2xl">{{ $type['icon'] }}</span>
                                    <span class="text-[9px] font-black text-slate-600 uppercase tracking-tight text-center leading-tight">{{ $type['val'] }}</span>
                                </div>
                                <div class="absolute top-2 right-2 w-4 h-4 rounded-full bg-onpc-orange opacity-0 peer-checked:opacity-100 transition-opacity flex items-center justify-center">
                                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Description détaillée <span class="text-onpc-orange">*</span></label>
                        <textarea name="description" rows="4" required
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-medium text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/5 focus:border-onpc-blue focus:bg-white transition-all resize-none placeholder:text-slate-300"
                            placeholder="Décrivez avec précision la nature de l'incident, le nombre de victimes estimé, et tout autre élément utile aux secours...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Photos --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden" x-data="{}">
                <div class="px-8 py-5 border-b border-slate-50 flex items-center gap-3 bg-gradient-to-r from-slate-50 to-white">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Preuves visuelles</h2>
                        <p class="text-[10px] text-slate-400 font-bold">Photos de la scène (optionnel, max 2)</p>
                    </div>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-2 gap-4">
                        @foreach([1, 2] as $i)
                        <div>
                            <div class="relative w-full h-40 border-2 border-dashed border-slate-200 rounded-2xl overflow-hidden bg-slate-50 transition-all group hover:border-onpc-blue cursor-pointer" @click="$refs.file{{ $i }}.click()">
                                {{-- Empty state --}}
                                <div x-show="!previews[{{ $i }}]" class="absolute inset-0 flex flex-col items-center justify-center gap-3">
                                    <div class="flex gap-2">
                                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 shadow-sm flex items-center justify-center text-slate-400 group-hover:text-onpc-blue transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                        </div>
                                        <button type="button" @click.stop="startCamera({{ $i }})" class="w-10 h-10 rounded-xl bg-onpc-orange border border-onpc-orange shadow-sm flex items-center justify-center text-white hover:scale-110 transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </button>
                                    </div>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Preuve {{ $i }}</span>
                                </div>
                                {{-- Preview --}}
                                <img x-show="previews[{{ $i }}]" :src="previews[{{ $i }}]" class="absolute inset-0 w-full h-full object-cover">
                                {{-- Hover overlay (when image loaded) --}}
                                <div x-show="previews[{{ $i }}]" class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <div class="bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-xl">
                                        <span class="text-[9px] font-black text-white uppercase tracking-widest">Changer</span>
                                    </div>
                                </div>
                            </div>
                            <input type="file" name="image{{ $i }}" x-ref="file{{ $i }}" class="hidden" accept="image/*" capture="environment"
                                @change="previews[{{ $i }}] = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                        </div>
                        @endforeach
                    </div>

                    <!-- Camera Modal (Tailwind version) -->
                    <div x-show="cameraOpen" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/95 backdrop-blur-md">
                        <div class="w-full max-w-md flex flex-col items-center gap-8">
                            <div class="w-full aspect-[3/4] bg-black rounded-[2.5rem] overflow-hidden border-2 border-white/10 shadow-2xl relative">
                                <video x-ref="video" autoplay playsinline class="w-full h-full object-cover"></video>
                                <div class="absolute inset-0 border-[16px] border-black/20 pointer-events-none"></div>
                            </div>
                            <div class="flex items-center gap-12">
                                <button type="button" @click="stopCamera" class="w-14 h-14 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-white/20 transition-all">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                <button type="button" @click="capture" class="w-20 h-20 rounded-full border-4 border-white p-1 hover:scale-110 transition-all active:scale-95">
                                    <div class="w-full h-full bg-white rounded-full"></div>
                                </button>
                                <div class="w-14 h-14"></div> <!-- Spacer -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- COL DROITE (2/5) --}}
        {{-- ============================================================ --}}
        <div class="xl:col-span-2 space-y-6">

            {{-- Localisation --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50 flex items-center gap-3 bg-gradient-to-r from-slate-50 to-white">
                    <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Localisation</h2>
                        <p class="text-[9px] text-slate-400 font-bold">Position du sinistre</p>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Lieu exact <span class="text-onpc-orange">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="lieu" id="location-input" required value="{{ old('lieu') }}"
                                class="w-full pl-10 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/5 focus:border-onpc-blue focus:bg-white transition-all text-sm placeholder:font-normal placeholder:text-slate-300"
                                placeholder="Ex : Rue des Jardins, Cocody">
                        </div>
                    </div>

                    {{-- Coordonnées --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Latitude</label>
                            <input type="text" id="lat-input" name="latitude" readonly
                                value="{{ Auth::guard('structure')->user()->latitude ?? '5.3484' }}"
                                class="w-full px-4 py-3 bg-slate-100 border border-slate-100 rounded-xl font-bold text-slate-400 text-xs cursor-not-allowed">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Longitude</label>
                            <input type="text" id="lng-input" name="longitude" readonly
                                value="{{ Auth::guard('structure')->user()->longitude ?? '-4.0305' }}"
                                class="w-full px-4 py-3 bg-slate-100 border border-slate-100 rounded-xl font-bold text-slate-400 text-xs cursor-not-allowed">
                        </div>
                    </div>

                    {{-- Bouton GPS --}}
                    <button type="button" onclick="getCurrentLocation()"
                        class="w-full flex items-center justify-center gap-3 py-4 px-4 bg-onpc-blue/5 hover:bg-onpc-blue hover:text-white text-onpc-blue rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] transition-all group border border-onpc-blue/10 hover:border-onpc-blue hover:shadow-xl hover:shadow-blue-900/20">
                        <svg class="w-4 h-4 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Utiliser ma position actuelle
                    </button>

                    {{-- Info par défaut --}}
                    <div class="flex items-start gap-2 bg-blue-50 border border-blue-100 rounded-2xl p-4">
                        <svg class="w-4 h-4 text-onpc-blue mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-[9px] font-bold text-onpc-blue leading-relaxed">Les coordonnées sont pré-remplies avec la position de votre structure. Cliquez sur le bouton pour utiliser votre position GPS actuelle.</p>
                    </div>
                </div>
            </div>

            {{-- Récap & Envoi --}}
            <div class="bg-gradient-to-br from-onpc-orange to-orange-600 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl shadow-orange-500/20">
                <div class="absolute top-0 right-0 -mt-6 -mr-6 w-24 h-24 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 bg-black/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-6 border border-white/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <h3 class="text-sm font-black uppercase tracking-tight mb-2">Prêt à envoyer ?</h3>
                    <p class="text-orange-100/80 text-[10px] font-bold leading-relaxed mb-6">
                        L'alerte sera immédiatement transmise aux équipes de l'ONPC. Assurez-vous que les informations sont correctes avant de soumettre.
                    </p>

                    <button type="submit"
                        class="w-full bg-white text-onpc-orange hover:bg-orange-50 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.3em] transition-all hover:scale-[1.02] active:scale-[0.98] shadow-xl shadow-black/10 flex items-center justify-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Envoyer l'alerte
                    </button>
                </div>
            </div>

        </div>
    </div>
</form>

<script>
    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('lat-input').value = position.coords.latitude.toFixed(6);
                document.getElementById('lng-input').value = position.coords.longitude.toFixed(6);
            }, function(error) {
                alert("Impossible d'obtenir votre position : " + error.message);
            });
        } else {
            alert("La géolocalisation n'est pas supportée par votre navigateur.");
        }
    }
</script>

@endsection
