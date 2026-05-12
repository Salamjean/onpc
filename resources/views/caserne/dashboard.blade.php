@extends('caserne.layouts.app')

@section('content')
    <div class="mb-10">
        <div class="flex justify-between items-end gap-4">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none uppercase">
                    Suivi <span class="text-caserne-red">Temps Réel</span>
                </h1>
                <p class="text-slate-500 mt-3 font-bold text-xs flex items-center gap-2 uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    Actualisation automatique toutes les 15s
                </p>
            </div>
            <div class="flex gap-4">
                <!-- Compteur Interventions -->
                <div
                    class="bg-caserne-red/10 px-6 py-4 rounded-2xl shadow-sm border border-caserne-red/20 flex items-center gap-4">
                    <div id="interventions-counter"
                        class="w-10 h-10 rounded-xl bg-caserne-red flex items-center justify-center font-black text-white text-sm">
                        {{ $interventionsCount }}
                    </div>
                    <p class="text-[10px] font-black text-caserne-red uppercase tracking-widest">Interventions en cours</p>
                </div>
                <!-- Compteur Mise à jour -->
                <div class="bg-white px-6 py-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div id="refresh-counter"
                        class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center font-black text-caserne-red text-xs">
                        15
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Prochaine mise à jour</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Container pour le tableau rafraîchi par AJAX -->
    <div id="sinistres-container" class="transition-all duration-500">
        @include('caserne.partials.sinistres_table')
    </div>

    <script>
        let timeLeft = 15;
        const counterDisplay = document.getElementById('refresh-counter');
        const interventionsCounter = document.getElementById('interventions-counter');
        const container = document.getElementById('sinistres-container');

        function updateInterventionsCount() {
            // Compter les cellules de statut qui contiennent "En cours"
            const statusCells = container.querySelectorAll('td:nth-child(5)');
            let count = 0;
            statusCells.forEach(cell => {
                if (cell.textContent.includes('En cours')) {
                    count++;
                }
            });
            // Mettre à jour le compteur
            if (interventionsCounter) {
                interventionsCounter.textContent = count;
            }
        }

        function refreshTable() {
            // Animation de chargement légère
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
                    updateInterventionsCount();
                    timeLeft = 15; // Reset timer
                    console.log('Table updated successfully');
                })
                .catch(error => {
                    console.error('Error refreshing table:', error);
                    container.style.opacity = '1';
                });
        }

        // Timer visuel
        setInterval(() => {
            timeLeft--;
            if (timeLeft <= 0) {
                refreshTable();
            }
            counterDisplay.innerText = timeLeft;
        }, 1000);
    </script>
@endsection
