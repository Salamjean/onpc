<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - Caserne ONPC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .bg-caserne-dark { background-color: #0000cc; }
        .bg-caserne-red { background-color: #ff8300; }
        .text-caserne-red { color: #ff8300; }
        .border-caserne-red { border-color: #ff8300; }
        .focus-ring-red:focus { ring-color: #ff8300; border-color: #ff8300; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <!-- Ambient background blobs -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-orange-400/15 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>

    <div class="max-w-md w-full relative z-10">
        {{-- Logo/Header --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-3xl shadow-xl mb-6 border border-slate-100 p-4">
                <img src="{{ asset('assets/images/logo_onpc.png') }}" alt="Logo ONPC" class="w-full h-full object-contain">
            </div>
            <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Accès <span class="text-caserne-red">Sécurisé</span></h1>
            <p class="text-slate-500 font-bold text-sm mt-2 uppercase tracking-widest">Réinitialisation par OTP</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200 border border-slate-100 overflow-hidden">
            <div class="p-8 md:p-10">
                <p class="text-sm text-slate-600 font-medium leading-relaxed mb-8 text-center">
                    Saisissez l'adresse email professionnelle de la caserne. Un code de vérification vous sera envoyé.
                </p>

                @if (session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm font-bold text-emerald-700">{{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('caserne.auth.forgot.post') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Adresse Email Caserne</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-400 group-focus-within:text-caserne-red transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input type="email" name="email" required placeholder="caserne@onpc.ci"
                                class="w-full pl-14 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-slate-800 outline-none focus:ring-4 focus:ring-orange-500/5 focus:border-caserne-red focus:bg-white transition-all">
                        </div>
                        @error('email')
                            <p class="text-xs font-bold text-caserne-red mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                        class="w-full bg-caserne-red hover:bg-orange-600 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.3em] transition-all hover:scale-[1.02] active:scale-[0.98] shadow-xl shadow-orange-500/20">
                        Envoyer le code
                    </button>
                </form>

                <div class="mt-8 pt-8 border-t border-slate-50 text-center">
                    <a href="{{ route('caserne.auth.login') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-caserne-red transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Retour à la connexion
                    </a>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <p class="text-center mt-10 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
            &copy; {{ date('Y') }} Office National de la Protection Civile
        </p>
    </div>

</body>
</html>
