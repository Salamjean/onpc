@extends('admin.layouts.app')

@section('content')

{{-- Header --}}
<div class="mb-8 flex items-center justify-between">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.structure.index') }}"
               class="w-9 h-9 flex items-center justify-center bg-white rounded-xl shadow-sm border border-slate-100 hover:border-onpc-blue hover:text-onpc-blue text-slate-400 transition-all hover:-translate-x-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Partenaires / Nouvelle structure</span>
        </div>
        <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Ajouter une <span class="text-onpc-blue">Structure</span></h1>
    </div>
    <div class="hidden md:flex items-center gap-3">
        <div class="w-2 h-2 rounded-full bg-onpc-orange animate-pulse"></div>
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">OTP envoyé automatiquement</span>
    </div>
</div>

<form action="{{ route('admin.structure.store') }}" method="POST">
    @csrf

    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

        {{-- ============================================================ --}}
        {{-- COL GAUCHE : Formulaire (3/5) --}}
        {{-- ============================================================ --}}
        <div class="xl:col-span-3 space-y-6">

            {{-- Section Identité --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-50 flex items-center gap-3 bg-gradient-to-r from-slate-50 to-white">
                    <div class="w-9 h-9 rounded-xl bg-onpc-blue/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-onpc-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Identité de la structure</h2>
                        <p class="text-[10px] text-slate-400 font-bold">Informations principales du partenaire</p>
                    </div>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nom complet de la structure <span class="text-onpc-orange">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <input type="text" name="nom" required value="{{ old('nom') }}" placeholder="Ex: Croix Rouge de Côte d'Ivoire"
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/5 focus:border-onpc-blue focus:bg-white transition-all placeholder:font-normal placeholder:text-slate-300">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Contact <span class="text-onpc-orange">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <input type="tel" name="contact" required value="{{ old('contact') }}" placeholder="07 00 00 00 00"
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/5 focus:border-onpc-blue focus:bg-white transition-all placeholder:font-normal placeholder:text-slate-300">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email de gestion <span class="text-onpc-orange">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" name="email" required value="{{ old('email') }}" placeholder="contact@partenaire.ci"
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/5 focus:border-onpc-blue focus:bg-white transition-all placeholder:font-normal placeholder:text-slate-300">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section Localisation textuelle --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-50 flex items-center gap-3 bg-gradient-to-r from-slate-50 to-white">
                    <div class="w-9 h-9 rounded-xl bg-onpc-orange/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-onpc-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Localisation</h2>
                        <p class="text-[10px] text-slate-400 font-bold">Adresse physique & position GPS</p>
                    </div>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ville <span class="text-onpc-orange">*</span></label>
                        <input type="text" name="ville" required value="{{ old('ville') }}" placeholder="Abidjan"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/5 focus:border-onpc-blue focus:bg-white transition-all placeholder:font-normal placeholder:text-slate-300">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Commune <span class="text-onpc-orange">*</span></label>
                        <input type="text" name="commune" required value="{{ old('commune') }}" placeholder="Cocody"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/5 focus:border-onpc-blue focus:bg-white transition-all placeholder:font-normal placeholder:text-slate-300">
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Adresse complète (recherche GPS) <span class="text-onpc-orange">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" id="adresse" name="adresse" required value="{{ old('adresse') }}" placeholder="Saisissez l'adresse pour positionner sur la carte..."
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-800 outline-none focus:ring-4 focus:ring-onpc-blue/5 focus:border-onpc-blue focus:bg-white transition-all placeholder:font-normal placeholder:text-slate-300">
                        </div>
                        <p class="text-[9px] text-slate-400 font-bold ml-1 uppercase tracking-wider">↑ Utilisez la recherche pour positionner le marqueur sur la carte →</p>
                    </div>

                    {{-- Champs cachés GPS --}}
                    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', '5.3484') }}">
                    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', '-4.0305') }}">
                </div>
            </div>

            {{-- Bouton Submit --}}
            <div class="flex items-center justify-between pt-2">
                <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Un email d'activation sera envoyé automatiquement.</p>
                <button type="submit"
                    class="group relative inline-flex items-center gap-4 bg-onpc-blue hover:bg-slate-900 text-white px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.3em] shadow-2xl shadow-blue-900/20 transition-all hover:scale-105 active:scale-95 overflow-hidden">
                    <span class="relative z-10">Créer la structure</span>
                    <div class="relative z-10 bg-white/20 p-1.5 rounded-lg group-hover:translate-x-1 transition-transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                    {{-- Shine --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                </button>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- COL DROITE : Carte + Infos (2/5) --}}
        {{-- ============================================================ --}}
        <div class="xl:col-span-2 space-y-6">

            {{-- Carte --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50 flex items-center justify-between bg-gradient-to-r from-slate-50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Carte GPS</h2>
                            <p class="text-[9px] text-slate-400 font-bold">Glissez le marqueur pour affiner</p>
                        </div>
                    </div>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Live</span>
                    </span>
                </div>
                <div class="relative">
                    <div id="map" class="w-full h-80 lg:h-96"></div>
                    {{-- Overlay badge coordonnées --}}
                    <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-2 rounded-xl shadow-lg border border-slate-100 text-[9px] font-black text-slate-500 uppercase tracking-tight" id="coord-badge">
                        Lat: <span id="display-lat">5.3484</span> | Lng: <span id="display-lng">-4.0305</span>
                    </div>
                </div>
            </div>

            {{-- Infos panel --}}
            <div class="bg-gradient-to-br from-onpc-blue to-slate-900 rounded-3xl p-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-onpc-orange/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-6 border border-white/20">
                        <svg class="w-6 h-6 text-onpc-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="text-sm font-black uppercase tracking-tight mb-3">Processus d'activation</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-xl bg-onpc-orange text-white flex items-center justify-center text-[10px] font-black shrink-0">1</div>
                            <p class="text-[10px] font-bold text-blue-100/80 uppercase tracking-wider">Formulaire soumis</p>
                        </div>
                        <div class="w-px h-4 bg-white/10 ml-3.5"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-xl bg-white/10 border border-white/20 text-white flex items-center justify-center text-[10px] font-black shrink-0">2</div>
                            <p class="text-[10px] font-bold text-blue-100/40 uppercase tracking-wider">Email OTP envoyé</p>
                        </div>
                        <div class="w-px h-4 bg-white/10 ml-3.5"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-xl bg-white/10 border border-white/20 text-white flex items-center justify-center text-[10px] font-black shrink-0">3</div>
                            <p class="text-[10px] font-bold text-blue-100/40 uppercase tracking-wider">Structure active</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

{{-- Scripts Google Maps --}}
<script>
    let map, marker, autocomplete;

    function initMap() {
        const lat = parseFloat(document.getElementById('latitude').value) || 5.3484;
        const lng = parseFloat(document.getElementById('longitude').value) || -4.0305;
        const pos = { lat, lng };

        map = new google.maps.Map(document.getElementById("map"), {
            center: pos,
            zoom: 13,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false,
            styles: [
                { featureType: "all", elementType: "geometry.fill", stylers: [{ weight: "2.00" }] },
                { featureType: "landscape", elementType: "all", stylers: [{ color: "#f2f2f2" }] },
                { featureType: "landscape", elementType: "geometry.fill", stylers: [{ color: "#f8f8f8" }] },
                { featureType: "poi", elementType: "all", stylers: [{ visibility: "off" }] },
                { featureType: "road", elementType: "all", stylers: [{ saturation: -100 }, { lightness: 45 }] },
                { featureType: "road.highway", elementType: "all", stylers: [{ visibility: "simplified" }] },
                { featureType: "transit", elementType: "all", stylers: [{ visibility: "off" }] },
                { featureType: "water", elementType: "geometry.fill", stylers: [{ color: "#c8d7d4" }] },
            ]
        });

        marker = new google.maps.Marker({
            position: pos,
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
        });

        function updateCoords(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            document.getElementById('display-lat').textContent = lat.toFixed(5);
            document.getElementById('display-lng').textContent = lng.toFixed(5);
        }

        google.maps.event.addListener(marker, 'dragend', function(evt) {
            updateCoords(evt.latLng.lat(), evt.latLng.lng());
        });

        const input = document.getElementById("adresse");
        autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo("bounds", map);

        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (!place.geometry?.location) return;
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            marker.setAnimation(google.maps.Animation.DROP);
            updateCoords(place.geometry.location.lat(), place.geometry.location.lng());
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap" async defer></script>

@endsection
