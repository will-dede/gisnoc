<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Liste des technologies</h1>
                @if(auth()->user()->role === 'network_lead' || auth()->user()->role === 'superadmin')
                <a href="{{ route('technologie.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Ajouter une technologie</span>
                </a>
                @endif
            </div>

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
                        <th class="border px-2 py-2">Nom de la technologie</th>
                        <th class="border px-2 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @forelse($technologies as $technologie)
                        <tr>
                            <td class="border px-2 py-1 text-center">{{ $i++ }}</td>
                            <td class="border px-2 py-1">{{ $technologie->nom_technologie }}</td>
                            <td class="border px-2 py-1 text-center">
                                <div class="flex space-x-4 justify-center font-bold">
                                    <a href="{{ route('technologie.show', $technologie) }}" class="flex flex-col items-center text-blue-600 hover:text-blue-900 mx-2">
                                        <i class="fas fa-eye text-sm"></i>
                                        <span class="text-sm">Détails</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-2">Aucune technologie trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> 