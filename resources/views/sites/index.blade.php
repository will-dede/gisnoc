<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Liste des sites</h1>
                <a href="{{ route('sites.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajouter un site</a>
            </div>
            <form method="GET" action="" class="mb-4 flex gap-2">
                    {{-- A afficher plus tard... --}}
                    {{--
                    <select name="search_type" class="border rounded px-2 py-1" style="padding-right:35px">
                        <option value="all" {{ request('search_type', 'all') == 'all' ? 'selected' : '' }}>Tout rechercher</option>
                        <option value="nom_site" {{ request('search_type') == 'nom_site' ? 'selected' : '' }}>Nom du site</option>
                        <option value="cell2G" {{ request('search_type') == 'cell2G' ? 'selected' : '' }}>Cellule 2G</option>
                        <option value="cell3G" {{ request('search_type') == 'cell3G' ? 'selected' : '' }}>Cellule 3G</option>
                        <option value="cell4G" {{ request('search_type') == 'cell4G' ? 'selected' : '' }}>Cellule 4G</option>
                        <option value="nodeName" {{ request('search_type') == 'nodeName' ? 'selected' : '' }}>Node Name</option>
                        <option value="ip3G" {{ request('search_type') == 'ip3G' ? 'selected' : '' }}>IP 3G</option>
                        <option value="ip4G" {{ request('search_type') == 'ip4G' ? 'selected' : '' }}>IP 4G</option>
                    </select>
                    --}}
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Terme de recherche..." class="border rounded px-2 py-1 w-64" />
                    <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Rechercher</button>
                </form>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead>
                        <tr>
                            {{-- <th class="border px-2 py-1">ID</th> --}}
                            <th class="border px-2 py-1">Nom</th>
                            <th class="border px-2 py-1">Cellules</th>
                            <th class="border px-2 py-1">NodeName</th>
                            <th class="border px-2 py-1">IPs</th>
                            <th class="border px-2 py-1">Type</th>
                            <th class="border px-2 py-1">BSC</th>
                            <th class="border px-2 py-1">RNC</th>
                            <th class="border px-2 py-1">Zone</th>
                            <th class="border px-2 py-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sites as $site)
                            <tr>
                                {{-- <td class="border px-2 py-1 text-center">{{ $site->id }}</td> --}}
                                <td class="border px-2 py-1 uppercase font-medium">{{ $site->nom_site }}</td>
                                <td class="border px-2 py-1 text-xs uppercase">
                                    @if($site->cell2G)
                                        <div class="bg-blue-100 text-blue-800 px-1 rounded mb-1">2G: {{ $site->cell2G }}</div>
                                    @endif
                                    @if($site->cell3G)
                                        <div class="bg-green-100 text-green-800 px-1 rounded mb-1">3G: {{ $site->cell3G }}</div>
                                    @endif
                                    @if($site->cell4G)
                                        <div class="bg-purple-100 text-purple-800 px-1 rounded">4G: {{ $site->cell4G }}</div>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 text-sm">{{ $site->nodeName ?? '-' }}</td>
                                <td class="border px-2 py-1 text-xs">
                                    @if($site->ip3G)
                                        <div class="bg-orange-100 text-orange-800 px-1 rounded mb-1">3G: {{ $site->ip3G }}</div>
                                    @endif
                                    @if($site->ip4G)
                                        <div class="bg-red-100 text-red-800 px-1 rounded">4G: {{ $site->ip4G }}</div>
                                    @endif
                                </td>
                                <td class="border px-2 py-1 text-center text-sm uppercase">{{ $site->typeSite->nom_type_site ?? '-' }}</td>
                                <td class="border px-2 py-1 text-sm uppercase">{{ $site->bsc->nom_bsc ?? '-' }}</td>
                                <td class="border px-2 py-1 text-sm uppercase">{{ $site->rnc->nom_rnc ?? '-' }}</td>
                                <td class="border px-2 py-1 text-sm uppercase">{{ $site->zoneMaintenance->nom_zone ?? '-' }}</td>
                                <td class="border px-1 py-1 text-center text-xs">
                                    <a href="{{ route('sites.show', $site) }}" class="text-blue-600 hover:text-blue-800">Détails</a>
                                    <a href="{{ route('sites.edit', $site) }}" class="ml-2 text-green-600 hover:text-green-800">Modifier</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-2">Aucun site trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout> 