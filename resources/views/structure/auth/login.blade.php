<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Structure - ONPC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .bg-onpc-blue {
            background-color: #0000cc;
        }

        .bg-onpc-orange {
            background-color: #ff8300;
        }

        .text-onpc-blue {
            color: #0000cc;
        }

        .text-onpc-orange {
            color: #ff8300;
        }

        .border-onpc-orange {
            border-color: #ff8300;
        }

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

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">

    <div
        class="max-w-4xl w-full flex flex-col md:flex-row bg-white rounded-3xl shadow-2xl overflow-hidden border border-white">

        <!-- Panneau de gauche (Logo / Branding) -->
        <div
            class="md:w-1/2 bg-onpc-blue p-12 text-white flex flex-col justify-center items-center relative overflow-hidden">
            <!-- Cercles décoratifs -->
            <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 rounded-full bg-white opacity-5"></div>
            <div class="absolute bottom-0 left-0 -mb-24 -ml-24 w-80 h-80 rounded-full bg-onpc-orange opacity-10"></div>

            <div class="relative z-10 text-center">
                <div
                    class="w-32 h-32 bg-white rounded-full flex items-center justify-center mx-auto mb-8 shadow-lg border-4 border-onpc-orange p-3">
                    <img src="{{ asset('assets/images/logo_onpc.png') }}" alt="Logo ONPC" class="h-16">
                </div>
                <h1 class="text-3xl font-black uppercase tracking-tighter leading-tight mb-4">Espace <br>Partenaire</h1>
                <p class="text-blue-100 text-sm font-medium opacity-80 uppercase tracking-widest">Office National de la
                    Protection Civile</p>
            </div>
        </div>

        <!-- Panneau de droite (Formulaire) -->
        <div class="md:w-1/2 p-10 sm:p-14 flex flex-col justify-center bg-white">
            <div class="mb-10 text-center md:text-left">
                <h2 class="text-3xl font-black text-onpc-blue uppercase tracking-tighter mb-2">Bienvenue</h2>
                <p class="text-slate-400 font-medium">Connectez-vous à votre espace structure.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 rounded-2xl border border-green-100 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-[10px] font-black text-green-700 uppercase tracking-tighter">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 border border-red-200">
                    <ul class="list-none text-[10px] font-black uppercase tracking-tight">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('structure.auth.login.post') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="email"
                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Adresse
                        email</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-onpc-blue/5 focus:border-onpc-blue transition-all font-bold text-slate-800"
                            placeholder="contact@structure.ci">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password"
                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Mot de
                        passe</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="block w-full pl-12 pr-12 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-onpc-blue/5 focus:border-onpc-blue transition-all font-bold text-slate-800"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-onpc-orange focus:ring-onpc-orange border-slate-200 rounded-lg">
                        <label for="remember"
                            class="ml-2 block text-[10px] font-black text-slate-500 uppercase tracking-widest">
                            Se souvenir
                        </label>
                    </div>
                    <a href="{{ route('structure.auth.password.request') }}"
                        class="text-[10px] font-black text-onpc-blue hover:text-onpc-orange transition-colors uppercase tracking-widest">
                        Oublié ?
                    </a>
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-5 px-4 border border-transparent rounded-2xl shadow-xl shadow-blue-900/10 text-xs font-black uppercase tracking-[0.3em] btn-onpc focus:outline-none ring-offset-2 ring-onpc-orange transition-all hover:scale-[1.01] active:scale-[0.99]">
                    Se connecter
                </button>
            </form>

            <div class="mt-10 text-center">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">
                    &copy; {{ date('Y') }} ONPC. Sécurisé.
                </p>
            </div>
        </div>
    </div>
</body>

</html>