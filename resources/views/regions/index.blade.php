<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="w-full max-w-xl mx-auto">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h1 class="text-2xl font-bold mb-4">Liste des régions</h1>
                <a href="{{ route('regions.create') }}" class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajouter une région</a>
            </div>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="border px-2 py-1">Nom de la région</th>
                        <th class="border px-2 py-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($regions as $region)
                        <tr>
                            <td class="border px-2 py-1">{{ $region->nom_region }}</td>
                            <td class="border px-2 py-1">
                                <a href="{{ route('regions.show', $region) }}" class="text-blue-600 hover:underline">Voir</a>
                                <a href="{{ route('regions.edit', $region) }}" class="ml-2 text-green-600 hover:underline">Modifier</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-2">Aucune région trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> 