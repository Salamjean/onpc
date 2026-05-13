@extends('admin.layouts.app')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-onpc-blue to-blue-600">
                Liste des Structures</h1>
            <p class="text-gray-500 mt-2 font-medium">Gérez les structures partenaires enregistrées sur la plateforme.</p>
        </div>
        <a href="{{ route('admin.structure.create') }}"
            class="group flex items-center bg-onpc-orange hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-onpc-orange/20 transition-all duration-300 transform hover:-translate-y-1">
            <div class="bg-white/20 p-1 rounded-lg mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            Ajouter une structure
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-onpc-blue/5 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100">
                        <th class="py-5 px-8 font-bold text-xs uppercase tracking-wider text-gray-500 text-center">Structure
                        </th>
                        <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-gray-500 text-center">Contact /
                            Email</th>
                        <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-gray-500 text-center">
                            Localisation</th>
                        <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-gray-500 text-center">Statut
                        </th>
                        <th class="py-5 px-8 font-bold text-xs uppercase tracking-wider text-gray-500 text-center">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($structures as $structure)
                        <tr class="hover:bg-blue-50/30 transition-all duration-200 group">
                            <td class="py-5 px-8 text-center">
                                <div class="flex items-center justify-center">
                                    <div
                                        class="h-12 w-12 rounded-2xl bg-gradient-to-br from-onpc-blue to-blue-400 flex items-center justify-center text-white font-bold text-lg shadow-md group-hover:scale-110 transition-transform overflow-hidden">
                                        {{ substr($structure->nom, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-bold text-gray-900 leading-none">{{ $structure->nom }}</p>
                                        <p class="text-xs text-gray-500 mt-1.5">Inscrite le
                                            {{ $structure->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="text-xs font-bold text-gray-700">{{ $structure->contact }}</span>
                                    <span class="text-[11px] text-onpc-blue font-medium">{{ $structure->email }}</span>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs font-bold text-gray-700">{{ $structure->commune }}</span>
                                    <span class="text-[11px] text-gray-400 mt-1">{{ $structure->ville }}</span>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                @php
                                    $statusLabel =
                                        $structure->status == 'active'
                                            ? 'Compte Actif'
                                            : ($structure->status == 'inactive'
                                                ? 'Bloqué'
                                                : 'En attente');
                                    $statusClass =
                                        $structure->status == 'active'
                                            ? 'bg-green-100 text-green-700'
                                            : ($structure->status == 'inactive'
                                                ? 'bg-red-100 text-red-700'
                                                : 'bg-yellow-100 text-yellow-700');
                                @endphp
                                <span
                                    class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="py-5 px-8 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if ($structure->status !== 'active')
                                        <form action="{{ route('admin.structure.resend', $structure) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="p-2.5 rounded-xl bg-blue-50 text-onpc-blue hover:bg-onpc-blue hover:text-white transition-all duration-300"
                                                title="Renvoyer l'invitation">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.structure.edit', $structure) }}"
                                        class="p-2.5 rounded-xl bg-orange-50 text-onpc-orange hover:bg-onpc-orange hover:text-white transition-all duration-300"
                                        title="Modifier">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    @if ($structure->status !== 'inactive')
                                        <form action="{{ route('admin.structure.block', $structure) }}" method="POST"
                                            onsubmit="return confirm('Voulez-vous vraiment bloquer cette structure ? Elle ne pourra plus se connecter.');"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="p-2.5 rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white transition-all duration-300"
                                                title="Bloquer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M5 19a7 7 0 0114 0" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M4 4l16 16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.structure.unblock', $structure) }}" method="POST"
                                            onsubmit="return confirm('Voulez-vous vraiment débloquer cette structure ?');"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="p-2.5 rounded-xl bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition-all duration-300"
                                                title="Débloquer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.structure.destroy', $structure) }}" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer cette structure ?');"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-2.5 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300"
                                            title="Supprimer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-20 text-center text-gray-500 font-bold">Aucune structure
                                enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
