<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Liste des zones de maintenance</h1>
                <a href="{{ route('zonemaintenance.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Ajouter une zone</span>
                </a>
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
                        <th class="border px-2 py-1">N°</th>
                        <th class="border px-2 py-1">Nom de la zone</th>
                        <th class="border px-2 py-1">Description</th>
                        <th class="border px-2 py-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @forelse($zonemaintenance as $zone)
                        <tr>
                            <td class="border px-2 py-1 text-center">{{ $i++ }}</td>
                            <td class="border px-2 py-1">{{ $zone->nom_zone }}</td>
                            <td class="border px-2 py-1">{{ $zone->description }}</td>
                            <td class="border px-2 py-1 text-center">
                                <div class="flex space-x-4 justify-center font-bold">
                                    <a href="{{ route('zonemaintenance.show', $zone) }}" class="flex flex-col items-center text-blue-600 hover:text-blue-900 mx-2">
                                        <i class="fas fa-eye text-sm"></i>
                                        <span class="text-sm">Détails</span>
                                    </a>
                                    <a href="{{ route('zonemaintenance.edit', $zone) }}" class="flex flex-col items-center text-yellow-600 hover:text-yellow-900 mx-2">
                                        <i class="fas fa-edit text-sm"></i>
                                        <span class="text-sm">Modifier</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-2">Aucune zone de maintenance trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> 