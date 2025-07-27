<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Détail du secteur</h1>
                        <div class="flex space-x-2">
                            <a href="{{ route('secteurs.edit', $secteur) }}" class="flex flex-col items-center text-yellow-600 hover:text-yellow-900">
                                <i class="fas fa-edit text-xl mb-1"></i>
                                <span class="text-xs">Modifier</span>
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">ID</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $secteur->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $secteur->nom_secteur }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fréquence</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $secteur->frequence->nom_freq ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Technologie</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $secteur->frequence->technologie->nom_technologie ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de création</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $secteur->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dernière modification</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $secteur->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('secteurs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded focus:outline-none focus:shadow-outline">
                    <i class="fas fa-arrow-left mr-2"></i> Retourner à la liste des secteurs
                </a>
            </div>
        </div>
    </div>
</x-app-layout> 