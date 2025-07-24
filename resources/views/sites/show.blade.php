<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Détail du site</h1>
                        <div class="flex space-x-2">
                            <a href="{{ route('sites.edit', $site) }}" class="flex flex-col items-center text-yellow-600 hover:text-yellow-900">
                                <i class="fas fa-edit text-xl mb-1"></i>
                                <span class="text-xs">Modifier</span>
                            </a>
                            <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" class="flex flex-col items-center text-red-600 hover:text-red-900">
                                <i class="fas fa-trash text-xl mb-1"></i>
                                <span class="text-xs">Supprimer</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Informations de base -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">ID</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $site->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom du site</label>
                                <p class="mt-1 text-sm text-gray-900 font-medium">{{ $site->nom_site }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Node Name</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $site->nodeName ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de création</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $site->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dernière modification</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $site->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Cellules -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Cellules</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-blue-50 p-3 rounded">
                                <label class="block text-sm font-medium text-blue-700">2G</label>
                                <p class="mt-1 text-sm text-blue-900">{{ $site->cell2G ?? '-' }}</p>
                            </div>
                            <div class="bg-green-50 p-3 rounded">
                                <label class="block text-sm font-medium text-green-700">3G</label>
                                <p class="mt-1 text-sm text-green-900">{{ $site->cell3G ?? '-' }}</p>
                            </div>
                            <div class="bg-purple-50 p-3 rounded">
                                <label class="block text-sm font-medium text-purple-700">4G</label>
                                <p class="mt-1 text-sm text-purple-900">{{ $site->cell4G ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- IPs -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Adresses IP</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-orange-50 p-3 rounded">
                                <label class="block text-sm font-medium text-orange-700">IP 3G</label>
                                <p class="mt-1 text-sm text-orange-900">{{ $site->ip3G ?? '-' }}</p>
                            </div>
                            <div class="bg-red-50 p-3 rounded">
                                <label class="block text-sm font-medium text-red-700">IP 4G</label>
                                <p class="mt-1 text-sm text-red-900">{{ $site->ip4G ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Relations -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Informations de réseau</h3>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Région</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $site->region->nom_region ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NodeType</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $site->typeSite->nom_type_site ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Zone de maintenance</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $site->zoneMaintenance->nom_zone ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">BSC</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $site->bsc->nom_bsc ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">RNC</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $site->rnc->nom_rnc ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Technologies -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-medium text-gray-900">Technologies installées</h3>
                            <a href="{{ route('sitetechnologie.create', $site) }}" class="text-blue-600 hover:text-blue-900 flex items-center">
                                <i class="fas fa-plus mr-1"></i> Ajouter
                            </a>
                        </div>
                        @if(session('success'))
                            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
                        @endif
                        @if($site->technologies->count() > 0)
                            <div class="overflow-x-auto custom-scrollbar">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technologie</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($site->technologies as $technologie)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $technologie->nom_technologie }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <form action="{{ route('site-technologies.destroy', [$site, $technologie]) }}" method="POST" onsubmit="return confirm('Détacher cette technologie ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Détacher">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">Aucune technologie associée à ce site.</p>
                        @endif
                    </div>

                    <!-- Incidents -->
                    @if($site->incidents->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Incidents associés ({{ $site->incidents->count() }})</h3>
                            <div class="bg-gray-50 p-3 rounded">
                                <p class="text-sm text-gray-600">Ce site a {{ $site->incidents->count() }} incident(s) associé(s).</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('sites.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded focus:outline-none focus:shadow-outline">
                    <i class="fas fa-arrow-left mr-2"></i> Retourner à la liste des sites
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
                        Êtes-vous sûr de vouloir supprimer le site "{{ $site->nom_site }}" ?
                    </p>
                    @if($site->incidents->count() > 0)
                        <p class="text-sm text-red-500 mt-2">
                            ⚠️ Attention : Ce site a {{ $site->incidents->count() }} incident(s) associé(s).
                        </p>
                    @endif
                </div>
                <div class="flex justify-center mt-4 space-x-4">
                    <button onclick="document.getElementById('deleteModal').classList.add('hidden')" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Annuler</button>
                    <form action="{{ route('sites.destroy', $site) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 