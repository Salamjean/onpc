@extends('caserne.layouts.app')

@section('content')
    <div class="mb-10 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none uppercase">
                Tableau de bord <span class="text-caserne-red">Statistiques</span>
            </h1>
            <p class="text-slate-500 mt-3 font-bold text-xs flex items-center gap-2 uppercase tracking-widest">
                <span class="w-2 h-2 rounded-full bg-caserne-red animate-pulse"></span>
                Vue de synthese des sinistres et des tendances
            </p>
        </div>

        <a href="{{ route('caserne.sinistres.index') }}"
            class="inline-flex items-center justify-center gap-2 bg-caserne-red text-white px-6 py-4 rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-red-900/20 hover:scale-[1.01] transition-all">
            Voir les sinistres en attente
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400">En attente</p>
            <p class="text-4xl font-black text-slate-900 mt-3">{{ $sinistresEnAttente }}</p>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400">En cours</p>
            <p class="text-4xl font-black text-slate-900 mt-3">{{ $sinistresEnCours }}</p>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Terminés</p>
            <p class="text-4xl font-black text-slate-900 mt-3">{{ $sinistresTermines }}</p>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Dans votre zone</p>
            <p class="text-4xl font-black text-slate-900 mt-3">{{ $sinistresZone }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-xl shadow-slate-200/40">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Répartition par statut</h2>
                    <p class="text-sm text-slate-500 font-medium mt-1">Vue rapide du volume opérationnel</p>
                </div>
            </div>
            <div class="h-80">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-xl shadow-slate-200/40">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Répartition par type</h2>
                    <p class="text-sm text-slate-500 font-medium mt-1">Incendie, accident et autres déclarations</p>
                </div>
            </div>
            <div class="h-80">
                <canvas id="typeChart"></canvas>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-3xl p-8 border border-slate-100 shadow-xl shadow-slate-200/40">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">2 dernieres declarations</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">Derniers sinistres recus dans votre zone</p>
            </div>

            <a href="{{ route('caserne.sinistres.index') }}"
                class="inline-flex items-center justify-center gap-2 bg-caserne-red text-white px-5 py-3 rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-xl shadow-red-900/20 hover:scale-[1.01] transition-all">
                Voir la liste des sinistres
            </a>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left border-separate border-spacing-y-1 min-w-[900px]">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">
                        <th class="px-6 py-4 text-center">Reference</th>
                        <th class="px-6 py-4 text-center">Declarant</th>
                        <th class="px-6 py-4 text-center">Type</th>
                        <th class="px-6 py-4 text-center">Lieu</th>
                        <th class="px-6 py-4 text-center">Date</th>
                        <th class="px-6 py-4 text-center">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dernieresDeclarations as $sinistre)
                        <tr class="bg-white shadow-sm rounded-2xl ring-1 ring-slate-100">
                            <td class="px-6 py-4 text-center font-black text-slate-900 text-sm">
                                {{ $sinistre->reference ?? '#SN-' . $sinistre->id }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="font-bold text-slate-800">{{ $sinistre->nom_complet }}</span>
                                    <span class="text-xs font-semibold text-slate-500">{{ $sinistre->contact }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-100 text-slate-700">
                                    {{ $sinistre->type_sinistre }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-semibold text-slate-600">
                                {{ $sinistre->lieu ?? ($sinistre->latitude . ', ' . $sinistre->longitude) }}
                            </td>
                            <td class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ $sinistre->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $sinistre->status === 'en_attente' ? 'bg-amber-100 text-amber-700' : ($sinistre->status === 'en_cours' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700') }}">
                                    {{ str_replace('_', ' ', $sinistre->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-14 text-center text-sm font-semibold text-slate-400">
                                Aucune declaration disponible.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const statusCtx = document.getElementById('statusChart');
        const typeCtx = document.getElementById('typeChart');
        const typeLabels = {!! json_encode($statsParType->keys()->values()) !!};

        const typeColorMap = {
            incendie: '#ef4444',
            accident: '#f97316',
            inondation: '#0ea5e9',
            effondrement: '#8b5cf6',
            medical: '#10b981',
            'autre': '#64748b',
        };

        const typePalette = ['#ef4444', '#f97316', '#0ea5e9', '#8b5cf6', '#10b981', '#64748b', '#06b6d4', '#84cc16'];

        const normalizeType = (label) =>
            String(label)
            .trim()
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '');

        const typeColors = typeLabels.map((label, index) => {
            const key = normalizeType(label);
            return typeColorMap[key] ?? typePalette[index % typePalette.length];
        });

        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($statsParStatut)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($statsParStatut)) !!},
                    backgroundColor: ['#f97316', '#2563eb', '#16a34a'],
                    borderWidth: 0,
                    hoverOffset: 6,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                },
            },
        });

        new Chart(typeCtx, {
            type: 'bar',
            data: {
                labels: typeLabels,
                datasets: [{
                    label: 'Nombre de sinistres',
                    data: {!! json_encode($statsParType->values()) !!},
                    backgroundColor: typeColors,
                    borderRadius: 16,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });
    </script>
@endsection
