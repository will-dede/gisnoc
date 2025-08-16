<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Détails de la technologie</h1>
                        @if(auth()->user()->role === 'network_lead' || auth()->user()->role === 'superadmin')
                        <div class="flex space-x-2">
                            <a href="{{ route('technologie.edit', $technologie) }}" class="flex flex-col items-center text-yellow-600 hover:text-yellow-900">
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
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">ID</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $technologie->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $technologie->nom_technologie }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de création</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $technologie->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dernière modification</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $technologie->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de confirmation de suppression -->
            <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded shadow-md">
                    <h2 class="text-lg font-semibold mb-4">Confirmer la suppression</h2>
                    <p>Êtes-vous sûr de vouloir supprimer cette technologie ?</p>
                    <div class="mt-6 flex justify-end space-x-4">
                        <button onclick="document.getElementById('deleteModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Annuler</button>
                        <form method="POST" action="{{ route('technologie.destroy', $technologie) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 