<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Liste des techniciens</h1>
                <a href="{{ route('techniciens.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajouter un technicien</a>
            </div>
            <form method="GET" action="" class="mb-4 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Recherche nom, prénom, téléphone..." class="border rounded px-2 py-1 w-64" />
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
                        <th class="border px-2 py-1">Nom</th>
                        <th class="border px-2 py-1">Prénom</th>
                        <th class="border px-2 py-1">Téléphone</th>
                        <th class="border px-2 py-1">Propriétaire</th>
                        <th class="border px-2 py-1">Zone de maintenance</th>
                        <th class="border px-2 py-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($techniciens as $technicien)
                        <tr>
                            <td class="border px-2 py-1 uppercase">{{ $technicien->nom_tech }}</td>
                            <td class="border px-2 py-1">{{ $technicien->prenom_tech }}</td>
                            <td class="border px-2 py-1">{{ $technicien->tel_tech }}</td>
                            <td class="border px-2 py-1 text-center">{{ $technicien->est_proprietaire ? 'Oui' : 'Non' }}</td>
                            <td class="border px-2 py-1">{{ $technicien->zoneMaintenance->nom_zone ?? '-' }}</td>
                            <td class="border px-2 py-1 text-center">
                                <a href="{{ route('techniciens.show', $technicien) }}" class="text-blue-600 hover:underline">Voir</a>
                                <a href="{{ route('techniciens.edit', $technicien) }}" class="ml-2 text-green-600 hover:underline">Modifier</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-2">Aucun technicien trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> 