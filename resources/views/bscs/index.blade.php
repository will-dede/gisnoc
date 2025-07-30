<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Liste des BSC</h1>
                <a href="{{ route('bscs.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Ajouter un BSC</span>
                </a>
            </div>
            {{-- Barre de recherche --}}
            {{--
                <form method="GET" action="" class="mb-4 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Recherche nom BSC..." class="border rounded px-2 py-1 w-64" />
                    <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Rechercher</button>
                </form>
            --}}
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
                        <th class="border px-2 py-1">Nom BSC</th>
                        <th class="border px-2 py-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp 
                    @forelse($bscs as $bsc)
                        <tr>
                            <td class="border px-2 py-1 text-center">{{ $i++ }}</td>
                            <td class="border px-2 py-1">{{ $bsc->nom_bsc }}</td>
                            <td class="border px-2 py-1 text-center">
                                <div class="flex space-x-4 justify-center font-bold">
                                    <a href="{{ route('bscs.show', $bsc) }}" class="flex flex-col items-center text-blue-600 hover:text-blue-900 mx-2">
                                        <i class="fas fa-eye text-sm"></i>
                                        <span class="text-sm">Détails</span>
                                    </a>
                                    <a href="{{ route('bscs.edit', $bsc) }}" class="flex flex-col items-center text-yellow-600 hover:text-yellow-900 mx-2">
                                        <i class="fas fa-edit text-sm"></i>
                                        <span class="text-sm">Modifier</span>
                                    </a>
                                    <form action="{{ route('bscs.destroy', $bsc) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex flex-col items-center text-red-600 hover:text-red-900 mx-2" onclick="return confirm('Supprimer ce BSC ?')">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                            <span class="text-sm">Supprimer</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-2">Aucun BSC trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> 