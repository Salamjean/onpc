@extends('admin.layouts.app')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-onpc-blue to-blue-600">
                Ajouter une Caserne</h1>
            <p class="text-gray-500 mt-2 font-medium">Enregistrez une nouvelle caserne avec sa localisation géographique et
                ses accès.</p>
        </div>
        <a href="{{ route('admin.caserne.index') }}"
            class="group flex items-center bg-white border border-gray-200 hover:border-onpc-blue/30 hover:bg-blue-50/50 text-gray-700 px-5 py-2.5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
            <div class="bg-gray-100 group-hover:bg-onpc-blue/10 p-1.5 rounded-lg mr-3 transition-colors">
                <svg class="w-4 h-4 text-gray-500 group-hover:text-onpc-blue transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </div>
            <span class="font-semibold text-sm">Retour à la liste</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-onpc-blue/5 border border-gray-100 overflow-hidden relative">
        <!-- Decorative top gradient -->
        <div class="h-2 w-full bg-gradient-to-r from-onpc-blue via-blue-500 to-onpc-orange"></div>

        <div class="p-6 sm:p-10">
            <form action="{{ route('admin.caserne.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Colonne 1: Informations générales -->
                    <div class="space-y-6">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-50 p-2.5 rounded-xl mr-3">
                                <svg class="w-6 h-6 text-onpc-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Générales</h2>
                        </div>

                        <div class="space-y-5 bg-gray-50/50 p-6 rounded-2xl border border-gray-100/80">
                            <!-- Nom de la caserne -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nom de la Caserne
                                    <span class="text-onpc-orange">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                        class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-onpc-orange/20 focus:border-onpc-orange sm:text-sm text-gray-800 transition-all duration-200 shadow-sm @error('name') border-red-500 focus:ring-red-500/20 focus:border-red-500 @enderror"
                                        placeholder="Ex: Centre de Cocody">
                                </div>
                                @error('name') <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Téléphone -->
                            <div>
                                <label for="telephone" class="block text-sm font-semibold text-gray-700 mb-1.5">Téléphone
                                    <span class="text-onpc-orange">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}"
                                        required
                                        class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-onpc-orange/20 focus:border-onpc-orange sm:text-sm text-gray-800 transition-all duration-200 shadow-sm @error('telephone') border-red-500 focus:ring-red-500/20 focus:border-red-500 @enderror"
                                        placeholder="Ex: 01 02 03 04 05">
                                </div>
                                @error('telephone') <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Commune -->
                            <div>
                                <label for="commune" class="block text-sm font-semibold text-gray-700 mb-1.5">Commune <span
                                        class="text-onpc-orange">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="commune" name="commune" value="{{ old('commune') }}" required
                                        class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-onpc-orange/20 focus:border-onpc-orange sm:text-sm text-gray-800 transition-all duration-200 shadow-sm @error('commune') border-red-500 focus:ring-red-500/20 focus:border-red-500 @enderror"
                                        placeholder="Ex: Cocody">
                                </div>
                                @error('commune') <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Colonne 2: Sécurité et Média -->
                    <div class="space-y-6">
                        <div class="flex items-center mb-6">
                            <div class="bg-orange-50 p-2.5 rounded-xl mr-3">
                                <svg class="w-6 h-6 text-onpc-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Sécurité & Logo</h2>
                        </div>

                        <div class="space-y-5 bg-gray-50/50 p-6 rounded-2xl border border-gray-100/80">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Identifiant
                                    (Email) <span class="text-onpc-orange">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                        class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-onpc-orange/20 focus:border-onpc-orange sm:text-sm text-gray-800 transition-all duration-200 shadow-sm @error('email') border-red-500 focus:ring-red-500/20 focus:border-red-500 @enderror"
                                        placeholder="Ex: cocody@onpc.ci">
                                </div>
                                @error('email') <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Le mot de passe sera défini par la caserne via un code OTP envoyé par email -->
                            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-onpc-blue shrink-0 mt-0.5 mr-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-xs text-blue-800 leading-relaxed">
                                        Un code de vérification (OTP) sera envoyé à cette adresse email pour permettre au
                                        responsable de la caserne de définir son mot de passe en toute sécurité.
                                    </p>
                                </div>
                            </div>

                            <!-- Logo -->
                            <div class="pt-2">
                                <label for="logo" class="block text-sm font-semibold text-gray-700 mb-2">Logo
                                    (Facultatif)</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="logo"
                                        class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-white hover:bg-gray-50 transition-colors group">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-6 h-6 mb-2 text-gray-400 group-hover:text-onpc-orange transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12">
                                                </path>
                                            </svg>
                                            <p class="text-xs text-gray-500 text-center px-2"><span
                                                    class="font-semibold text-onpc-blue">Cliquer</span> ou glisser l'image
                                            </p>
                                        </div>
                                        <input id="logo" name="logo" type="file" class="hidden"
                                            accept="image/png, image/jpeg, image/jpg"
                                            onchange="document.getElementById('fileName').textContent = this.files[0].name" />
                                    </label>
                                </div>
                                <p id="fileName" class="text-xs font-medium text-onpc-blue mt-2 text-center"></p>
                                @error('logo') <p class="mt-1.5 text-xs font-medium text-red-600 text-center">{{ $message }}
                                </p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Colonne 3: Localisation -->
                    <div class="space-y-6">

                        <div class="flex items-center mb-6">
                            <div class="bg-blue-50 p-2.5 rounded-xl mr-3">
                                <svg class="w-6 h-6 text-onpc-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Localisation</h2>
                        </div>

                        <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100/80 space-y-4 h-full">
                            <!-- Adresse & Carte -->
                            <div>
                                <label for="adresse" class="block text-sm font-semibold text-gray-700 mb-1.5">Adresse de
                                    recherche <span class="text-onpc-orange">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="adresse" name="adresse" value="{{ old('adresse') }}" required
                                        class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-onpc-blue/20 focus:border-onpc-blue sm:text-sm text-gray-800 transition-all duration-200 shadow-sm @error('adresse') border-red-500 focus:ring-red-500/20 focus:border-red-500 @enderror"
                                        placeholder="Chercher une adresse...">
                                </div>
                                @error('adresse') <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-start">
                                <svg class="w-4 h-4 text-onpc-orange mt-0.5 mr-1.5 shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-[11px] text-gray-500 leading-relaxed">Déplacez le marqueur rouge pour affiner
                                    la position de la caserne sur la carte.</p>
                            </div>

                            <!-- Map Container -->
                            <div
                                class="w-full h-64 lg:h-[350px] rounded-xl overflow-hidden border-2 border-white shadow-md relative z-0 group mt-4">
                                <div id="map" class="w-full h-full"></div>
                                <div
                                    class="absolute inset-0 bg-onpc-blue/5 pointer-events-none group-hover:bg-transparent transition-colors duration-300">
                                </div>
                            </div>

                            <!-- Champs cachés pour les coordonnées -->
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', '5.30966') }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', '-4.01266') }}">
                        </div>
                    </div>

                </div>

                <!-- Footer Action -->
                <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-between">
                    <p class="text-xs text-gray-400 font-medium hidden md:block">
                        Les champs marqués d'un <span class="text-onpc-orange text-sm">*</span> sont obligatoires.
                    </p>
                    <button type="submit"
                        class="w-full md:w-auto bg-gradient-to-r from-onpc-orange to-orange-500 hover:from-orange-600 hover:to-orange-500 text-white px-10 py-3.5 rounded-xl font-bold shadow-lg shadow-onpc-orange/20 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-onpc-orange flex items-center justify-center transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                            </path>
                        </svg>
                        Enregistrer la caserne
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Google Maps -->
    <script>
        let map;
        let marker;
        let autocomplete;

        function initMap() {
            // Coordonnées par défaut (Abidjan)
            const lat = parseFloat(document.getElementById('latitude').value) || 5.30966;
            const lng = parseFloat(document.getElementById('longitude').value) || -4.01266;
            const defaultPos = { lat: lat, lng: lng };

            // Style personnalisé pour la carte pour un look plus moderne
            const customMapStyle = [
                { "featureType": "administrative", "elementType": "geometry", "stylers": [{ "color": "#a7a7a7" }] },
                { "featureType": "administrative", "elementType": "labels.text.fill", "stylers": [{ "color": "#737373" }] },
                { "featureType": "landscape", "elementType": "geometry.fill", "stylers": [{ "color": "#efefef" }] },
                { "featureType": "poi", "elementType": "geometry.fill", "stylers": [{ "color": "#dadada" }] },
                { "featureType": "poi", "elementType": "labels.icon", "stylers": [{ "saturation": -100 }] },
                { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [{ "color": "#656565" }] },
                { "featureType": "road", "elementType": "labels.text.fill", "stylers": [{ "color": "#696969" }] },
                { "featureType": "road", "elementType": "labels.icon", "stylers": [{ "saturation": -100 }] },
                { "featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{ "color": "#ffffff" }] },
                { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{ "color": "#e0e0e0" }] },
                { "featureType": "road.arterial", "elementType": "geometry.fill", "stylers": [{ "color": "#ffffff" }] },
                { "featureType": "road.arterial", "elementType": "geometry.stroke", "stylers": [{ "color": "#d6d6d6" }] },
                { "featureType": "road.local", "elementType": "geometry.fill", "stylers": [{ "color": "#ffffff" }] },
                { "featureType": "road.local", "elementType": "geometry.stroke", "stylers": [{ "color": "#e0e0e0" }] },
                { "featureType": "water", "elementType": "geometry.fill", "stylers": [{ "color": "#c8d7d4" }] }
            ];

            // Initialiser la carte
            map = new google.maps.Map(document.getElementById("map"), {
                center: defaultPos,
                zoom: 13,
                mapTypeControl: false,
                streetViewControl: false,
                styles: customMapStyle,
                scrollwheel: false, // Prevents zooming when scrolling down the page
            });

            // Placer un marqueur déplaçable
            marker = new google.maps.Marker({
                position: defaultPos,
                map: map,
                draggable: true,
                title: "Position de la caserne",
                animation: google.maps.Animation.DROP
            });

            // Mettre à jour les champs cachés quand le marqueur est déplacé
            google.maps.event.addListener(marker, 'dragend', function (evt) {
                document.getElementById('latitude').value = evt.latLng.lat();
                document.getElementById('longitude').value = evt.latLng.lng();
            });

            // Autocomplétion pour le champ adresse
            const input = document.getElementById("adresse");
            autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo("bounds", map);

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();

                if (!place.geometry || !place.geometry.location) {
                    window.alert("Aucun détail trouvé pour l'adresse saisie.");
                    return;
                }

                // Déplacer la carte et le marqueur
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                marker.setAnimation(google.maps.Animation.DROP);

                // Mettre à jour les coordonnées
                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();
            });
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap"
        async defer></script>
@endsection