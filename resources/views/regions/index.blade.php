<x-app-layout>
    @if(auth()->check() && (auth()->user()->role === 'noc_engineer' || auth()->user()->role === 'network_lead' || auth()->user()->role === 'superadmin'))
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Liste des régions</h1>
                @if(auth()->user()->role === 'network_lead' || auth()->user()->role === 'superadmin')
                <a href="{{ route('regions.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Ajouter une région</span>
                </a>
                @endif
            </div>
            {{-- Barre de recherche --}}
            {{--
                <form method="GET" action="" class="mb-4 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher une région..." class="border rounded px-2 py-1 w-64" />
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
                <thead class="bg-gray-50">
                    <tr>
                        <th class="border px-2 py-2">N°</th>
                        <th class="border px-2 py-2">Nom de la région</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp 
                    @forelse($regions as $region)
                        <tr>
                            <td class="border px-2 py-1 text-center">{{ $i++ }}</td>
                            <td class="border px-2 py-1 flex items-center justify-between">
                                <span>
                                    {{ $region->nom_region }} <span class="text-gray-500 text-sm">({{ $region->sites->count() }} sites affectés)</span>
                                </span>
                                <div class="text-center">
                                    <a href="{{ route('regions.show', $region) }}" class="flex flex-col text-blue-600 hover:text-blue-900 mx-2">
                                        <i class="fas fa-eye text-sm"></i>
                                        <span class="text-sm font-bold">Détails</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-2">Aucune région trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="flex items-center justify-center min-h-screen">
        <div class="max-w-md w-full bg-white p-8 rounded shadow text-center">
            <h1 class="text-2xl font-bold mb-6" style="color:red"><i class="fa-solid fa-triangle-exclamation"></i> Accès non autorisé !</h1>
            <p class="mb-6">
                Vous tentez d'accéder à une page non autorisée.<br>
                Pour y avoir accès, merci de contacter un administrateur.
            </p>
            <a href="{{ route('incidents.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full mb-2">Retourner à la liste des incidents</a>
        </div>
    </div>
    @endif
</x-app-layout> 