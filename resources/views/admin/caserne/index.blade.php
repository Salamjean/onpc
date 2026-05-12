@extends('admin.layouts.app')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-onpc-blue to-blue-600">Liste des Casernes</h1>
        <p class="text-gray-500 mt-2 font-medium">Visualisez et gérez l'ensemble des casernes opérationnelles.</p>
    </div>
    <a href="{{ route('admin.caserne.create') }}" class="group flex items-center bg-onpc-orange hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-onpc-orange/20 transition-all duration-300 transform hover:-translate-y-1">
        <div class="bg-white/20 p-1 rounded-lg mr-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
        </div>
        Ajouter une caserne
    </a>
</div>

<!-- Filtres et Recherche -->
<div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row gap-4 items-center justify-between">
    <div class="relative w-full md:w-96">
        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </span>
        <input type="text" placeholder="Rechercher une caserne..." class="block w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-onpc-blue/20 focus:border-onpc-blue focus:bg-white transition-all outline-none text-sm">
    </div>
    <div class="flex gap-3 w-full md:w-auto">
        <select class="bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-onpc-blue/20 outline-none">
            <option>Toutes les communes</option>
        </select>
        <button class="bg-onpc-blue/10 text-onpc-blue p-3 rounded-2xl hover:bg-onpc-blue hover:text-white transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 8.293A1 1 0 013 7.586V4z"></path></svg>
        </button>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-xl shadow-onpc-blue/5 border border-gray-100 overflow-hidden">
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
                <tr class="hover:bg-blue-50/30 transition-all duration-200 group">
                    <td class="py-5 px-8">
                        <div class="flex items-center">
                            <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-onpc-blue to-blue-400 flex items-center justify-center text-white font-bold text-lg shadow-md group-hover:scale-110 transition-transform overflow-hidden">
                                @if($caserne->logo)
                                    <img src="{{ asset('storage/' . $caserne->logo) }}" alt="Logo" class="h-full w-full object-cover">
                                @else
                                    {{ substr($caserne->name, 0, 1) }}
                                @endif
                            </div>
                            <div class="ml-4 text-left">
                                <p class="text-sm font-bold text-gray-900 leading-none">{{ $caserne->name }}</p>
                                <p class="text-xs text-gray-500 mt-1.5">Inscrit le {{ $caserne->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <div class="inline-flex flex-col items-center space-y-1">
                            <div class="flex items-center text-xs text-gray-600">
                                <svg class="w-3.5 h-3.5 mr-2 text-onpc-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $caserne->email }}
                            </div>
                            <div class="flex items-center text-xs text-gray-600">
                                <svg class="w-3.5 h-3.5 mr-2 text-onpc-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $caserne->telephone ?? 'N/A' }}
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <div class="inline-flex items-center justify-between group/geo">
                            <div class="text-center">
                                <p class="font-bold text-gray-700 text-xs">{{ $caserne->commune }}</p>
                                <p class="text-[11px] text-gray-500 truncate w-32 mt-1">{{ $caserne->adresse }}</p>
                            </div>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $caserne->latitude }},{{ $caserne->longitude }}" target="_blank" class="ml-2 p-2 bg-onpc-blue/5 text-onpc-blue rounded-lg opacity-0 group-hover/geo:opacity-100 hover:bg-onpc-blue hover:text-white transition-all duration-300 shadow-sm" title="Voir sur Google Maps">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </a>
                        </div>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <span class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                            @if($caserne->status == 'active' || is_null($caserne->status)) bg-green-100 text-green-700 @else bg-gray-100 text-gray-600 @endif">
                            {{ ($caserne->status == 'active' || is_null($caserne->status)) ? 'Opérationnel' : 'Archivé' }}
                        </span>
                    </td>
                    <td class="py-5 px-8 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <!-- Détails -->
                            <a href="{{ route('admin.caserne.show', $caserne) }}" class="p-2.5 rounded-xl bg-blue-50 text-onpc-blue hover:bg-onpc-blue hover:text-white transition-all duration-300" title="Détails">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <!-- Modifier -->
                            <a href="{{ route('admin.caserne.edit', $caserne) }}" class="p-2.5 rounded-xl bg-orange-50 text-onpc-orange hover:bg-onpc-orange hover:text-white transition-all duration-300" title="Modifier">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <!-- Supprimer (Archive) -->
                            <form action="{{ route('admin.caserne.destroy', $caserne) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment archiver cette caserne ?');" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2.5 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300" title="Archiver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="bg-gray-100 p-6 rounded-full mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <p class="text-gray-500 font-bold">Aucune caserne trouvée.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection