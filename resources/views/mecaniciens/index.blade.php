<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Liste des mécaniciens</h1>
                <a href="{{ route('mecaniciens.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Ajouter un mécanicien</span>
                </a>
            </div>

            {{-- Barre de recherche --}}
            <form method="GET" action="{{ route('mecaniciens.index') }}" class="mb-4 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un mécanicien..." class="border rounded px-2 py-1 w-64" />
                <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Rechercher</button>
            </form>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif

            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="border px-2 py-1">N°</th>
                        <th class="border px-2 py-1">Nom</th>
                        <th class="border px-2 py-1">Prénom</th>
                        <th class="border px-2 py-1">Téléphone</th>
                        <th class="border px-2 py-1">Zone de maintenance</th>
                        <th class="border px-2 py-1">Est propriétaire</th>
                        <th class="border px-2 py-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @forelse($mecaniciens as $mecanicien)
                        <tr>
                            <td class="border px-2 py-1 text-center">{{ $i++ }}</td>
                            <td class="border px-2 py-1">{{ $mecanicien->nom_mecanicien }}</td>
                            <td class="border px-2 py-1">{{ $mecanicien->prenom_mecanicien }}</td>
                            <td class="border px-2 py-1">{{ $mecanicien->telephone_mecanicien }}</td>
                            <td class="border px-2 py-1">{{ $mecanicien->zoneMaintenance->nom_zone ?? '-' }}</td>
                            <td class="border px-2 py-1">
                                @if($mecanicien->est_proprietaire)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Oui</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">Non</span>
                                @endif
                            </td>
                            <td class="border px-2 py-1 text-center">
                                <div class="flex space-x-4 justify-center font-bold">
                                    <a href="{{ route('mecaniciens.show', $mecanicien) }}" class="flex flex-col items-center text-blue-600 hover:text-blue-900 mx-2">
                                        <i class="fas fa-eye text-sm"></i>
                                        <span class="text-sm">Détails</span>
                                    </a>
                                    <a href="{{ route('mecaniciens.edit', $mecanicien) }}" class="flex flex-col items-center text-yellow-600 hover:text-yellow-900 mx-2">
                                        <i class="fas fa-edit text-sm"></i>
                                        <span class="text-sm">Modifier</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-2">Aucun mécanicien trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> 