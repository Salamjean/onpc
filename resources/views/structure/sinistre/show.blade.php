@extends('structure.layouts.app')

@section('content')

{{-- Header --}}
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('structure.sinistre.index') }}"
               class="w-9 h-9 flex items-center justify-center bg-white rounded-xl shadow-sm border border-slate-100 hover:border-onpc-blue hover:text-onpc-blue text-slate-400 transition-all hover:-translate-x-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Historique / Détails Alerte</span>
        </div>
        <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Suivi de l'alerte <span class="text-onpc-blue">{{ $sinistre->reference }}</span></h1>
    </div>

    @if(!in_array($sinistre->status, ['resolu', 'termine']))
    <form action="{{ route('structure.sinistre.escalate', $sinistre) }}" method="POST" onsubmit="return confirm('Confirmez-vous l\'aggravation critique de la situation ? Cela enverra un flash prioritaire aux secours.')">
        @csrf
        <button type="submit" class="group flex items-center gap-3 bg-red-600 hover:bg-red-700 text-white px-6 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-xl shadow-red-500/30">
            <div class="w-2 h-2 rounded-full bg-white animate-ping"></div>
            Signalement Aggravation Critique
        </button>
    </form>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ============================================================ --}}
    {{-- COL GAUCHE : LIVE TRACKING & INFO (2/3) --}}
    {{-- ============================================================ --}}
    <div class="lg:col-span-2 space-y-8">

        {{-- Barre de progression Live --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Progression de l'intervention</h2>
                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-blue-100 animate-pulse">Temps Réel</span>
            </div>

            <div class="relative">
                {{-- Line --}}
                <div class="absolute top-5 left-5 right-5 h-1 bg-slate-100 rounded-full">
                    @php
                        $progress = 0;
                        if($sinistre->status == 'en_attente') $progress = 25;
                        if($sinistre->status == 'en_cours') $progress = 60;
                        if(in_array($sinistre->status, ['resolu', 'termine'])) $progress = 100;
                    @endphp
                    <div class="h-full bg-onpc-blue transition-all duration-1000" style="width: {{ $progress }}%"></div>
                </div>

                {{-- Points --}}
                <div class="relative flex justify-between">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl {{ $progress >= 0 ? 'bg-onpc-blue text-white' : 'bg-white border border-slate-200 text-slate-300' }} flex items-center justify-center shadow-lg relative z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest {{ $progress >= 0 ? 'text-onpc-blue' : 'text-slate-400' }}">Alerté</span>
                    </div>

                    <div class="flex flex-col items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl {{ $progress >= 25 ? 'bg-onpc-blue text-white' : 'bg-white border border-slate-200 text-slate-300' }} flex items-center justify-center shadow-lg relative z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest {{ $progress >= 25 ? 'text-onpc-blue' : 'text-slate-400' }}">Assigné</span>
                    </div>

                    <div class="flex flex-col items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl {{ $progress >= 60 ? 'bg-onpc-orange text-white' : 'bg-white border border-slate-200 text-slate-300' }} flex items-center justify-center shadow-lg relative z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest {{ $progress >= 60 ? 'text-onpc-orange' : 'text-slate-400' }}">Sur les lieux</span>
                    </div>

                    <div class="flex flex-col items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl {{ $progress >= 100 ? 'bg-green-500 text-white' : 'bg-white border border-slate-200 text-slate-300' }} flex items-center justify-center shadow-lg relative z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest {{ $progress >= 100 ? 'text-green-500' : 'text-slate-400' }}">Résolu</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Carte Google Maps --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden h-[400px] relative">
            <div id="map" class="w-full h-full"></div>
            
            {{-- Infos de distance flottantes --}}
            @if($sinistre->caserneAssignee)
            <div class="absolute bottom-6 left-6 bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-white flex items-center gap-4 z-10">
                <div class="w-10 h-10 bg-onpc-blue rounded-xl flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9a1 1 0 01-1-1v-5a1 1 0 011-1h2a1 1 0 011 1v5zm3 2a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a1 1 0 011-1h3a1 1 0 011 1v1z"/></svg>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Caserne → Sinistre</p>
                    <p class="text-sm font-black text-slate-800 uppercase" id="distance-info">Calcul de l'itinéraire...</p>
                </div>
            </div>
            @endif
        </div>

        {{-- Détails de l'incident --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-slate-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">Rapport de déclaration</h2>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nature de l'urgence</p>
                        <p class="text-lg font-black text-onpc-blue uppercase">{{ $sinistre->type_sinistre }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Lieu signalé</p>
                        <p class="text-sm font-bold text-slate-700 leading-relaxed">{{ $sinistre->lieu }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Description initiale</p>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <p class="text-xs font-medium text-slate-600 italic whitespace-pre-line leading-relaxed">{{ $sinistre->description }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Caserne en charge</p>
                        @if($sinistre->caserneAssignee)
                            <div class="flex items-center gap-3 p-4 bg-blue-50 border border-blue-100 rounded-2xl">
                                <div class="w-10 h-10 bg-onpc-blue text-white rounded-xl flex items-center justify-center font-black">
                                    {{ substr($sinistre->caserneAssignee->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-800 uppercase leading-none mb-1">{{ $sinistre->caserneAssignee->name }}</p>
                                    <p class="text-[9px] font-bold text-blue-500 uppercase tracking-widest">En intervention</p>
                                </div>
                            </div>
                        @else
                            <div class="p-4 bg-orange-50 border border-orange-100 rounded-2xl flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-orange-500 animate-ping"></div>
                                <span class="text-xs font-bold text-orange-600">Recherche de la caserne la plus proche...</span>
                            </div>
                        @endif
                    </div>

                    @if($sinistre->image1)
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Preuve visuelle</p>
                        <img src="{{ Storage::url($sinistre->image1) }}" class="w-full h-48 object-cover rounded-3xl border border-slate-200">
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ============================================================ --}}
    {{-- COL DROITE : PROTOCOLE DE SECURITE (1/3) --}}
    {{-- ============================================================ --}}
    <div class="space-y-8">

        {{-- Checklist Innovation --}}
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-[2.5rem] shadow-2xl p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-onpc-blue/20 rounded-full blur-3xl -mr-16 -mt-16"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-onpc-orange rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-tight">Protocole Sécurité</h3>
                        <p class="text-[9px] text-white/40 font-bold uppercase tracking-widest">Action immédiate requise</p>
                    </div>
                </div>

                <p class="text-[10px] font-medium text-white/60 leading-relaxed mb-6 italic">
                    En attendant l'arrivée des secours ({{ $sinistre->caserneAssignee->name ?? 'ONPC' }}), veuillez suivre ces consignes de sécurité :
                </p>

                <div class="space-y-4" x-data="{ checked: [] }">
                    @foreach($protocol as $index => $item)
                    <label class="flex items-start gap-4 p-4 rounded-2xl border border-white/5 bg-white/5 hover:bg-white/10 transition-all cursor-pointer group">
                        <div class="relative flex items-center mt-0.5">
                            <input type="checkbox" class="w-5 h-5 rounded-lg border-2 border-white/20 bg-transparent checked:bg-onpc-orange checked:border-onpc-orange transition-all cursor-pointer appearance-none peer">
                            <svg class="w-3 h-3 text-white absolute left-1 opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-xs font-bold leading-relaxed peer-checked:text-white/40 peer-checked:line-through transition-all">{{ $item }}</span>
                    </label>
                    @endforeach
                </div>

                <div class="mt-8 pt-6 border-t border-white/5 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-[9px] font-bold text-white/40 uppercase tracking-widest leading-relaxed">
                        Ces consignes sont générées automatiquement selon la nature de l'incident.
                    </p>
                </div>
            </div>
        </div>

        {{-- Aide & Contact --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Besoin d'assistance ?</h4>
            <div class="space-y-4">
                <a href="tel:180" class="flex items-center gap-4 p-4 bg-onpc-blue text-white rounded-2xl hover:scale-[1.02] transition-all shadow-lg shadow-blue-900/20">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase leading-none mb-1">Standard ONPC</p>
                        <p class="text-xl font-black">180 / 185</p>
                    </div>
                </a>
            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
<script>
    function initMap() {
        const sinistreLoc = { 
            lat: {{ $sinistre->latitude }}, 
            lng: {{ $sinistre->longitude }} 
        };
        
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: sinistreLoc,
            styles: [
                { "featureType": "water", "elementType": "geometry", "stylers": [{ "color": "#e9e9e9" }, { "lightness": 17 }] },
                { "featureType": "landscape", "elementType": "geometry", "stylers": [{ "color": "#f5f5f5" }, { "lightness": 20 }] },
                { "featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{ "color": "#ffffff" }, { "lightness": 17 }] },
                { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{ "color": "#ffffff" }, { "lightness": 29 }, { "weight": 0.2 }] },
                { "featureType": "road.arterial", "elementType": "geometry", "stylers": [{ "color": "#ffffff" }, { "lightness": 18 }] },
                { "featureType": "road.local", "elementType": "geometry", "stylers": [{ "color": "#ffffff" }, { "lightness": 16 }] },
                { "featureType": "poi", "elementType": "geometry", "stylers": [{ "color": "#f5f5f5" }, { "lightness": 21 }] },
                { "featureType": "poi.park", "elementType": "geometry", "stylers": [{ "color": "#dedede" }, { "lightness": 21 }] },
                { "elementType": "labels.text.stroke", "stylers": [{ "visibility": "on" }, { "color": "#ffffff" }, { "lightness": 16 }] },
                { "elementType": "labels.text.fill", "stylers": [{ "saturation": 36 }, { "color": "#333333" }, { "lightness": 40 }] },
                { "elementType": "labels.icon", "stylers": [{ "visibility": "off" }] },
                { "featureType": "transit", "elementType": "geometry", "stylers": [{ "color": "#f2f2f2" }, { "lightness": 19 }] },
                { "featureType": "administrative", "elementType": "geometry.fill", "stylers": [{ "color": "#fefefe" }, { "lightness": 20 }] },
                { "featureType": "administrative", "elementType": "geometry.stroke", "stylers": [{ "color": "#fefefe" }, { "lightness": 17 }, { "weight": 1.2 }] }
            ]
        });

        // Marqueur Sinistre
        new google.maps.Marker({
            position: sinistreLoc,
            map: map,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 12,
                fillColor: "#ef4444",
                fillOpacity: 1,
                strokeWeight: 4,
                strokeColor: "#ffffff",
            },
            title: "Lieu du sinistre"
        });

        @if($sinistre->caserneAssignee && $sinistre->caserneAssignee->latitude)
            const caserneLoc = { 
                lat: {{ $sinistre->caserneAssignee->latitude }}, 
                lng: {{ $sinistre->caserneAssignee->longitude }} 
            };

            // Marqueur Caserne
            new google.maps.Marker({
                position: caserneLoc,
                map: map,
                icon: {
                    path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
                    scale: 7,
                    fillColor: "#0000cc",
                    fillOpacity: 1,
                    strokeWeight: 2,
                    strokeColor: "#ffffff",
                },
                title: "Caserne"
            });

            // Itinéraire
            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true,
                polylineOptions: {
                    strokeColor: "#ff8300",
                    strokeWeight: 6,
                    strokeOpacity: 0.9
                }
            });

            directionsService.route({
                origin: caserneLoc,
                destination: sinistreLoc,
                travelMode: google.maps.TravelMode.DRIVING,
            }, (response, status) => {
                if (status === "OK") {
                    directionsRenderer.setDirections(response);
                    const route = response.routes[0].legs[0];
                    document.getElementById('distance-info').innerText = route.distance.text + " (" + route.duration.text + ")";
                }
            });
        @endif
    }
</script>
@endpush
