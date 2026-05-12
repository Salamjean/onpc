@extends('admin.layouts.app')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-onpc-blue to-blue-600">Détails de la Caserne</h1>
        <p class="text-gray-500 mt-2 font-medium">Fiche complète de la caserne <strong>{{ $user->name }}</strong>.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.caserne.edit', $user) }}" class="flex items-center bg-orange-50 text-onpc-orange hover:bg-onpc-orange hover:text-white px-5 py-2.5 rounded-xl font-bold transition-all duration-300 shadow-sm shadow-onpc-orange/10">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Modifier
        </a>
        <a href="{{ route('admin.caserne.index') }}" class="flex items-center bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-bold hover:bg-gray-50 transition-all duration-300">
            Retour
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Profil Card -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-3xl shadow-xl shadow-onpc-blue/5 border border-gray-100 overflow-hidden text-center p-8">
            <div class="inline-block relative">
                <div class="h-32 w-32 rounded-3xl bg-gradient-to-br from-onpc-blue to-blue-500 flex items-center justify-center text-white font-bold text-4xl shadow-xl overflow-hidden mb-6">
                    @if($user->logo)
                        <img src="{{ asset('storage/' . $user->logo) }}" alt="Logo" class="h-full w-full object-cover">
                    @else
                        {{ substr($user->name, 0, 1) }}
                    @endif
                </div>
                <div class="absolute -bottom-2 -right-2 bg-green-500 border-4 border-white h-8 w-8 rounded-full shadow-lg flex items-center justify-center" title="Compte actif">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-onpc-orange font-semibold text-sm mt-1 uppercase tracking-widest">{{ $user->commune }}</p>
            
            <div class="mt-8 pt-8 border-t border-gray-50 space-y-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Statut</span>
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full font-bold text-[10px] uppercase">Opérationnel</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Date d'inscription</span>
                    <span class="font-bold text-gray-700">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Dernière activité</span>
                    <span class="font-bold text-gray-700">Aujourd'hui</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-onpc-blue/5 border border-gray-100 p-8">
            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-3 text-onpc-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                Coordonnées
            </h3>
            <div class="space-y-6">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Email Officiel</p>
                    <p class="text-sm font-bold text-gray-700">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Téléphone</p>
                    <p class="text-sm font-bold text-gray-700">{{ $user->telephone ?? 'Non renseigné' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Adresse Géographique</p>
                    <p class="text-sm font-bold text-gray-700">{{ $user->adresse }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Map & Details -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white rounded-3xl shadow-xl shadow-onpc-blue/5 border border-gray-100 overflow-hidden relative">
            <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800">Localisation Géographique</h3>
                <div class="flex items-center gap-4">
                    <div class="flex gap-2">
                        <span class="bg-blue-50 text-onpc-blue text-[10px] font-bold px-3 py-1 rounded-lg">LAT: {{ round($user->latitude, 6) }}</span>
                        <span class="bg-blue-50 text-onpc-blue text-[10px] font-bold px-3 py-1 rounded-lg">LNG: {{ round($user->longitude, 6) }}</span>
                    </div>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $user->latitude }},{{ $user->longitude }}" target="_blank" class="flex items-center bg-green-50 text-green-700 hover:bg-green-600 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 shadow-sm shadow-green-100">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Ouvrir dans Google Maps
                    </a>
                </div>
            </div>
            <div class="h-[500px] w-full" id="map"></div>
        </div>
    </div>

</div>

<!-- Script Google Maps -->
<script>
    function initMap() {
        const pos = { lat: {{ $user->latitude ?? 5.30966 }}, lng: {{ $user->longitude ?? -4.01266 }} };
        
        const map = new google.maps.Map(document.getElementById("map"), {
            center: pos,
            zoom: 16,
            mapTypeControl: true,
            streetViewControl: true,
            styles: [
                { "featureType": "administrative", "elementType": "geometry", "stylers": [{"color": "#a7a7a7"}] },
                { "featureType": "landscape", "elementType": "geometry.fill", "stylers": [{"color": "#efefef"}] },
                { "featureType": "water", "elementType": "geometry.fill", "stylers": [{"color": "#c8d7d4"}] }
            ]
        });

        new google.maps.Marker({
            position: pos,
            map: map,
            title: "{{ $user->name }}",
            animation: google.maps.Animation.DROP
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
@endsection
