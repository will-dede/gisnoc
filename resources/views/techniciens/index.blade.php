<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Liste des techniciens</h1>
                @if(auth()->user()->role === 'noc_engineer' || auth()->user()->role === 'network_lead' || auth()->user()->role === 'superadmin')
                <a href="{{ route('techniciens.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Ajouter un technicien</span>
                </a>
                @endif
            </div>

            {{-- Barre de recherche --}}
            <form method="GET" action="{{ route('techniciens.index') }}" class="mb-4 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un technicien..." class="border rounded px-2 py-1 w-64" />
                <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Rechercher</button>
            </form>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif

            <table class="min-w-full bg-white border">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="border px-2 py-2">N°</th>
                        <th class="border px-2 py-2">Nom</th>
                        <th class="border px-2 py-2">Prénom</th>
                        <th class="border px-2 py-2">Téléphone</th>
                        <th class="border px-2 py-2">Zone de maintenance</th>
                        <th class="border px-2 py-2">Est propriétaire</th>
                        <th class="border px-2 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @forelse($techniciens as $technicien)
                        <tr>
                            <td class="border px-2 py-1 text-center">{{ $i++ }}</td>
                            <td class="border px-2 py-1">{{ $technicien->nom_tech }}</td>
                            <td class="border px-2 py-1">{{ $technicien->prenom_tech }}</td>
                            <td class="border px-2 py-1 text-center">{{ $technicien->tel_tech }}</td>
                            <td class="border px-2 py-1">{{ $technicien->zoneMaintenance->nom_zone ?? '-' }}</td>
                            <td class="border px-2 py-1 text-center">
                                {{-- Affichage de l'état propriétaire --}}
                                @if($technicien->est_proprietaire)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Oui</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">Non</span>
                                @endif
                            </td>
                            <td class="border px-2 py-1 text-center">
                                <div class="flex space-x-4 justify-center font-bold">
                                    <a href="{{ route('techniciens.show', $technicien) }}" class="flex flex-col items-center text-blue-600 hover:text-blue-900 mx-2">
                                        <i class="fas fa-eye text-sm"></i>
                                        <span class="text-sm">Détails</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-2">Aucun technicien trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> 