<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Liste des BSC</h1>
                <a href="{{ route('bscs.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajouter un BSC</a>
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
                        <th class="border px-2 py-1">Nom du BSC</th>
                        <th class="border px-2 py-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bscs as $bsc)
                        <tr>
                            <td class="border px-2 py-1">{{ $bsc->nom_bsc }}</td>
                            <td class="border px-2 py-1">
                                <a href="{{ route('bscs.show', $bsc) }}" class="text-blue-600 hover:underline">Voir</a>
                                <a href="{{ route('bscs.edit', $bsc) }}" class="ml-2 text-green-600 hover:underline">Modifier</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-2">Aucun BSC trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> 