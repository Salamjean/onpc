<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSTE DE COMMANDEMENT LIVE - Caserne ONPC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #0f172a; 
            min-height: screen;
        }
        .onpc-gradient-blue { background: linear-gradient(135deg, #0000cc 0%, #000066 100%); }
        .onpc-gradient-orange { background: linear-gradient(135deg, #ff8300 0%, #e67600 100%); }
        .glass-card { 
            background: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .pulse-orange { animation: pulse 2s infinite; }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(255, 131, 0, 0.6); }
            70% { box-shadow: 0 0 0 15px rgba(255, 131, 0, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 131, 0, 0); }
        }
        .alert-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .alert-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 204, 0.15);
        }
    </style>
</head>
<body class="p-6 md:p-10 relative overflow-x-hidden">

    <!-- Audio Unlock Banner -->
    <div id="audio-unlock-banner" class="fixed top-4 right-4 bg-gradient-to-br from-orange-500 to-red-600 text-white px-6 py-4 rounded-3xl shadow-2xl z-[999] flex items-center gap-4 transition-all duration-500 transform translate-x-0 border border-white/20">
        <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center animate-bounce text-xl">
            🔊
        </div>
        <div>
            <p class="text-xs font-black uppercase tracking-wider">Activer le son des alertes</p>
            <p class="text-[9px] text-white/80 font-medium">Autorisez le Poste de Commandement à faire retentir la sirène en cas de sinistre.</p>
        </div>
        <button onclick="unlockAudio()" class="bg-white text-orange-600 hover:bg-orange-50 px-4 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
            Activer
        </button>
    </div>

    <!-- Top Bar / Command Center Header -->
    <header class="onpc-gradient-blue p-8 rounded-[3rem] shadow-2xl mb-10 flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full -ml-32 -mt-32"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-onpc-orange/10 rounded-full -mr-32 -mb-32"></div>

        <div class="flex items-center gap-6 relative z-10">
            <div class="bg-white p-3.5 rounded-2xl shadow-xl">
                <img src="{{ asset('assets/images/logo_onpc.png') }}" alt="Logo" class="w-12 h-12 object-contain">
            </div>
            <div class="text-white">
                <h1 class="text-3xl font-black tracking-tighter uppercase leading-none">Poste de Commandement <span class="text-onpc-orange">Live</span></h1>
                <div class="flex items-center gap-3 mt-2 text-blue-100/70">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-black bg-onpc-orange text-white uppercase tracking-widest">Opérationnel</span>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em]">{{ $caserne->name }}</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-6 relative z-10">
            <div class="text-right">
                <p class="text-[9px] font-black text-blue-200 uppercase tracking-[0.3em] mb-1">Actualisation</p>
                <div class="flex items-center gap-3">
                    <span class="text-2xl font-black text-white font-mono tracking-wider" id="clock">{{ now()->format('H:i:s') }}</span>
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></div>
                </div>
            </div>
            <div class="w-px h-12 bg-white/10 hidden md:block"></div>
            <div class="bg-white/10 backdrop-blur-md rounded-3xl px-8 py-3 border border-white/10 shadow-inner">
                <p class="text-[9px] font-black text-blue-100 uppercase tracking-[0.2em] mb-1 text-center">Alertes Actives</p>
                <p id="active-alerts-count" class="text-3xl font-black text-white text-center">{{ count($sinistres) }}</p>
            </div>
        </div>
    </header>

    <!-- Alert Grid Container (Dynamique via AJAX) -->
    <div id="alert-grid-container" class="w-full">
        @include('caserne.partials.assistance_grid')
    </div>

    <!-- Live Badge / Control Bar -->
    <div class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white px-10 py-5 rounded-full shadow-[0_20px_50px_rgba(0,0,0,0.3)] flex items-center gap-6 z-50 border border-white/10">
        <div class="flex items-center gap-3">
            <div class="w-3 h-3 bg-red-500 rounded-full animate-ping"></div>
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-200">Live Monitor v2.0</span>
        </div>
        <div class="h-6 w-px bg-white/10"></div>
        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
            Auto-Sync: <span class="text-onpc-orange font-mono text-base ml-1.5" id="countdown">10s</span>
        </div>
        <div class="h-6 w-px bg-white/10"></div>
        <button id="mute-btn" onclick="toggleMute()" class="px-4 py-1.5 bg-white/10 hover:bg-white/20 text-white rounded-full text-[10px] font-black uppercase tracking-widest transition-all">
            🔊 Alarme : Activée
        </button>
    </div>

    <script>
        let timeLeft = 10;
        const countdownEl = document.getElementById('countdown');
        
        setInterval(() => {
            timeLeft--;
            countdownEl.innerText = timeLeft + 's';
            if(timeLeft <= 0) {
                timeLeft = 10;
                fetchAlerts();
            }
        }, 1000);

        // Update clock
        setInterval(() => {
            const now = new Date();
            const timeStr = now.getHours().toString().padStart(2, '0') + ':' + 
                          now.getMinutes().toString().padStart(2, '0') + ':' + 
                          now.getSeconds().toString().padStart(2, '0');
            document.getElementById('clock').innerText = timeStr;
        }, 1000);

        // Synthesize French Firefighter two-tone siren (Pin-Pon)
        let audioCtx = null;
        let sirenOsc = null;
        let sirenGain = null;
        let sirenInterval = null;
        let isSirenPlaying = false;
        let isMuted = false;

        function unlockAudio() {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            document.getElementById('audio-unlock-banner').classList.add('translate-x-[150%]', 'opacity-0');
            playBeep();
            setTimeout(checkPendingAlerts, 500);
        }

        function playBeep() {
            if (!audioCtx) return;
            try {
                let osc = audioCtx.createOscillator();
                let gain = audioCtx.createGain();
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.frequency.setValueAtTime(880, audioCtx.currentTime);
                gain.gain.setValueAtTime(0.1, audioCtx.currentTime);
                osc.start();
                osc.stop(audioCtx.currentTime + 0.15);
            } catch(e) {
                console.log('Audio bip bloqué');
            }
        }

        function startSiren() {
            if (isSirenPlaying) return;
            if (!audioCtx) {
                document.getElementById('audio-unlock-banner').classList.remove('translate-x-[150%]', 'opacity-0');
                return;
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            
            isSirenPlaying = true;
            
            try {
                sirenOsc = audioCtx.createOscillator();
                sirenGain = audioCtx.createGain();
                
                sirenOsc.type = 'sawtooth';
                sirenOsc.frequency.setValueAtTime(435, audioCtx.currentTime); // La (435 Hz)
                sirenGain.gain.setValueAtTime(0.12, audioCtx.currentTime); // Volume modéré & pro
                
                sirenOsc.connect(sirenGain);
                sirenGain.connect(audioCtx.destination);
                sirenOsc.start();
                
                let state = true;
                sirenInterval = setInterval(() => {
                    if (!audioCtx || !isSirenPlaying) return;
                    // Alternance Pin-Pon (435 Hz et 349 Hz)
                    let targetFreq = state ? 435 : 349;
                    sirenOsc.frequency.linearRampToValueAtTime(targetFreq, audioCtx.currentTime + 0.25);
                    state = !state;
                }, 800);
            } catch(e) {
                console.error('Erreur lancement sirène :', e);
                isSirenPlaying = false;
            }
        }

        function stopSiren() {
            if (!isSirenPlaying) return;
            isSirenPlaying = false;
            
            if (sirenInterval) {
                clearInterval(sirenInterval);
                sirenInterval = null;
            }
            
            if (sirenOsc) {
                try {
                    sirenOsc.stop();
                    sirenOsc.disconnect();
                } catch(e) {}
                sirenOsc = null;
            }
            
            if (sirenGain) {
                try {
                    sirenGain.disconnect();
                } catch(e) {}
                sirenGain = null;
            }
        }

        function toggleMute() {
            isMuted = !isMuted;
            const btn = document.getElementById('mute-btn');
            if (isMuted) {
                btn.innerText = '🔇 Alarme : Muette';
                btn.classList.add('bg-red-600/30', 'text-red-300');
                stopSiren();
            } else {
                btn.innerText = '🔊 Alarme : Activée';
                btn.classList.remove('bg-red-600/30', 'text-red-300');
                if (audioCtx && audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }
                checkPendingAlerts();
            }
        }

        function checkPendingAlerts() {
            const hasPending = document.querySelector('.pulse-orange') !== null;
            if (hasPending && !isMuted) {
                startSiren();
            } else {
                stopSiren();
            }
        }

        function fetchAlerts() {
            fetch(window.location.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('alert-grid-container').innerHTML = html;
                
                // Actualiser le nombre total d'alertes actives dans l'en-tête
                const activeCount = document.querySelectorAll('.alert-card').length;
                document.getElementById('active-alerts-count').innerText = activeCount;
                
                checkPendingAlerts();
            })
            .catch(err => console.error('Erreur d\'actualisation :', err));
        }

        // Débloquer l'audio de manière transparente au premier clic
        document.addEventListener('click', () => {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            document.getElementById('audio-unlock-banner').classList.add('translate-x-[150%]', 'opacity-0');
            checkPendingAlerts();
        }, { once: true });

        // Vérification des alertes après le chargement
        window.addEventListener('load', () => {
            setTimeout(checkPendingAlerts, 1000);
        });
    </script>
</body>
</html>
