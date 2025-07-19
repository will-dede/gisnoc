<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Liste des types d'alarme</h1>
                <a href="{{ route('typealarme.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajouter un type</a>
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
                        <th class="border px-2 py-1">Nom du type</th>
                        <th class="border px-2 py-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($typealarme as $type)
                        <tr>
                            <td class="border px-2 py-1">{{ $type->nom_type_alarme }}</td>
                            <td class="border px-2 py-1">
                                <a href="{{ route('typealarme.show', $type) }}" class="text-blue-600 hover:underline">Voir</a>
                                <a href="{{ route('typealarme.edit', $type) }}" class="ml-2 text-green-600 hover:underline">Modifier</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-2">Aucun type trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> 