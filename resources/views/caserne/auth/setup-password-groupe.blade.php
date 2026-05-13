<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation Groupe - ONPC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }

        .bg-onpc-dark {
            background-color: #0000cc;
        }

        .bg-onpc-accent {
            background-color: #ff8300;
        }

        .text-onpc-accent {
            color: #ff8300;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-6 relative overflow-hidden bg-slate-50">

    <div class="absolute -top-24 -right-24 w-96 h-96 bg-orange-400/15 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>

    <div
        class="max-w-5xl w-full bg-white rounded-[2.5rem] flex flex-col md:flex-row shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden min-h-[650px]">

        <div
            class="w-full md:w-[45%] bg-onpc-dark p-12 flex flex-col justify-between relative overflow-hidden text-white">
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-orange-300/30 rounded-full blur-2xl"></div>

            <div class="relative z-10">
                <div class="bg-white/10 backdrop-blur-md p-4 w-20 h-20 rounded-2xl border border-white/20 mb-10">
                    <img src="{{ asset('assets/images/logo_onpc.png') }}" alt="Logo ONPC"
                        class="w-full h-full object-contain">
                </div>
                <h1 class="text-4xl font-extrabold tracking-tight leading-[1.1]">
                    Activation <br> <span class="text-onpc-accent">Groupe</span>
                </h1>
                <p class="text-blue-100/80 mt-6 text-base font-medium leading-relaxed">
                    Definissez votre mot de passe pour acceder a votre espace groupe d'intervention.
                </p>
            </div>

            <div class="relative z-10 mt-12 space-y-6">
                <div class="flex items-center gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-onpc-accent flex items-center justify-center font-bold text-sm shadow-lg shadow-orange-500/20">
                        01</div>
                    <p class="text-sm font-bold text-blue-100/90 uppercase tracking-widest">Code OTP</p>
                </div>
                <div class="flex items-center gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center font-bold text-sm">
                        02</div>
                    <p class="text-sm font-bold text-blue-100/70 uppercase tracking-widest">Mot de passe</p>
                </div>
            </div>
        </div>

        <div class="w-full md:w-[55%] p-12 md:p-16 flex flex-col justify-center" x-data="{ showPass: false, showConfirm: false }">
            <div class="mb-10 text-center md:text-left">
                <h2 class="text-4xl font-black text-slate-900 tracking-tight">Activation Groupe</h2>
                <p class="text-slate-500 font-medium mt-2">Finalisez votre acces avec le code OTP recu par email</p>
            </div>

            @if ($errors->any())
                <div class="mb-8 bg-orange-50 border-l-4 border-onpc-accent p-4 rounded-xl">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm font-bold text-onpc-accent">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('caserne.auth.groupe.setup-submit') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="space-y-2">
                    <label for="otp_code" class="text-sm font-bold text-slate-700 ml-1">Code OTP (Email)</label>
                    <input type="text" id="otp_code" name="otp_code" required maxlength="6"
                        class="block w-full px-6 py-5 bg-slate-50 border border-slate-200 rounded-2xl outline-none text-slate-900 font-bold text-center text-2xl tracking-[0.6em] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 focus:bg-white transition-all"
                        placeholder="000000">
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-sm font-bold text-slate-700 ml-1">Nouveau mot de passe</label>
                    <div class="relative group">
                        <input :type="showPass ? 'text' : 'password'" id="password" name="password" required
                            class="block w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none text-slate-900 font-semibold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 focus:bg-white transition-all"
                            placeholder="********">
                        <button type="button" @click="showPass = !showPass"
                            class="absolute inset-y-0 right-0 pr-6 flex items-center text-slate-400 hover:text-onpc-accent transition-colors">
                            <svg x-show="!showPass" class="w-6 h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            <svg x-show="showPass" x-cloak class="w-6 h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 014.015-4.015m6.209-6.209A10.012 10.012 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-6-6l-3-3m0 0l-3-3m3 3l3 3.5m-9-3.5L3 3">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation"
                        class="text-sm font-bold text-slate-700 ml-1">Confirmation</label>
                    <div class="relative group">
                        <input :type="showConfirm ? 'text' : 'password'" id="password_confirmation"
                            name="password_confirmation" required
                            class="block w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none text-slate-900 font-semibold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 focus:bg-white transition-all"
                            placeholder="********">
                        <button type="button" @click="showConfirm = !showConfirm"
                            class="absolute inset-y-0 right-0 pr-6 flex items-center text-slate-400 hover:text-onpc-accent transition-colors">
                            <svg x-show="!showConfirm" class="w-6 h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            <svg x-show="showConfirm" x-cloak class="w-6 h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 014.015-4.015m6.209-6.209A10.012 10.012 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-6-6l-3-3m0 0l-3-3m3 3l3 3.5m-9-3.5L3 3">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-onpc-accent hover:bg-blue-900 text-white font-bold py-4 rounded-2xl text-lg transition-all transform active:scale-[0.98] shadow-xl shadow-orange-500/20">
                    Confirmer l'activation
                </button>
            </form>
        </div>
    </div>

</body>

</html>
