<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Mot de Passe - ONPC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .bg-onpc-blue { background-color: #0000cc; }
        .bg-onpc-orange { background-color: #ff8300; }
        .text-onpc-blue { color: #0000cc; }
        .text-onpc-orange { color: #ff8300; }
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

    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl overflow-hidden border border-white p-10 sm:p-14">
        
        <div class="mb-10 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <img src="{{ asset('assets/images/logo_onpc.png') }}" alt="Logo ONPC" class="h-10">
            </div>
            <h2 class="text-2xl font-black text-onpc-blue uppercase tracking-tighter mb-2">Nouveau mot de passe</h2>
            <p class="text-slate-400 font-medium text-sm">Définissez votre nouveau mot de passe sécurisé.</p>
        </div>

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

        <form action="{{ route('structure.auth.password.update') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="space-y-2">
                <label for="email" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Adresse email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required readonly
                        class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-onpc-blue/5 font-bold text-slate-400 cursor-not-allowed">
                </div>
            </div>

            <div class="space-y-2">
                <label for="password" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nouveau mot de passe</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" required autofocus
                        class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-onpc-blue/5 focus:border-onpc-blue transition-all font-bold text-slate-800" 
                        placeholder="••••••••">
                </div>
            </div>

            <div class="space-y-2">
                <label for="password_confirmation" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirmer le mot de passe</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:ring-4 focus:ring-onpc-blue/5 focus:border-onpc-blue transition-all font-bold text-slate-800" 
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="w-full flex justify-center py-5 px-4 border border-transparent rounded-2xl shadow-xl shadow-blue-900/10 text-xs font-black uppercase tracking-[0.3em] btn-onpc focus:outline-none transition-all hover:scale-[1.01]">
                Mettre à jour
            </button>
        </form>
    </div>
</body>
</html>
