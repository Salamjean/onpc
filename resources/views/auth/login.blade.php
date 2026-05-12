<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ONPC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-onpc-blue { background-color: #0000cc; }
        .bg-onpc-orange { background-color: #ff8300; }
        .text-onpc-blue { color: #0000cc; }
        .text-onpc-orange { color: #ff8300; }
        .border-onpc-orange { border-color: #ff8300; }
        .btn-onpc {
            background-color: #ff8300;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-onpc:hover {
            background-color: #e67600;
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex items-center justify-center p-4">

    <div class="max-w-4xl w-full flex flex-col md:flex-row bg-white rounded-2xl shadow-2xl overflow-hidden">
        
        <!-- Panneau de gauche (Logo / Branding) -->
        <div class="md:w-1/2 bg-onpc-blue p-10 text-white flex flex-col justify-center items-center relative overflow-hidden">
            <!-- Cercles décoratifs -->
            <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 rounded-full bg-white opacity-5"></div>
            <div class="absolute bottom-0 left-0 -mb-24 -ml-24 w-80 h-80 rounded-full bg-onpc-orange opacity-10"></div>
            
            <div class="relative z-10 text-center">
                <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg border-4 border-onpc-orange p-2">
                    <!-- Placeholder pour le logo -->
                    <img src="{{ asset('assets/images/logo_onpc.png') }}" alt="">
                </div>
                <h1 class="text-3xl font-bold mb-4">Office National de la Protection Civile</h1>
                <p class="text-gray-200 text-lg">Portail d'administration et de gestion des sinistres.</p>
            </div>
        </div>

        <!-- Panneau de droite (Formulaire) -->
        <div class="md:w-1/2 p-10 sm:p-14 flex flex-col justify-center">
            <div class="mb-10 text-center md:text-left">
                <h2 class="text-3xl font-bold text-onpc-blue mb-2">Bienvenue</h2>
                <p class="text-gray-500">Connectez-vous à votre compte pour continuer.</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 border border-red-200">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-onpc-orange focus:border-onpc-orange sm:text-sm transition duration-150 ease-in-out" 
                            placeholder="admin@onpc.ci">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-onpc-orange focus:border-onpc-orange sm:text-sm transition duration-150 ease-in-out" 
                            placeholder="••••••••">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-onpc-orange transition duration-150 focus:outline-none">
                            <svg id="eyeIcon" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                            class="h-4 w-4 text-onpc-orange focus:ring-onpc-orange border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-onpc-blue hover:text-onpc-orange transition duration-150">
                            Mot de passe oublié ?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium btn-onpc focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-onpc-orange">
                        Se connecter
                    </button>
                </div>
            </form>
            
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} ONPC. Tous droits réservés.
                </p>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            // Basculer l'attribut type
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Changer l'icône (œil barré ou œil normal)
            if (type === 'password') {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            }
        });
    </script>
</body>
</html>
