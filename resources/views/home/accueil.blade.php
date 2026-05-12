<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONPC — Portail Citoyen | Déclaration de Sinistre</title>
    <meta name="description" content="Déclarez un sinistre en temps réel. L'ONPC coordonne les secours les plus proches.">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --blue-onpc: #0000cc;
            --orange-onpc: #ff8300;
            --blue-dark: #000088;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
            --white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --radius-3xl: 2rem;
            --radius-full: 9999px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--slate-50);
            color: var(--slate-900);
            line-height: 1.5;
            overflow-x: hidden;
        }

        [x-cloak] { display: none !important; }

        /* --- Global Utility --- */
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 0 10%;
        }

        @media (max-width: 1024px) {
            .container { padding: 0 5%; }
        }

        @media (max-width: 640px) {
            .container { padding: 0 1.5rem; }
        }

        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .flex-col { flex-direction: column; }
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .grid { display: grid; }
        .hidden { display: none; }

        @media (min-width: 768px) {
            .md-flex { display: flex; }
            .md-grid { display: grid; }
        }

        /* --- Navbar --- */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1.5rem 0;
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo-box {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.5rem 0.75rem;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
        }

        @media (min-width: 768px) {
            .nav-logo-box { gap: 0.75rem; padding: 0.625rem 1rem; }
        }

        .nav-logo-img { height: 1.5rem; }
        @media (min-width: 768px) { .nav-logo-img { height: 2rem; } }

        .nav-logo-text {
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            padding-left: 0.75rem;
        }

        @media (max-width: 480px) {
            .nav-logo-tagline { display: none; }
        }

        .nav-logo-tagline {
            font-size: 0.5rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: rgba(255, 255, 255, 0.6);
        }

        .nav-logo-name {
            font-size: 0.875rem;
            font-weight: 900;
            color: var(--white);
            text-transform: uppercase;
            line-height: 1;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-link {
            font-size: 0.625rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: color 0.3s;
            padding: 0.5rem 1rem;
        }

        .nav-link:hover { color: var(--white); }

        .nav-btn {
            background-color: var(--orange-onpc);
            color: var(--white);
            padding: 0.5rem 0.75rem;
            border-radius: 0.75rem;
            font-size: 0.5625rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.375rem;
            box-shadow: 0 10px 15px -3px rgba(255, 131, 0, 0.3);
            transition: transform 0.3s, background-color 0.3s;
        }

        @media (min-width: 768px) {
            .nav-btn { padding: 0.625rem 1.25rem; font-size: 0.625rem; gap: 0.5rem; letter-spacing: 0.1em; }
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            background-color: #e07200;
        }

        /* --- Hero Section --- */
        .hero {
            background: linear-gradient(135deg, var(--blue-onpc) 0%, var(--blue-dark) 50%, #1a1a2e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding-top: 8rem; /* Augmenté pour mobile */
        }

        @media (min-width: 1024px) {
            .hero { padding-top: 5rem; }
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        .hero-blob-1 {
            position: absolute;
            top: 5rem;
            right: 5rem;
            width: 20rem;
            height: 20rem;
            background: rgba(255, 131, 0, 0.1);
            border-radius: var(--radius-full);
            filter: blur(80px);
            animation: float 4s ease-in-out infinite;
        }

        .hero-blob-2 {
            position: absolute;
            bottom: 5rem;
            left: 2.5rem;
            width: 15rem;
            height: 15rem;
            background: rgba(59, 130, 246, 0.1);
            border-radius: var(--radius-full);
            filter: blur(80px);
            animation: float 4s ease-in-out infinite 2s;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2.5rem; /* Réduit pour mobile */
            align-items: center;
            position: relative;
            z-index: 10;
            padding-bottom: 4rem;
        }

        @media (max-width: 1024px) {
            .hero-text { text-align: center; }
            .hero-title-badge { justify-content: center; }
            .hero-stats { justify-content: center; }
            .hero-desc { margin-left: auto; margin-right: auto; }
        }

        @media (min-width: 1024px) {
            .hero-grid { grid-template-columns: 1fr 1fr; gap: 6rem; padding-bottom: 0; }
        }

        .hero-title-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(4px);
            padding: 0.5rem 1rem;
            border-radius: var(--radius-full);
            margin-bottom: 2rem;
            animation: fadeUp 0.8s ease forwards 0.1s;
            opacity: 0;
        }

        .badge-dot {
            width: 0.5rem;
            height: 0.5rem;
            background-color: #4ade80;
            border-radius: var(--radius-full);
            animation: pulse 2s infinite;
        }

        .badge-text {
            font-size: 0.625rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: rgba(255, 255, 255, 0.8);
        }

        .hero-heading {
            font-size: clamp(2.2rem, 10vw, 4.5rem);
            font-weight: 900;
            color: var(--white);
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: -0.02em;
            margin-bottom: 1.5rem;
            animation: fadeUp 0.8s ease forwards 0.25s;
            opacity: 0;
        }

        .text-orange { color: var(--orange-onpc); }

        .hero-desc {
            font-size: 1.125rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.5);
            max-width: 28rem;
            margin-bottom: 2.5rem;
            animation: fadeUp 0.8s ease forwards 0.4s;
            opacity: 0;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            animation: fadeUp 0.8s ease forwards 0.55s;
            opacity: 0;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-xl);
            padding: 1rem;
            text-align: center;
        }

        .stat-val {
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--white);
        }

        .stat-label {
            font-size: 0.5625rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 0.25rem;
        }

        /* --- Form Card --- */
        .form-card {
            background: var(--white);
            border-radius: var(--radius-3xl);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            animation: fadeUp 0.8s ease forwards 0.4s;
            opacity: 0;
        }

        .form-header {
            background: linear-gradient(to right, var(--blue-onpc), var(--blue-dark));
            padding: 1.5rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        @media (min-width: 768px) {
            .form-header { padding: 2rem 3rem; }
        }

        .form-header-tag {
            font-size: 0.75rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: rgba(255, 255, 255, 0.6);
        }

        .form-header-title {
            font-size: 1.75rem;
            font-weight: 900;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: -0.02em;
            margin-top: 0.25rem;
        }

        .form-steps { display: flex; align-items: center; gap: 0.75rem; }

        .step-num {
            width: 3rem;
            height: 3rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 900;
            transition: all 0.3s;
        }

        .step-active { background: var(--orange-onpc); color: var(--white); }
        .step-inactive { background: rgba(255, 255, 255, 0.1); color: rgba(255, 255, 255, 0.4); }

        .step-divider {
            width: 1.5rem;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
        }
        .step-divider-active { background: var(--orange-onpc); }

        .form-body { padding: 1.5rem; }

        @media (min-width: 768px) {
            .form-body { padding: 3rem; }
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 640px) {
            .form-grid-2 { grid-template-columns: 1fr 1fr; }
        }

        .field-group { display: flex; flex-direction: column; gap: 0.5rem; }

        .field-label {
            font-size: 0.75rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--slate-400);
            margin-left: 0.5rem;
        }

        .input {
            width: 100%;
            padding: 1.25rem 1.5rem;
            background: var(--slate-50);
            border: 1px solid var(--slate-100);
            border-radius: var(--radius-2xl);
            font-weight: 700;
            color: var(--slate-800);
            outline: none;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .input::placeholder { font-weight: 400; color: var(--slate-300); }

        .input:focus {
            background: var(--white);
            border-color: var(--blue-onpc);
            box-shadow: 0 0 0 4px rgba(0, 0, 204, 0.05);
        }

        .type-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        @media (min-width: 640px) {
            .type-grid { grid-template-columns: repeat(3, 1fr); }
        }

        .type-option {
            position: relative;
            cursor: pointer;
        }

        .type-radio { display: none; }

        .type-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
            padding: 1rem;
            background: var(--slate-50);
            border: 2px solid var(--slate-100);
            border-radius: var(--radius-2xl);
            text-align: center;
            transition: all 0.3s;
        }

        @media (min-width: 768px) {
            .type-box { padding: 1.5rem; gap: 0.5rem; }
        }

        .type-icon { font-size: 2rem; }

        .type-label {
            font-size: 0.625rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--slate-500);
        }

        .type-radio:checked + .type-box {
            border-color: var(--orange-onpc);
            background: #fff7ed;
        }

        .textarea {
            resize: none;
            min-height: 5rem;
        }

        .btn-submit {
            width: 100%;
            background: var(--blue-onpc);
            color: var(--white);
            padding: 1.5rem;
            border: none;
            border-radius: var(--radius-2xl);
            font-size: 0.875rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 204, 0.2);
            margin-top: 1.5rem;
        }

        .btn-submit:hover {
            background: var(--slate-900);
            transform: translateY(-2px);
        }

        .btn-next {
            width: 100%;
            background: var(--blue-onpc);
            color: var(--white);
            padding: 1.5rem;
            border: none;
            border-radius: var(--radius-2xl);
            font-size: 0.875rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1.5rem;
        }

        /* --- Step 2 styles --- */
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        .photo-upload {
            position: relative;
            height: 10rem;
            border: 2px dashed var(--slate-200);
            background: var(--slate-50);
            border-radius: var(--radius-2xl);
            cursor: pointer;
            overflow: hidden;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo-upload:hover {
            border-color: var(--blue-onpc);
            background: #f1f5f9;
        }

        .photo-preview {
            width: 100%;
            height: 100%;
            object-cover: cover;
        }

        .geo-status-box {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            border-radius: var(--radius-2xl);
            border: 1px solid transparent;
            margin-top: 1rem;
            transition: all 0.3s;
        }

        .status-success { background: #f0fdf4; border-color: #dcfce7; }
        .status-error { background: #fef2f2; border-color: #fee2e2; }
        .status-pending { background: #eff6ff; border-color: #dbeafe; }

        .status-icon {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            flex-shrink: 0;
        }

        .icon-blue { background: var(--blue-onpc); }
        .icon-green { background: #22c55e; }
        .icon-red { background: #ef4444; }

        .status-title { font-size: 0.75rem; font-weight: 900; color: var(--slate-700); }
        .status-sub { font-size: 0.5625rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--slate-400); }

        .form-footer {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .btn-back {
            padding: 1rem 1.5rem;
            background: var(--slate-100);
            border: none;
            border-radius: var(--radius-2xl);
            font-size: 0.75rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--slate-600);
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-orange {
            flex: 1;
            background: var(--orange-onpc);
            box-shadow: 0 20px 25px -5px rgba(255, 131, 0, 0.2);
        }

        /* --- Camera Modal --- */
        .camera-modal {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.95);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }
        .camera-container {
            width: 100%;
            max-width: 500px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
        }
        .camera-view {
            width: 100%;
            aspect-ratio: 3/4;
            background: #000;
            border-radius: 2rem;
            overflow: hidden;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            border: 2px solid rgba(255,255,255,0.1);
        }
        .camera-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .camera-controls {
            display: flex;
            align-items: center;
            gap: 3rem;
        }
        .btn-capture {
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            border: 4px solid #fff;
            background: transparent;
            padding: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-capture:hover { transform: scale(1.1); }
        .btn-capture-inner {
            width: 100%;
            height: 100%;
            background: #fff;
            border-radius: 50%;
        }
        .btn-close-camera {
            background: rgba(255,255,255,0.1);
            color: #fff;
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-close-camera:hover { background: rgba(255,255,255,0.2); }

        /* --- Footer badges --- */
        .hero-footer-badges {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .footer-badge {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            background: rgba(255,255,255,0.05);
            padding: 0.5rem 1rem;
            border-radius: var(--radius-full);
        }

        @media (max-width: 640px) {
            .hero-footer-badges { flex-direction: column; gap: 0.5rem; align-items: stretch; }
            .footer-badge { justify-content: center; }
        }

        .badge-dot-small {
            width: 0.375rem;
            height: 0.375rem;
            border-radius: var(--radius-full);
        }

        .badge-text-small {
            font-size: 0.5625rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.4);
        }

        /* --- Sections --- */
        .section { padding: 6rem 0; }
        .section-white { background: var(--white); }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-tag {
            display: inline-block;
            font-size: 0.5625rem;
            font-weight: 900;
            color: var(--orange-onpc);
            text-transform: uppercase;
            letter-spacing: 0.4em;
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-size: 2.25rem;
            font-weight: 900;
            color: var(--slate-900);
            text-transform: uppercase;
            letter-spacing: -0.02em;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .steps-grid { grid-template-columns: repeat(3, 1fr); }
        }

        .step-card {
            background: var(--slate-50);
            border-radius: var(--radius-3xl);
            padding: 2rem;
            border: 1px solid var(--slate-100);
            position: relative;
            transition: all 0.3s;
        }

        .step-card:hover {
            transform: translateY(-0.5rem);
            box-shadow: var(--shadow-xl);
            background: var(--white);
        }

        .step-icon-box {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: var(--radius-2xl);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .step-num-bg {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 3rem;
            font-weight: 900;
            color: var(--slate-100);
            line-height: 1;
        }

        .step-title {
            font-size: 1.25rem;
            font-weight: 900;
            color: var(--slate-900);
            text-transform: uppercase;
            letter-spacing: -0.02em;
            margin-bottom: 0.75rem;
        }

        .step-desc {
            font-size: 0.875rem;
            color: var(--slate-500);
            font-weight: 500;
        }

        /* --- CTA Footer Section --- */
        .cta-section {
            background: linear-gradient(135deg, var(--slate-800) 0%, var(--blue-onpc) 100%);
            padding: 4rem 0;
            text-align: center;
            color: var(--white);
        }

        .cta-title { font-size: 2rem; font-weight: 900; text-transform: uppercase; margin-bottom: 1rem; }
        .cta-desc { color: rgba(255, 255, 255, 0.5); font-weight: 500; margin-bottom: 2rem; }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--orange-onpc);
            color: var(--white);
            padding: 1.25rem 2.5rem;
            border-radius: var(--radius-2xl);
            font-size: 0.75rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            text-decoration: none;
            box-shadow: 0 25px 50px -12px rgba(255, 131, 0, 0.3);
            transition: all 0.3s;
        }

        .cta-btn:hover { transform: scale(1.05); }

        /* --- Main Footer --- */
        .footer {
            background: var(--slate-900);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding: 2rem 0;
        }

        .footer-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .footer-inner { flex-direction: row; justify-content: space-between; }
        }

        .footer-logo { display: flex; align-items: center; gap: 0.75rem; }
        .footer-logo-img { height: 2rem; opacity: 0.7; }
        .footer-logo-text {
            font-size: 0.5625rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.3);
        }

        .footer-copy {
            font-size: 0.5625rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.2);
        }

        /* --- Animations --- */
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulse { 0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.7); } 70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(74, 222, 128, 0); } 100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(74, 222, 128, 0); } }

        /* --- SVGs --- */
        .icon { width: 1.25rem; height: 1.25rem; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    </style>
</head>
<body x-data="geoHandler()">

    <!-- --- Navbar --- -->
    <nav class="navbar">
        <div class="container nav-inner">
            <div class="nav-logo-box">
                <img src="{{ asset('assets/images/logo_onpc.png') }}" alt="ONPC" class="nav-logo-img">
                <div class="nav-logo-text">
                    <p class="nav-logo-tagline">République de Côte d'Ivoire</p>
                    <p class="nav-logo-name">ONPC</p>
                </div>
            </div>
            <div class="nav-links">
                <a href="{{ route('admin.login') }}" class="nav-link hidden md-flex">Admin</a>
                <a href="{{ route('caserne.auth.login') }}" class="nav-link hidden md-flex">Caserne</a>
                <a href="{{ route('structure.auth.login') }}" class="nav-btn">
                    <svg class="icon"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Espace Structure</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- --- Hero Section --- -->
    <section class="hero">
        <div class="hero-blob-1"></div>
        <div class="hero-blob-2"></div>
        
        <div class="container hero-grid">
            <!-- Left Text -->
            <div class="hero-text">
                <div class="hero-title-badge">
                    <div class="badge-dot"></div>
                    <span class="badge-text">Système actif — 24h/24 7j/7</span>
                </div>
                <h1 class="hero-heading">Signalez<br><span class="text-orange">Votre</span><br>Urgence</h1>
                <p class="hero-desc">La plateforme nationale de gestion des sinistres. Déclarez un incident en temps réel et les secours les plus proches seront coordonnés immédiatement.</p>
                
                <div class="hero-stats">
                    <div class="stat-card">
                        <p class="stat-val">24/7</p>
                        <p class="stat-label">Disponibilité</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-val" style="color:var(--orange-onpc)">&lt;5mn</p>
                        <p class="stat-label">Temps réponse</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-val">GPS</p>
                        <p class="stat-label">Localisation auto</p>
                    </div>
                </div>
            </div>

            <!-- Right Form -->
            <div x-data="{ 
                step: 1, 
                img1: null, img2: null, img3: null,
                cameraOpen: false, cameraTarget: null, stream: null,
                preview(e, target) { const file = e.target.files[0]; if (file) { this[target] = URL.createObjectURL(file); } },
                async startCamera(target) {
                    this.cameraTarget = target;
                    this.cameraOpen = true;
                    try {
                        this.stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
                        this.$refs.video.srcObject = this.stream;
                    } catch (e) {
                        alert('Erreur accès caméra. Vérifiez les permissions.');
                        this.cameraOpen = false;
                    }
                },
                stopCamera() {
                    if (this.stream) { this.stream.getTracks().forEach(t => t.stop()); this.stream = null; }
                    this.cameraOpen = false;
                },
                capture() {
                    const canvas = document.createElement('canvas');
                    canvas.width = this.$refs.video.videoWidth;
                    canvas.height = this.$refs.video.videoHeight;
                    canvas.getContext('2d').drawImage(this.$refs.video, 0, 0);
                    const dataUrl = canvas.toDataURL('image/jpeg');
                    this[this.cameraTarget] = dataUrl;
                    
                    canvas.toBlob(blob => {
                        const file = new File([blob], 'camera_' + Date.now() + '.jpg', { type: 'image/jpeg' });
                        const container = new DataTransfer();
                        container.items.add(file);
                        this.$refs['file' + this.cameraTarget].files = container.files;
                        this.stopCamera();
                    }, 'image/jpeg');
                }
            }">
                <div class="form-card">
                    <div class="form-header">
                        <div>
                            <p class="form-header-tag">Formulaire de déclaration</p>
                            <h2 class="form-header-title">Alerte Sinistre</h2>
                        </div>
                        <div class="form-steps">
                            <div class="step-num" :class="step >= 1 ? 'step-active' : 'step-inactive'">1</div>
                            <div class="step-divider" :class="step >= 2 ? 'step-divider-active' : ''"></div>
                            <div class="step-num" :class="step >= 2 ? 'step-active' : 'step-inactive'">2</div>
                        </div>
                    </div>

                    <form action="{{ route('sinistre.store') }}" method="POST" enctype="multipart/form-data" class="form-body">
                        @csrf
                        <input type="hidden" name="latitude" x-model="latitude">
                        <input type="hidden" name="longitude" x-model="longitude">

                        <!-- STEP 1 -->
                        <div x-show="step === 1" x-transition>
                            <div class="form-grid form-grid-2">
                                <div class="field-group">
                                    <label class="field-label">Nom & Prénoms *</label>
                                    <input type="text" name="nom_complet" required placeholder="Jean Kouassi" class="input">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Contact *</label>
                                    <input type="tel" name="contact" required placeholder="07 00 00 00" class="input">
                                </div>
                            </div>

                            <div class="field-group" style="margin-top:1rem">
                                <label class="field-label">Nature de l'incident *</label>
                                <div class="type-grid">
                                    @foreach([['Incendie','🔥'],['Accident','🚗'],['Inondation','🌊'],['Effondrement','🏚️'],['Médical','🚑'],['Autre','⚠️']] as [$val,$icon])
                                    <label class="type-option">
                                        <input type="radio" name="type_sinistre" value="{{ $val }}" class="type-radio" required>
                                        <div class="type-box">
                                            <span class="type-icon">{{ $icon }}</span>
                                            <span class="type-label">{{ $val }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="field-group" style="margin-top:1rem">
                                <label class="field-label">Description *</label>
                                <textarea name="description" required placeholder="Décrivez brièvement la situation..." class="input textarea"></textarea>
                            </div>

                            <button type="button" @click="step = 2" class="btn-next">Continuer →</button>
                        </div>

                        <!-- STEP 2 -->
                        <div x-show="step === 2" x-cloak x-transition>
                            <label class="field-label">Photos de la scène (optionnel)</label>
                            <div class="photo-grid">
                                @foreach(['img1','img2','img3'] as $m)
                                <div class="photo-upload group cursor-pointer" @click="$refs.file{{ $m }}.click()">
                                    {{-- Empty state --}}
                                    <div x-show="!{{ $m }}" class="flex flex-col items-center gap-3">
                                        <div class="flex gap-2">
                                            <div @click="$refs.file{{ $m }}.click()" class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center border border-slate-100 text-slate-400 group-hover:text-blue-600 transition-all cursor-pointer hover:scale-110">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                            </div>
                                            <button type="button" @click.stop="startCamera('{{ $m }}')" class="w-12 h-12 rounded-2xl bg-orange-onpc shadow-lg shadow-orange-500/20 flex items-center justify-center text-white hover:scale-110 transition-all" style="background:var(--orange-onpc)">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            </button>
                                        </div>
                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Preuve {{ substr($m, 3) }}</span>
                                    </div>
                                    
                                    {{-- Preview --}}
                                    <div x-show="{{ $m }}" class="absolute inset-0 w-full h-full cursor-pointer" @click="$refs.file{{ $m }}.click()">
                                        <img :src="{{ $m }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <div class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/30">
                                                <span class="text-[10px] font-black text-white uppercase tracking-widest">Changer</span>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="file" name="image{{ substr($m, 3) }}" x-ref="file{{ $m }}" class="hidden" accept="image/*" capture="environment" @change="preview($event,'{{ $m }}')">
                                </div>
                                @endforeach
                            </div>

                            <!-- Camera Modal -->
                            <div x-show="cameraOpen" class="camera-modal" x-cloak>
                                <div class="camera-container">
                                    <div class="camera-view">
                                        <video x-ref="video" autoplay playsinline class="camera-video"></video>
                                    </div>
                                    <div class="camera-controls">
                                        <button type="button" @click="stopCamera" class="btn-close-camera">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                        <button type="button" @click="capture" class="btn-capture">
                                            <div class="btn-capture-inner"></div>
                                        </button>
                                        <div style="width:3.5rem"></div> <!-- Spacer for balance -->
                                    </div>
                                </div>
                            </div>

                            <div class="geo-status-box" :class="geoStatus === 'success' ? 'status-success' : geoStatus === 'error' ? 'status-error' : 'status-pending'">
                                <div class="status-icon" :class="geoStatus === 'success' ? 'icon-green' : geoStatus === 'error' ? 'icon-red' : 'icon-blue'">
                                    <svg x-show="!geoStatus" style="width:1rem;height:1rem;animation:spin 1s linear infinite" fill="none" viewBox="0 0 24 24"><circle style="opacity:0.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path style="opacity:0.75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                                    <svg x-show="geoStatus === 'success'" style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    <svg x-show="geoStatus === 'error'" style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                </div>
                                <div>
                                    <p class="status-title" x-text="geoMessage"></p>
                                    <p class="status-sub">Géolocalisation automatique</p>
                                </div>
                            </div>

                            <div class="form-footer">
                                <button type="button" @click="step = 1" class="btn-back">← Retour</button>
                                <button type="submit" class="btn-submit btn-orange" :disabled="geoStatus === 'error'">
                                    <svg style="width:1rem;height:1rem;display:inline-block;margin-right:0.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    Envoyer l'alerte
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="hero-footer-badges">
                    <div class="footer-badge"><div class="badge-dot-small" style="background:#4ade80"></div><span class="badge-text-small">Sécurisé SSL</span></div>
                    <div class="footer-badge"><div class="badge-dot-small" style="background:var(--orange-onpc)"></div><span class="badge-text-small">Temps réel</span></div>
                    <div class="footer-badge"><div class="badge-dot-small" style="background:#60a5fa"></div><span class="badge-text-small">Urgence 24/7</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- --- How it works --- -->
    <section class="section section-white">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Comment ça marche</span>
                <h2 class="section-title">En 3 étapes simples</h2>
            </div>
            <div class="steps-grid">
                @foreach([
                    ['01','Déclarez','Remplissez le formulaire avec les informations de l\'incident et vos coordonnées.','🖊️','#eff6ff','#0000cc'],
                    ['02','Localisez','Votre position GPS est automatiquement transmise aux équipes de secours.','📍','#fff7ed','#ff8300'],
                    ['03','Secours','La caserne la plus proche est alertée et dépêchée sur les lieux immédiatement.','🚒','#fef2f2','#ef4444'],
                ] as [$num,$title,$desc,$icon,$bg,$color])
                <div class="step-card">
                    <div class="step-icon-box" style="background:{{ $bg }}; color:{{ $color }}">{{ $icon }}</div>
                    <div class="step-num-bg">{{ $num }}</div>
                    <h3 class="step-title">{{ $title }}</h3>
                    <p class="step-desc">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- --- CTA Section --- -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Une structure partenaire ?</h2>
            <p class="cta-desc">Accédez à votre espace dédié pour déclarer des sinistres et coordonner vos interventions avec l'ONPC.</p>
            <a href="{{ route('structure.auth.login') }}" class="cta-btn">
                <svg style="width:1.25rem;height:1.25rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                <span>Accéder à l'espace Structure</span>
            </a>
        </div>
    </section>

    <!-- --- Footer --- -->
    <footer class="footer">
        <div class="container footer-inner">
            <div class="footer-logo">
                <img src="{{ asset('assets/images/logo_onpc.png') }}" alt="ONPC" class="footer-logo-img">
                <span class="footer-logo-text">Office National de la Protection Civile</span>
            </div>
            <p class="footer-copy">© {{ date('Y') }} ONPC — République de Côte d'Ivoire</p>
        </div>
    </footer>

    <script>
        function geoHandler() {
            return {
                latitude: null, longitude: null,
                geoStatus: null,
                geoMessage: 'Récupération de votre position...',
                init() {
                    if ("geolocation" in navigator) {
                        navigator.geolocation.getCurrentPosition(
                            (p) => {
                                this.latitude = p.coords.latitude;
                                this.longitude = p.coords.longitude;
                                this.geoStatus = 'success';
                                this.geoMessage = 'Position enregistrée avec succès';
                            },
                            () => {
                                this.geoStatus = 'error';
                                this.geoMessage = 'Accès à la position refusé';
                            }
                        );
                    } else {
                        this.geoStatus = 'error';
                        this.geoMessage = 'Géolocalisation non supportée';
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Alerte Envoyée !',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#0000cc',
                    customClass: { popup: 'rounded-3xl', confirmButton: 'radius-xl font-black uppercase tracking-widest text-xs' }
                });
            @endif
        });
    </script>
</body>
</html>
