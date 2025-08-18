<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex">
                            <a href="{{ route('frequences.index') }}" class="inline-flex text-center items-center px-1 py-1 hover:bg-blue-50 rounded focus:outline-none focus:shadow-outline">
                                <i class="fas fa-arrow-left mr-2"></i> &nbsp;
                            </a>
                            <h1 class="text-2xl font-semibold text-gray-800">Détails de la fréquence</h1>
                        </div>
                        @if(auth()->check() && (auth()->user()->role === 'network_lead' || auth()->user()->role === 'superadmin'))
                        <div class="flex space-x-2">
                            <a href="{{ route('frequences.edit', $frequence) }}" class="flex flex-col items-center text-yellow-600 hover:text-yellow-900">
                                <i class="fas fa-edit text-xl mb-1"></i>
                                <span class="text-xs">Modifier</span>
                            </a>
                            <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" class="flex flex-col items-center text-red-600 hover:text-red-900">
                                <i class="fas fa-trash text-xl mb-1"></i>
                                <span class="text-xs">Supprimer</span>
                            </button>
                        </div>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            {{--
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">ID</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $frequence->id }}</p>
                                </div>
                            --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $frequence->nom_freq }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Technologie</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $frequence->technologie->nom_technologie ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de création</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $frequence->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dernière modification</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $frequence->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
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
                        Êtes-vous sûr de vouloir supprimer la fréquence "{{ $frequence->nom_freq }}" ?
                    </p>
                </div>
                <div class="flex justify-center mt-4 space-x-4">
                    <button onclick="document.getElementById('deleteModal').classList.add('hidden')" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Annuler</button>
                    <form action="{{ route('frequences.destroy', $frequence) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 