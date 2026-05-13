@extends('groupe.layouts.app')

@section('content')
    <div class="mb-8 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight uppercase">
                Tableau de Bord <span class="text-onpc-orange">Groupe</span>
            </h1>
            <p class="text-slate-500 mt-3 font-bold text-xs flex items-center gap-2 uppercase tracking-widest">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                Actualisation automatique toutes les 10 secondes
            </p>
        </div>

        <div class="flex gap-4 flex-wrap">
            <div class="bg-white px-6 py-4 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sinistres visibles</p>
                <p class="text-3xl font-black text-slate-900 mt-2" id="visible-counter">{{ $sinistres->count() }}</p>
            </div>

            <div class="bg-white px-6 py-4 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Prochaine mise à jour</p>
                <p class="text-3xl font-black text-slate-900 mt-2" id="refresh-counter">10</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Groupe</p>
            <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $groupe->name }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Caserne de rattachement</p>
            <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $caserne ? $caserne->name : 'Non rattache' }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Contact</p>
            <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $groupe->telephone ?? 'Non renseigne' }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 p-4 md:p-6">
        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Sinistres en attente</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">Liste des declarations a consulter</p>
            </div>
        </div>

        <div id="sinistres-container" class="transition-opacity duration-300">
            @include('groupe.partials.sinistres_table')
        </div>
    </div>

    <script>
        let timeLeft = 10;
        const refreshDisplay = document.getElementById('refresh-counter');
        const visibleCounter = document.getElementById('visible-counter');
        const container = document.getElementById('sinistres-container');

        function updateVisibleCounter() {
            const rows = container.querySelectorAll('tbody tr');
            const hasEmptyState = container.textContent.includes('Aucun sinistre en attente');
            if (visibleCounter) {
                visibleCounter.textContent = hasEmptyState ? '0' : rows.length.toString();
            }
        }

        function refreshSinistres() {
            container.style.opacity = '0.5';

            fetch(window.location.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                    container.style.opacity = '1';
                    updateVisibleCounter();
                    timeLeft = 10;
                    if (refreshDisplay) {
                        refreshDisplay.textContent = timeLeft;
                    }
                })
                .catch(() => {
                    container.style.opacity = '1';
                });
        }

        updateVisibleCounter();

        setInterval(() => {
            timeLeft--;
            if (refreshDisplay) {
                refreshDisplay.textContent = timeLeft;
            }

            if (timeLeft <= 0) {
                refreshSinistres();
            }
        }, 1000);
    </script>
@endsection
