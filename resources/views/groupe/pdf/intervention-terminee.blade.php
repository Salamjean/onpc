<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Rapport d'Intervention - {{ $sinistre->reference }}</title>
    <style>
        @page {
            margin: 160px 40px 60px 40px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #0f172a;
            font-size: 9.5pt;
            line-height: 1.4;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Watermark */
        #watermark {
            position: fixed;
            top: 25%;
            left: 10%;
            width: 80%;
            z-index: -1000;
            opacity: 0.04;
        }

        /* Repeating Header */
        header {
            position: fixed;
            top: -130px;
            left: 0;
            right: 0;
            height: 120px;
            text-align: center;
        }

        .header-top-border {
            position: fixed;
            top: -160px;
            left: -40px;
            right: -40px;
            height: 12px;
            background: linear-gradient(to right, #1e3a8a, #3b82f6);
        }

        .logo-main {
            height: 60px;
            margin-bottom: 5px;
        }

        .republique {
            font-size: 8pt;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 2px;
        }

        .org-name {
            font-size: 10pt;
            font-weight: 800;
            color: #1e3a8a;
            margin-bottom: 5px;
        }

        .doc-title {
            font-size: 16pt;
            font-weight: 900;
            color: #0f172a;
            text-transform: uppercase;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            padding: 5px 0;
            margin: 5px 0;
            background-color: #f8fafc;
        }

        /* Footer */
        footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            height: 30px;
            font-size: 8pt;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
            text-align: center;
        }

        .pagenum:before {
            content: counter(page);
        }

        /* Sections & Grids */
        .container {
            width: 100%;
        }

        .section-box {
            margin-bottom: 15px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }

        .section-label {
            background-color: #1e3a8a;
            color: #ffffff;
            padding: 5px 12px;
            font-size: 8.5pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .section-content {
            padding: 12px;
        }

        .grid-table {
            width: 100%;
            border-collapse: collapse;
        }

        .grid-table td {
            padding: 8px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }

        .grid-table tr:last-child td {
            border-bottom: none;
        }

        .field-label {
            font-size: 7.5pt;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            width: 30%;
        }

        .field-value {
            font-weight: 600;
            color: #1e293b;
        }

        /* Bilan visual */
        .bilan-grid {
            width: 100%;
            margin-top: 5px;
        }

        .bilan-cell {
            width: 33.33%;
            padding: 10px;
            text-align: center;
            border-right: 1px solid #f1f5f9;
        }

        .bilan-cell:last-child {
            border-right: none;
        }

        .bilan-num {
            font-size: 18pt;
            font-weight: 900;
            display: block;
        }

        .bilan-txt {
            font-size: 7.5pt;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
        }

        .color-red { color: #ef4444; }
        .color-orange { color: #f59e0b; }
        .color-green { color: #10b981; }

        /* Description Box */
        .desc-text {
            font-size: 9pt;
            color: #334155;
            line-height: 1.5;
            white-space: pre-line;
        }

        .report-highlight {
            background-color: #f8fafc;
            border-left: 3px solid #1e3a8a;
            padding: 15px;
            font-style: italic;
            font-size: 9.5pt;
        }

        /* Image Gallery */
        .gallery-grid {
            width: 100%;
        }

        .photo-card {
            display: inline-block;
            width: 48%;
            margin-right: 1%;
            margin-bottom: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 4px;
            background-color: #f8fafc;
        }

        .photo-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 2px;
        }

        .photo-caption {
            font-size: 7pt;
            text-align: center;
            padding: 4px 0;
            font-weight: bold;
            color: #64748b;
        }

        /* Status Badge */
        .status-badge {
            background-color: #10b981;
            color: white;
            padding: 2px 10px;
            border-radius: 10px;
            font-size: 8pt;
            font-weight: bold;
            position: absolute;
            top: 20px;
            right: 0;
        }

        .sig-container {
            margin-top: 30px;
            width: 100%;
        }

        .sig-box {
            width: 50%;
            text-align: center;
        }

        .sig-label {
            font-size: 8pt;
            font-weight: bold;
            color: #64748b;
            margin-bottom: 40px;
        }

        .sig-line {
            border-top: 1px solid #000;
            width: 150px;
            margin: 0 auto;
            padding-top: 5px;
            font-weight: bold;
            font-size: 9pt;
        }
    </style>
</head>

<body>
    @php
        $logoPath = public_path('assets/images/logo_onpc.png');
        $logoData = '';
        if (file_exists($logoPath)) {
            $logoData = base64_encode(file_get_contents($logoPath));
        }
    @endphp

    <div id="watermark">
        @if ($logoData)
            <img src="data:image/png;base64,{{ $logoData }}" style="width: 100%;">
        @endif
    </div>

    <div class="header-top-border"></div>

    <header>
        <div class="republique">République de Côte d'Ivoire</div>
        <div class="org-name">Office National de la Protection Civile</div>
        @if ($logoData)
            <img src="data:image/png;base64,{{ $logoData }}" class="logo-main">
        @endif
        <div class="doc-title">Rapport d'Intervention Terminé</div>
        <div style="font-weight: bold; color: #1e3a8a; font-size: 9pt;">Réf: {{ $sinistre->reference }}</div>
        <div class="status-badge">CLÔTURÉ</div>
    </header>

    <footer>
        ONPC - Système de Gestion des Interventions - Page <span class="pagenum"></span> - Édité le {{ now()->format('d/m/Y H:i') }}
    </footer>

    <div class="container">
        <div class="section-box">
            <div class="section-label">I. Identification de l'Incident</div>
            <div class="section-content">
                <table class="grid-table">
                    <tr>
                        <td class="field-label">Type d'incident</td>
                        <td class="field-value">{{ $sinistre->type_sinistre }}</td>
                        <td class="field-label">Référence interne</td>
                        <td class="field-value">{{ $sinistre->reference }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Localisation</td>
                        <td class="field-value" colspan="3">{{ $sinistre->lieu ?? 'Non renseigné' }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Déclarant</td>
                        <td class="field-value">{{ $sinistre->nom_complet }}</td>
                        <td class="field-label">Contact</td>
                        <td class="field-value">{{ $sinistre->contact }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section-box">
            <div class="section-label">II. Chronologie & Unité</div>
            <div class="section-content">
                <table class="grid-table">
                    <tr>
                        <td class="field-label">Unité d'intervention</td>
                        <td class="field-value">{{ $groupe->name }} ({{ $caserne->name ?? 'N/A' }})</td>
                    </tr>
                    <tr>
                        <td class="field-label">Date de déclaration</td>
                        <td class="field-value">{{ $sinistre->created_at->format('d/m/Y \à H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Date de clôture</td>
                        <td class="field-value">{{ optional($sinistre->date_cloture)->format('d/m/Y \à H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section-box">
            <div class="section-label">III. Bilan Humain Répertorié</div>
            <div class="section-content" style="padding: 0;">
                <table class="bilan-grid">
                    <tr>
                        <td class="bilan-cell">
                            <span class="bilan-num color-red">{{ $sinistre->nb_morts ?? 0 }}</span>
                            <span class="bilan-txt">Décès</span>
                        </td>
                        <td class="bilan-cell">
                            <span class="bilan-num color-orange">{{ $sinistre->nb_blesses ?? 0 }}</span>
                            <span class="bilan-txt">Blessés</span>
                        </td>
                        <td class="bilan-cell">
                            <span class="bilan-num color-green">{{ $sinistre->nb_evacues ?? 0 }}</span>
                            <span class="bilan-txt">Évacués</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section-box">
            <div class="section-label">IV. Rapport d'Intervention (Observations Terrain)</div>
            <div class="section-content">
                <div class="report-highlight">
                    {{ $sinistre->rapport_intervention ?: 'Aucun rapport détaillé enregistré pour cette intervention.' }}
                </div>
            </div>
        </div>

        <div class="section-box">
            <div class="section-label">V. Description Initiale des Faits</div>
            <div class="section-content">
                <div class="desc-text">
                    {{ $sinistre->description ?: 'Aucune description fournie lors de l\'alerte.' }}
                </div>
            </div>
        </div>

        @php
            $photos = [];
            if ($sinistre->image1) $photos[] = ['p' => $sinistre->image1, 'l' => 'Vue Initial 1'];
            if ($sinistre->image2) $photos[] = ['p' => $sinistre->image2, 'l' => 'Vue Initial 2'];
            
            $docs = is_array($sinistre->etat_des_lieux_documents) ? $sinistre->etat_des_lieux_documents : [];
            foreach ($docs as $i => $d) {
                if (in_array(strtolower(pathinfo($d, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp'])) {
                    $photos[] = ['p' => $d, 'l' => 'Constat Terrain ' . ($i+1)];
                }
            }
        @endphp

        @if(count($photos) > 0)
        <div class="section-box" style="page-break-before: always;">
            <div class="section-label">VI. Annexes Photographiques</div>
            <div class="section-content">
                <div class="gallery-grid">
                    @foreach($photos as $photo)
                        @php
                            $p = storage_path('app/public/' . $photo['p']);
                            if (!file_exists($p)) $p = public_path('storage/' . $photo['p']);
                            $b64 = file_exists($p) ? base64_encode(file_get_contents($p)) : '';
                            $mime = $b64 ? 'image/' . pathinfo($p, PATHINFO_EXTENSION) : '';
                        @endphp
                        @if($b64)
                        <div class="photo-card">
                            <img src="data:{{ $mime }};base64,{{ $b64 }}">
                            <div class="photo-caption">{{ $photo['l'] }}</div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="sig-container" style="page-break-inside: avoid;">
            <table style="width: 100%;">
                <tr>
                    <td class="sig-box">
                        <div class="sig-label">LE CHEF D'AGRÈS / RESPONSABLE GROUPE</div>
                        <div class="sig-line">{{ $groupe->name }}</div>
                    </td>
                    <td class="sig-box">
                        <div class="sig-label">VISA DE LA CASERNE / UNITÉ</div>
                        <div class="sig-line">{{ $caserne->name ?? 'ONPC' }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
