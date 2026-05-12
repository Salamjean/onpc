@extends('admin.layouts.app')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-onpc-blue to-blue-600">
                Modifier la Caserne</h1>
            <p class="text-gray-500 mt-2 font-medium">Mettez à jour les informations de la caserne
                <strong>{{ $user->name }}</strong>.</p>
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
            <form action="{{ route('admin.caserne.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                    class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-onpc-orange/20 focus:border-onpc-orange sm:text-sm text-gray-800 transition-all duration-200 shadow-sm @error('name') border-red-500 @enderror">
                                @error('name') <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Téléphone -->
                            <div>
                                <label for="telephone" class="block text-sm font-semibold text-gray-700 mb-1.5">Téléphone
                                    <span class="text-onpc-orange">*</span></label>
                                <input type="text" id="telephone" name="telephone"
                                    value="{{ old('telephone', $user->telephone) }}" required
                                    class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-onpc-orange/20 focus:border-onpc-orange sm:text-sm text-gray-800 transition-all duration-200 shadow-sm @error('telephone') border-red-500 @enderror">
                                @error('telephone') <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Commune -->
                            <div>
                                <label for="commune" class="block text-sm font-semibold text-gray-700 mb-1.5">Commune <span
                                        class="text-onpc-orange">*</span></label>
                                <input type="text" id="commune" name="commune" value="{{ old('commune', $user->commune) }}"
                                    required
                                    class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-onpc-orange/20 focus:border-onpc-orange sm:text-sm text-gray-800 transition-all duration-200 shadow-sm @error('commune') border-red-500 @enderror">
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
                            <h2 class="text-xl font-bold text-gray-800">Compte & Logo</h2>
                        </div>

                        <div class="space-y-5 bg-gray-50/50 p-6 rounded-2xl border border-gray-100/80">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Identifiant
                                    (Email) <span class="text-onpc-orange">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    required
                                    class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-onpc-orange/20 focus:border-onpc-orange sm:text-sm text-gray-800 transition-all duration-200 shadow-sm @error('email') border-red-500 @enderror">
                                @error('email') <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Logo -->
                            <div class="pt-2">
                                <label for="logo" class="block text-sm font-semibold text-gray-700 mb-2">Logo de la
                                    caserne</label>
                                @if($user->logo)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $user->logo) }}" alt="Logo"
                                            class="h-20 w-20 object-cover rounded-xl border border-gray-200 shadow-sm">
                                    </div>
                                @endif
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
                                                    class="font-semibold text-onpc-blue">Changer</span> le logo</p>
                                        </div>
                                        <input id="logo" name="logo" type="file" class="hidden"
                                            accept="image/png, image/jpeg, image/jpg" />
                                    </label>
                                </div>
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

                        <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100/80 space-y-4">
                            <div>
                                <label for="adresse" class="block text-sm font-semibold text-gray-700 mb-1.5">Adresse <span
                                        class="text-onpc-orange">*</span></label>
                                <input type="text" id="adresse" name="adresse" value="{{ old('adresse', $user->adresse) }}"
                                    required
                                    class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-onpc-blue/20 focus:border-onpc-blue sm:text-sm text-gray-800 transition-all duration-200 shadow-sm @error('adresse') border-red-500 @enderror">
                            </div>

                            <!-- Map Container -->
                            <div
                                class="w-full h-64 rounded-xl overflow-hidden border-2 border-white shadow-md relative z-0 mt-4">
                                <div id="map" class="w-full h-full"></div>
                            </div>

                            <!-- Champs cachés pour les coordonnées -->
                            <input type="hidden" id="latitude" name="latitude"
                                value="{{ old('latitude', $user->latitude) }}">
                            <input type="hidden" id="longitude" name="longitude"
                                value="{{ old('longitude', $user->longitude) }}">
                        </div>
                    </div>

                </div>

                <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit"
                        class="bg-gradient-to-r from-onpc-blue to-blue-700 hover:from-blue-700 hover:to-onpc-blue text-white px-10 py-3.5 rounded-xl font-bold shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                        Mettre à jour la caserne
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
            const lat = parseFloat(document.getElementById('latitude').value) || 5.30966;
            const lng = parseFloat(document.getElementById('longitude').value) || -4.01266;
            const pos = { lat: lat, lng: lng };

            map = new google.maps.Map(document.getElementById("map"), {
                center: pos,
                zoom: 15,
                mapTypeControl: false,
                streetViewControl: false,
            });

            marker = new google.maps.Marker({
                position: pos,
                map: map,
                draggable: true,
            });

            google.maps.event.addListener(marker, 'dragend', function (evt) {
                document.getElementById('latitude').value = evt.latLng.lat();
                document.getElementById('longitude').value = evt.latLng.lng();
            });

            const input = document.getElementById("adresse");
            autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo("bounds", map);

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                if (!place.geometry) return;

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();
            });
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap"
        async defer></script>
@endsection