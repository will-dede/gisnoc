<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Détails de la région -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Détails de la région</h1>
                        <div class="flex space-x-2">
                            <a href="{{ route('regions.edit', $region) }}" class="flex flex-col items-center text-yellow-600 hover:text-yellow-900">
                                <i class="fas fa-edit text-xl mb-1"></i>
                                <span class="text-xs">Modifier</span>
                            </a>
                            <button type="button" 
                                    onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                                    class="flex flex-col items-center text-red-600 hover:text-red-900">
                                <i class="fas fa-trash text-xl mb-1"></i>
                                <span class="text-xs">Supprimer</span>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Informations principales -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">ID</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $region->id }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom de la région</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $region->nom_region }}</p>
                            </div>
                        </div>

                        <!-- Informations de date -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de création</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $region->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dernière modification</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $region->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des sites -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Sites dans cette région</h2>
                        <a href="{{ route('sites.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            <i class="fas fa-plus mr-2"></i> Ajouter un site
                        </a>
                    </div>

                    @if($region->sites && $region->sites->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border">
                                <thead>
                                    <tr>
                                        <th class="border px-2 py-1">N°</th>
                                        <th class="border px-2 py-1">Nom du site</th>
                                        <th class="border px-2 py-1">Cellules</th>
                                        <th class="border px-2 py-1">NodeName</th>
                                        <th class="border px-2 py-1">Node<br>Type</th>
                                        <th class="border px-2 py-1">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($region->sites as $site)
                                        <tr>
                                            <td class="border px-2 py-1 text-center text-base text-gray-500">{{ $i++ }}</td>
                                            <td class="border px-2 py-1 text-base text-gray-900">
                                                <a href="{{ route('sites.show', $site) }}" class="text-gray-700 hover:text-blue-900">
                                                    {{ $site->nom_site }}
                                                </a>
                                            </td>
                                            <td class="border px-2 py-1 text-sm text-gray-900">
                                                @if($site->cell2G)
                                                    <div class="text-sm">2G: {{ $site->cell2G }}</div>
                                                @endif
                                                @if($site->cell3G)
                                                    <div class="text-sm">3G: {{ $site->cell3G }}</div>
                                                @endif
                                                @if($site->cell4G)
                                                    <div class="text-sm">4G: {{ $site->cell4G }}</div>
                                                @endif
                                            </td>
                                            <td class="border px-2 py-1 text-sm text-gray-900">{{ $site->nodeName ?? '' }}</td>
                                            <td class="border px-2 py-1 text-center text-sm text-gray-900">{{ $site->typeSite->nom_type_site ?? '' }}</td>
                                            <td class="border px-2 py-1 text-center">
                                                <div class="flex space-x-4 justify-center font-bold">
                                                    <a href="{{ route('sites.show', $site) }}" class="flex flex-col items-center text-blue-600 hover:text-blue-900 mx-2">
                                                        <i class="fas fa-eye text-sm"></i>
                                                        <span class="text-sm">Détails</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-gray-500">
                            Aucun site trouvé dans cette région
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('regions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded focus:outline-none focus:shadow-outline">
                    <i class="fas fa-arrow-left mr-2"></i> Retourner à la liste des régions
                </a>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmation de Suppression -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Confirmation de suppression</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Êtes-vous sûr de vouloir supprimer la région "{{ $region->nom_region }}" ?
                        @if($region->sites && $region->sites->count() > 0)
                            <div class="mt-2 text-red-600">
                                Attention : Cette région contient {{ $region->sites->count() }} site(s). La suppression de la région supprimera également tous les sites associés.
                            </div>
                        @endif
                    </p>
                </div>
                <div class="flex justify-center mt-4 space-x-4">
                    <button onclick="document.getElementById('deleteModal').classList.add('hidden')" 
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Annuler
                    </button>
                    <form action="{{ route('regions.destroy', $region) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                            Confirmer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 