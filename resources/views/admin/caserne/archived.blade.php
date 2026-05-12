

@extends('admin.layouts.app')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-900">Archives des Casernes</h1>
        <p class="text-gray-500 mt-2 font-medium">Gestion des unités opérationnelles désactivées.</p>
    </div>
    <a href="{{ route('admin.caserne.index') }}" class="flex items-center bg-white border border-gray-200 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-50 transition-all duration-300">
        Retour à la liste active
    </a>
</div>

<!-- Filtres et Recherche -->
<div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row gap-4 items-center justify-between">
    <div class="relative w-full md:w-96">
        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </span>
        <input type="text" placeholder="Rechercher dans les archives..." class="block w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-200 focus:border-red-600 focus:bg-white transition-all outline-none text-sm">
    </div>
</div>

<div class="bg-white rounded-3xl shadow-xl shadow-red-900/5 border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-center border-collapse">
            <thead>
                <tr class="bg-gray-50/80 border-b border-gray-100">
                    <th class="py-5 px-8 font-bold text-xs uppercase tracking-wider text-gray-500">Caserne</th>
                    <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-gray-500 text-center">Contact</th>
                    <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-gray-500 text-center">Localisation</th>
                    <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-gray-500 text-center">Statut</th>
                    <th class="py-5 px-8 font-bold text-xs uppercase tracking-wider text-gray-500 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($casernes as $caserne)
                <tr class="hover:bg-red-50/30 transition-all duration-200 group">
                    <td class="py-5 px-8">
                        <div class="flex items-center">
                            <div class="h-12 w-12 rounded-2xl bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-lg shadow-sm grayscale group-hover:grayscale-0 transition-all overflow-hidden">
                                @if($caserne->logo)
                                    <img src="{{ asset('storage/' . $caserne->logo) }}" alt="Logo" class="h-full w-full object-cover">
                                @else
                                    {{ substr($caserne->name, 0, 1) }}
                                @endif
                            </div>
                            <div class="ml-4 text-left">
                                <p class="text-sm font-bold text-gray-400 leading-none group-hover:text-gray-900 transition-colors">{{ $caserne->name }}</p>
                                <p class="text-xs text-gray-400 mt-1.5 italic">Archivé le {{ $caserne->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <div class="inline-flex flex-col items-center space-y-1 opacity-50 group-hover:opacity-100 transition-opacity">
                            <div class="flex items-center text-xs text-gray-600">
                                {{ $caserne->email }}
                            </div>
                            <div class="flex items-center text-xs text-gray-600">
                                {{ $caserne->telephone ?? 'N/A' }}
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <div class="inline-flex flex-col items-center opacity-50 group-hover:opacity-100 transition-opacity">
                            <p class="font-bold text-gray-700 text-xs">{{ $caserne->commune }}</p>
                            <p class="text-[11px] text-gray-500 truncate w-32 mt-1">{{ $caserne->adresse }}</p>
                        </div>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <span class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-500 border border-gray-200">
                            Archivé
                        </span>
                    </td>
                    <td class="py-5 px-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <!-- Restaurer -->
                            <form action="{{ route('admin.caserne.update', $caserne) }}" method="POST" class="inline">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="active">
                                <input type="hidden" name="name" value="{{ $caserne->name }}">
                                <input type="hidden" name="email" value="{{ $caserne->email }}">
                                <input type="hidden" name="telephone" value="{{ $caserne->telephone }}">
                                <input type="hidden" name="commune" value="{{ $caserne->commune }}">
                                <input type="hidden" name="adresse" value="{{ $caserne->adresse }}">
                                <button type="submit" class="p-2.5 rounded-xl bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition-all duration-300" title="Restaurer l'unité">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </button>
                            </form>
                            <!-- Supprimer Définitivement -->
                            <form action="{{ route('admin.caserne.destroy', $caserne) }}" method="POST" onsubmit="return confirm('Supprimer DEFINITIVEMENT cette caserne ? Cette action est irréversible.');" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2.5 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300" title="Supprimer définitivement">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-20 text-center text-gray-400 italic">
                        Aucune caserne dans les archives.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
