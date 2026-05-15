<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONPC — Portail Citoyen | Alerte de Sinistre</title>
    <meta name="description" content="Déclarez un sinistre en temps réel. Système national de protection civile.">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo_onpc.png') }}" type="image/x-icon">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        :root {
            --onpc-blue: #0000cc;
            --onpc-blue-light: #e6e6ff;
            --onpc-orange: #ff8300;
            --white: #ffffff;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, .font-outfit { font-family: 'Outfit', sans-serif; }

        body {
            background-color: var(--white);
            color: var(--slate-900);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        [x-cloak] { display: none !important; }
        .hidden { display: none !important; }

        /* --- Main Layout --- */
        .app-layout {
            display: grid;
            grid-template-columns: 380px 1fr;
            min-height: 100vh;
        }

        @media (max-width: 1024px) {
            .app-layout { grid-template-columns: 1fr; }
        }

        /* --- Sidebar (Solid Blue) --- */
        .sidebar {
            background-color: var(--onpc-blue);
            color: var(--white);
            padding: 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        @media (max-width: 1024px) { .sidebar { padding: 2rem; } }

        .brand { display: flex; align-items: center; gap: 1rem; text-decoration: none; color: white; position: relative; z-index: 10; }
        .logo-img { height: 4.5rem; filter: brightness(0) invert(1); }
        .brand-name { font-size: 1.75rem; font-weight: 900; letter-spacing: -0.02em; }
        .brand-tagline { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3em; opacity: 0.7; }

        .hero-text-box { margin-top: 4rem; position: relative; z-index: 10; }
        .hero-title { font-size: 2.5rem; font-weight: 900; line-height: 1.1; margin-bottom: 1.5rem; }
        .hero-desc { font-size: 1rem; opacity: 0.7; line-height: 1.6; }

        .status-badge {
            display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.1);
            padding: 0.5rem 1rem; border-radius: 99px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase;
        }
        .pulse-dot { width: 8px; height: 8px; background: #4ade80; border-radius: 50%; box-shadow: 0 0 0 4px rgba(74, 222, 128, 0.2); }

        .sidebar-footer { 
            position: relative; 
            z-index: 10; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            gap: 1rem; 
            width: 100%; 
            margin-top: 2rem;
        }

        .footer-links-group {
            display: flex;
            gap: 1.25rem;
        }

        .footer-link { 
            color: white; 
            opacity: 0.6; 
            font-size: 0.75rem; 
            font-weight: 800; 
            text-transform: uppercase; 
            text-decoration: none; 
            transition: all 0.3s; 
        }

        @media (max-width: 768px) {
            .sidebar-footer {
                flex-direction: column;
                align-items: stretch;
                gap: 1.5rem;
            }
            .footer-links-group {
                display: none !important;
            }
            .btn-structure-mini {
                width: 100%;
                text-align: center;
            }
        }

        .footer-link:hover { opacity: 1; }

        .btn-structure-mini {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: var(--white);
            padding: 0.6rem 1rem;
            border-radius: 0.75rem;
            text-align: center;
            text-decoration: none;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.3s;
            white-space: nowrap;
        }
        .btn-structure-mini:hover {
            background: var(--white);
            color: var(--onpc-blue);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .mesh-decoration {
            position: absolute; bottom: -10%; right: -10%; width: 300px; height: 300px;
            background: var(--onpc-orange); opacity: 0.2; filter: blur(80px); border-radius: 50%;
        }

        /* --- Form Area (Light) --- */
        .form-area {
            background-color: var(--slate-50);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem;
        }

        @media (max-width: 768px) { .form-area { padding: 2rem 1rem; } }

        .form-card {
            width: 100%;
            max-width: 1100px;
            background: var(--white);
            border-radius: 3rem;
            padding: 5rem;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 204, 0.08);
            border: 1px solid var(--slate-200);
        }

        @media (max-width: 640px) { .form-card { padding: 2.5rem 1.5rem; } }

        .step-indicator { display: flex; align-items: center; gap: 1rem; margin-bottom: 3rem; }
        .step-box { display: flex; align-items: center; gap: 0.75rem; }
        .step-num { width: 32px; height: 32px; border-radius: 50%; background: var(--slate-100); color: var(--slate-300); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.8rem; }
        .step-num.active { background: var(--onpc-blue); color: var(--white); }
        .step-line { flex: 1; height: 2px; background: var(--slate-100); }
        .step-line.active { background: var(--onpc-blue); }

        .label { display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-900); opacity: 0.4; margin-bottom: 0.75rem; }
        .control {
            width: 100%; background: var(--slate-50); border: 2px solid var(--slate-100);
            border-radius: 1.5rem; padding: 1.25rem 1.75rem; font-size: 1rem; font-weight: 600;
            color: var(--slate-900); transition: all 0.3s;
        }
        .control:focus { background: var(--white); border-color: var(--onpc-blue); outline: none; box-shadow: 0 0 0 5px rgba(0,0,204,0.05); }

        /* Incident Bento */
        .incident-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
        @media (max-width: 480px) { .incident-grid { grid-template-columns: repeat(2, 1fr); } }
        
        .tile { position: relative; cursor: pointer; }
        .tile input { display: none; }
        .tile-content {
            background: var(--slate-50); border: 2px solid var(--slate-100);
            border-radius: 1.5rem; padding: 1.5rem; display: flex; flex-direction: column;
            align-items: center; gap: 0.5rem; transition: all 0.3s;
        }
        .tile:hover .tile-content { border-color: var(--onpc-blue); transform: translateY(-3px); }
        .tile input:checked + .tile-content { background: var(--onpc-blue-light); border-color: var(--onpc-blue); }
        .tile-icon { font-size: 2rem; }
        .tile-name { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; color: var(--slate-900); opacity: 0.5; }
        .tile input:checked + .tile-content .tile-name { opacity: 1; color: var(--onpc-blue); }

        /* Buttons */
        .btn-orange {
            width: 100%; background-color: var(--onpc-orange); color: var(--white); border: none;
            padding: 1.5rem; border-radius: 1.5rem; font-size: 1rem; font-weight: 900;
            text-transform: uppercase; letter-spacing: 0.25em; cursor: pointer;
            box-shadow: 0 20px 40px -10px rgba(255, 131, 0, 0.4); transition: all 0.3s;
            display: flex; align-items: center; justify-content: center; gap: 1rem;
        }
        .btn-orange:hover:not(:disabled) { background-color: #e67600; transform: translateY(-3px); }
        .btn-orange:disabled { opacity: 0.3; cursor: not-allowed; }

        .btn-secondary {
            background: var(--slate-100); border: none; color: var(--slate-800);
            padding: 1.5rem 2rem; border-radius: 1.5rem; font-weight: 800; cursor: pointer; transition: all 0.3s;
        }
        /* --- Official Structure Design (Reduced Height) --- */
        .photo-structure-card {
            flex: 1; min-width: 140px; height: 110px;
            background: var(--slate-50); border: 2px dashed var(--slate-200);
            border-radius: 1.5rem; position: relative; cursor: pointer; overflow: hidden;
            transition: all 0.3s ease;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        .photo-structure-card:hover { border-color: var(--onpc-blue); background: var(--white); }

        .action-btns-row { display: flex; gap: 0.5rem; margin-bottom: 0.75rem; z-index: 2; }
        .action-btn-mini {
            width: 38px; height: 38px; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;
            transition: all 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .btn-upload { background: var(--white); border: 1px solid var(--slate-100); color: var(--slate-400); }
        .photo-structure-card:hover .btn-upload { color: var(--onpc-blue); border-color: var(--onpc-blue-light); }
        .btn-camera { background: var(--onpc-orange); border: 1px solid var(--onpc-orange); color: var(--white); }
        .btn-camera:hover { transform: scale(1.1); }

        .photo-label-struct { font-size: 0.55rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; color: var(--slate-400); }
        
        .photo-preview-full { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; }
        .photo-hover-overlay {
            position: absolute; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(4px);
            display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s; z-index: 3;
        }
        .photo-structure-card:hover .photo-hover-overlay { opacity: 1; }
        .badge-change { background: rgba(255,255,255,0.2); padding: 0.4rem 0.8rem; border-radius: 0.75rem; color: white; font-size: 0.55rem; font-weight: 900; text-transform: uppercase; }

        .gps-tracker-premium {
            background: #ffffff; border: 2px solid var(--onpc-blue-light); border-radius: 2rem;
            padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem; margin-top: 1.5rem;
            box-shadow: 0 15px 35px -10px rgba(0,0,204,0.05);
        }
        .gps-pulse-container { position: relative; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; }
        .gps-pulse-core { width: 12px; height: 12px; border-radius: 50%; z-index: 2; }
        .gps-pulse-ring { position: absolute; inset: 0; border: 2px solid; border-radius: 50%; animation: gps-ping 2s infinite; opacity: 0; }
        @keyframes gps-ping { 
            0% { transform: scale(0.5); opacity: 0.8; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        .gps-refresh-btn {
            width: 40px; height: 40px; border-radius: 50%; border: none; background: var(--slate-100);
            color: var(--onpc-blue); cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;
        }
        .gps-refresh-btn:hover { background: var(--onpc-blue); color: var(--white); transform: rotate(180deg); }

        .btn-step-back {
            background: var(--white); border: 2px solid var(--slate-100); color: var(--slate-900);
            padding: 0 2rem; border-radius: 1.5rem; font-weight: 800; cursor: pointer;
            transition: all 0.3s; display: flex; align-items: center; gap: 0.75rem;
            text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.1em;
        }
        .btn-step-back:hover { border-color: var(--onpc-blue); color: var(--onpc-blue); background: var(--onpc-blue-light); }

        /* Camera Modal (Dark Glass) */
        .camera-overlay {
            position: fixed; inset: 0; background: rgba(15, 23, 42, 0.85); z-index: 2000;
            display: flex; flex-direction: column; align-items: center; justify-content: center; backdrop-filter: blur(20px);
        }
        .video-box { width: 100%; max-width: 450px; aspect-ratio: 3/4; border-radius: 3rem; overflow: hidden; background: #000; border: 4px solid var(--white); }
        .shutter { width: 80px; height: 80px; background: var(--white); border-radius: 50%; border: 8px solid var(--onpc-orange); cursor: pointer; }
    </style>
</head>

<body x-data="formHandler()">

    <div class="app-layout">
        <!-- Sidebar (Bleue) -->
        <aside class="sidebar">
            <div class="mesh-decoration"></div>
            
            <div>
                <a href="#" class="brand">
                    <img src="{{ asset('assets/images/logo_onpc.png') }}" class="logo-img" alt="ONPC">
                    <div>
                        <p class="brand-name">ONPC</p>
                        <p class="brand-tagline">République de Côte d'Ivoire</p>
                    </div>
                </a>

                <div class="hero-text-box">
                    <div class="status-badge">
                        <div class="pulse-dot"></div>
                        <span>Opérationnel 24/7</span>
                    </div>
                    <h1 class="hero-title">Signalez <br>une Urgence.</h1>
                    <p class="hero-desc">L'Office National de la Protection Civile coordonne les interventions de secours sur l'ensemble du territoire national.</p>
                </div>
            </div>

            <div class="sidebar-footer">
                <div class="footer-links-group">
                    <a href="{{ route('admin.login') }}" class="footer-link">Admin</a>
                    <a href="{{ route('caserne.auth.login') }}" class="footer-link">Caserne</a>
                </div>
                <a href="{{ route('structure.auth.login') }}" class="btn-structure-mini">Espace structure</a>
            </div>
        </aside>

        <!-- Main Form Area (Blanche) -->
        <main class="form-area">
            <div class="form-card">
                <div class="step-indicator">
                    <div class="step-box">
                        <div class="step-num" :class="step >= 1 ? 'active' : ''">1</div>
                        <span style="font-size: 0.6rem; font-weight: 800; text-transform: uppercase; color: var(--onpc-blue);">Sinistre</span>
                    </div>
                    <div class="step-line" :class="step >= 2 ? 'active' : ''"></div>
                    <div class="step-box">
                        <div class="step-num" :class="step >= 2 ? 'active' : ''">2</div>
                        <span style="font-size: 0.6rem; font-weight: 800; text-transform: uppercase; color: var(--onpc-blue);">Preuves</span>
                    </div>
                </div>

                <form action="{{ route('sinistre.store') }}" method="POST" enctype="multipart/form-data" id="sinistreForm">
                    @csrf
                    <input type="hidden" name="latitude" :value="latitude">
                    <input type="hidden" name="longitude" :value="longitude">

                    <!-- Step 1 -->
                    <div x-show="step === 1" 
                         x-transition:enter="transition cubic-bezier(0.34, 1.56, 0.64, 1) duration-600"
                         x-transition:enter-start="opacity-0 -translate-x-16"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition cubic-bezier(0.36, 0, 0.66, -0.56) duration-400"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-16">
                        <div style="margin-bottom: 2rem;">
                            <label class="label">Identification & Contact</label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                <input type="text" name="nom_complet" required placeholder="Votre Nom" class="control">
                                <input type="tel" name="contact" required placeholder="Téléphone" class="control" maxlength="10">
                            </div>
                        </div>

                        <div style="margin-bottom: 2rem;">
                            <label class="label">Nature de l'incident</label>
                            <div class="incident-grid">
                                @foreach ([['Incendie', '🔥'], ['Accident', '🚗'], ['Inondation', '🌊'], ['Effondrement', '🏚️'], ['Médical', '🚑'], ['Autre', '⚠️']] as [$v, $i])
                                    <label class="tile">
                                        <input type="radio" name="type_sinistre" value="{{ $v }}" required>
                                        <div class="tile-content">
                                            <span class="tile-icon">{{ $i }}</span>
                                            <span class="tile-name">{{ $v }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div style="margin-bottom: 2.5rem;">
                            <label class="label">Localisation (Rue, Quartier, Repère)</label>
                            <input type="text" name="lieu" required placeholder="Ex: Face à la pharmacie..." class="control">
                        </div>

                        <button type="button" @click="next()" class="btn-orange">
                            <span>Continuer</span>
                            <i data-lucide="chevron-right"></i>
                        </button>
                    </div>

                    <!-- Step 2 -->
                    <div x-show="step === 2" x-cloak 
                         x-transition:enter="transition cubic-bezier(0.34, 1.56, 0.64, 1) duration-600"
                         x-transition:enter-start="opacity-0 translate-x-16"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition cubic-bezier(0.36, 0, 0.66, -0.56) duration-400"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-16">
                        
                        <!-- Description Section -->
                        <div style="margin-bottom: 2.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                                <div style="width: 4px; height: 16px; background: var(--onpc-orange); border-radius: 2px;"></div>
                                <h3 style="font-size: 0.9rem; font-weight: 800; color: var(--onpc-blue); text-transform: uppercase; letter-spacing: 0.05em;">Détails de l'incident</h3>
                            </div>
                            <textarea name="description" required placeholder="Nombre de victimes, risques immédiats, ampleur du sinistre..." class="control" style="min-height: 140px; resize: none; border-radius: 2rem; padding: 1.5rem;"></textarea>
                        </div>

                        <!-- Photos Section -->
                        <div style="margin-bottom: 2.5rem;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div style="width: 4px; height: 16px; background: var(--onpc-orange); border-radius: 2px;"></div>
                                    <h3 style="font-size: 0.9rem; font-weight: 800; color: var(--onpc-blue); text-transform: uppercase; letter-spacing: 0.05em;">Preuves Visuelles</h3>
                                </div>
                                <span style="font-size: 0.65rem; font-weight: 700; color: #ef4444; background: #fee2e2; padding: 0.25rem 0.75rem; border-radius: 1rem;">Photo 1 Obligatoire *</span>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem;">
                                @foreach (['img1', 'img2', 'img3'] as $m)
                                    <div class="photo-structure-card" @click="$refs.file{{ $m }}.click()">
                                        <template x-if="!{{ $m }}">
                                            <div style="text-align: center; position: relative; z-index: 2;">
                                                <div class="action-btns-row">
                                                    <div class="action-btn-mini btn-upload">
                                                        <i data-lucide="upload-cloud" style="width: 18px;"></i>
                                                    </div>
                                                    <button type="button" @click.stop="startCamera('{{ $m }}')" class="action-btn-mini btn-camera">
                                                        <i data-lucide="camera" style="width: 18px;"></i>
                                                    </button>
                                                </div>
                                                <span class="photo-label-struct">{{ $m === 'img1' ? 'Photo 1 *' : 'Photo ' . substr($m, 3) }}</span>
                                            </div>
                                        </template>
                                        <div x-show="{{ $m }}" style="position: absolute; inset: 0; z-index: 1;">
                                            <img :src="{{ $m }}" class="photo-preview-full">
                                            <div class="photo-hover-overlay">
                                                <div class="badge-change">Changer</div>
                                            </div>
                                        </div>
                                        <input type="file" name="image{{ substr($m, 3) }}" x-ref="file{{ $m }}" class="hidden" accept="image/*" {{ $m === 'img1' ? 'required' : '' }} @change="preview($event, '{{ $m }}')">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- GPS Tracking Widget -->
                        <div class="gps-tracker-premium">
                            <div class="gps-pulse-container">
                                <div class="gps-pulse-core" :style="geoStatus === 'success' ? 'background: #10B981' : 'background: var(--onpc-orange)'"></div>
                                <div class="gps-pulse-ring" :style="geoStatus === 'success' ? 'border-color: #10B981' : 'border-color: var(--onpc-orange)'"></div>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="font-size: 0.85rem; font-weight: 900; color: var(--onpc-blue);" x-text="geoMessage"></span>
                                    <i data-lucide="shield-check" x-show="geoStatus === 'success'" style="width: 14px; color: #10B981;"></i>
                                </div>
                                <p style="font-size: 0.6rem; font-weight: 700; opacity: 0.5; text-transform: uppercase; letter-spacing: 0.05em;">Transmission coordonnées GPS en cours</p>
                            </div>
                            <button type="button" @click="requestLocation()" class="gps-refresh-btn">
                                <i data-lucide="refresh-cw" style="width: 16px;"></i>
                            </button>
                        </div>

                        <!-- Action Footer -->
                        <div style="display: flex; gap: 1.25rem; margin-top: 3rem;">
                            <button type="button" @click="step = 1" class="btn-step-back">
                                <i data-lucide="arrow-left" style="width: 18px;"></i>
                                <span>Retour</span>
                            </button>
                            <button type="submit" class="btn-orange" style="flex: 1; height: 4.5rem;" :disabled="geoStatus === null" :style="geoStatus === null ? 'opacity: 0.5; cursor: not-allowed' : ''">
                                <span x-text="geoStatus === 'success' ? 'Lancer l\'alerte nationale' : (geoStatus === 'error' ? 'Lancer l\'alerte (SANS GPS)' : 'Attente signal GPS...')"></span>
                                <i data-lucide="shield-alert" style="width: 22px;"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Camera Overlay -->
                <div x-show="cameraOpen" class="camera-overlay" x-cloak>
                    <div class="video-box">
                        <video x-ref="video" autoplay playsinline style="width: 100%; height: 100%; object-fit: cover;"></video>
                    </div>
                    <div style="margin-top: 3rem; display: flex; align-items: center; gap: 3rem;">
                        <button @click="stopCamera()" style="background: rgba(255,255,255,0.1); border: none; color: white; width: 60px; height: 60px; border-radius: 50%;"><i data-lucide="x"></i></button>
                        <button @click="capture()" class="shutter"></button>
                        <div style="width: 60px;"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function geoHandler() {
            return {
                latitude: null, longitude: null, geoStatus: null, geoMessage: 'Localisation...',
                init() { this.requestLocation(); lucide.createIcons(); },
                requestLocation() {
                    this.geoStatus = null; this.geoMessage = 'Verrouillage GPS...';
                    if (!("geolocation" in navigator)) { this.geoStatus = 'error'; this.geoMessage = 'GPS Non Supporté'; return; }
                    navigator.geolocation.getCurrentPosition(
                        (p) => { this.latitude = p.coords.latitude; this.longitude = p.coords.longitude; this.geoStatus = 'success'; this.geoMessage = 'Position Verrouillée'; },
                        () => { this.geoStatus = 'error'; this.geoMessage = 'Signal GPS Perdu'; },
                        { enableHighAccuracy: true, timeout: 10000 }
                    );
                }
            }
        }

        function formHandler() {
            return {
                step: 1, img1: null, img2: null, img3: null, cameraOpen: false, cameraTarget: null, stream: null,
                latitude: null, longitude: null, geoStatus: null, geoMessage: 'Localisation...',
                
                init() { 
                    this.requestLocation(); 
                    lucide.createIcons(); 
                },

                requestLocation() {
                    this.geoStatus = null; this.geoMessage = 'Verrouillage GPS...';
                    if (!("geolocation" in navigator)) { 
                        this.geoStatus = 'error'; 
                        this.geoMessage = 'GPS Non Supporté'; 
                        return; 
                    }
                    navigator.geolocation.getCurrentPosition(
                        (p) => { 
                            this.latitude = p.coords.latitude; 
                            this.longitude = p.coords.longitude; 
                            this.geoStatus = 'success'; 
                            this.geoMessage = 'Position Verrouillée'; 
                        },
                        () => { 
                            this.geoStatus = 'error'; 
                            this.geoMessage = 'Échec Signal GPS'; 
                        },
                        { enableHighAccuracy: true, timeout: 8000 }
                    );
                },

                next() {
                    const step1Fields = document.querySelector('[x-show="step === 1"]').querySelectorAll('input[required]');
                    let isValid = true;
                    step1Fields.forEach(field => {
                        if (!field.checkValidity()) {
                            field.reportValidity();
                            isValid = false;
                        }
                    });
                    if (isValid) {
                        this.step = 2;
                        setTimeout(() => lucide.createIcons(), 100);
                    }
                },
                preview(e, target) { const file = e.target.files[0]; if (file) this[target] = URL.createObjectURL(file); },
                async startCamera(target) {
                    this.cameraTarget = target; this.cameraOpen = true;
                    try {
                        this.stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
                        this.$refs.video.srcObject = this.stream;
                        setTimeout(() => lucide.createIcons(), 100);
                    } catch (e) { alert('Accès caméra refusé.'); this.cameraOpen = false; }
                },
                stopCamera() { if (this.stream) this.stream.getTracks().forEach(t => t.stop()); this.cameraOpen = false; },
                capture() {
                    const canvas = document.createElement('canvas');
                    canvas.width = this.$refs.video.videoWidth; canvas.height = this.$refs.video.videoHeight;
                    canvas.getContext('2d').drawImage(this.$refs.video, 0, 0);
                    this[this.cameraTarget] = canvas.toDataURL('image/jpeg');
                    canvas.toBlob(blob => {
                        const file = new File([blob], 'onpc_' + Date.now() + '.jpg', { type: 'image/jpeg' });
                        const container = new DataTransfer(); container.items.add(file);
                        this.$refs['file' + this.cameraTarget].files = container.files;
                        this.stopCamera();
                    }, 'image/jpeg');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            @if (session('success'))
                Swal.fire({
                    icon: 'success', title: 'ALERTE TRANSMISSE', text: "{{ session('success') }}",
                    confirmButtonColor: '#0000cc', background: '#ffffff', color: '#0000cc',
                    customClass: { popup: 'rounded-3xl' }
                });
            @endif
        });
    </script>
</body>

</html>
