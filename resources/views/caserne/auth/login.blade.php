<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Caserne - ONPC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .bg-caserne-dark { background-color: #111827; }
        .bg-caserne-red { background-color: #b91c1c; }
        .text-caserne-red { color: #b91c1c; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6 relative overflow-hidden bg-slate-50">

    <!-- Ambient background blobs -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-caserne-red/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-caserne-dark/5 rounded-full blur-3xl"></div>

    <div class="max-w-5xl w-full bg-white rounded-[2.5rem] flex flex-col md:flex-row shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden min-h-[650px]">
        
        <!-- Left Side: Brand Panel -->
        <div class="w-full md:w-[45%] bg-caserne-dark p-12 flex flex-col justify-between relative overflow-hidden text-white">
            <!-- Decorative circle -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-caserne-red/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10">
                <div class="bg-white/10 backdrop-blur-md p-4 w-20 h-20 rounded-2xl border border-white/20 mb-10">
                    <img src="{{ asset('assets/images/logo_onpc.png') }}" alt="Logo ONPC" class="w-full h-full object-contain">
                </div>
                <h1 class="text-5xl font-extrabold tracking-tight leading-[1.1]">
                    Espace <br> <span class="text-caserne-red">Opérationnel</span>
                </h1>
                <p class="text-slate-400 mt-6 text-lg font-medium leading-relaxed max-w-xs">
                    Gérez vos interventions et vos ressources en temps réel.
                </p>
            </div>

            <div class="relative z-10 pt-12">
                <div class="flex items-center gap-3 text-sm font-semibold text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-caserne-red animate-pulse"></span>
                    Système de Commandement ONPC
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full md:w-[55%] p-12 md:p-16 flex flex-col justify-center" x-data="{ showPassword: false }">
            <div class="mb-10 text-center md:text-left">
                <h2 class="text-4xl font-black text-slate-900 tracking-tight">Bienvenue</h2>
                <p class="text-slate-500 font-medium mt-2">Accédez à votre espace sécurisé caserne</p>
            </div>

            @if($errors->any())
                <div class="mb-8 bg-red-50 border-l-4 border-caserne-red p-4 rounded-xl">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm font-bold text-caserne-red">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('caserne.auth.login-submit') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label for="email" class="text-sm font-bold text-slate-700 ml-1">Adresse Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-400 group-focus-within:text-caserne-red transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="block w-full pl-14 pr-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none text-slate-900 font-semibold focus:ring-4 focus:ring-caserne-red/10 focus:border-caserne-red focus:bg-white transition-all"
                            placeholder="caserne@onpc.ci">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label for="password" class="text-sm font-bold text-slate-700">Mot de passe</label>
                        <a href="#" class="text-xs font-bold text-caserne-red hover:underline">Oublié ?</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-400 group-focus-within:text-caserne-red transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                            class="block w-full pl-14 pr-16 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none text-slate-900 font-semibold focus:ring-4 focus:ring-caserne-red/10 focus:border-caserne-red focus:bg-white transition-all"
                            placeholder="********">
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-6 flex items-center text-slate-400 hover:text-caserne-red transition-colors">
                            <svg x-show="!showPassword" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg x-show="showPassword" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 014.015-4.015m6.209-6.209A10.012 10.012 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-6-6l-3-3m0 0l-3-3m3 3l3 3.5m-9-3.5L3 3"></path></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-caserne-red hover:bg-slate-900 text-white font-bold py-4 rounded-2xl text-lg transition-all transform active:scale-[0.98] shadow-xl shadow-red-500/20">
                    Se Connecter
                </button>
            </form>

            <div class="mt-12 text-center">
                <p class="text-sm font-medium text-slate-500">
                    Première connexion ? 
                    <a href="{{ route('caserne.auth.setup-form') }}" class="text-caserne-red font-bold hover:underline ml-1">Activer mon compte</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
