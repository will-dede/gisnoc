<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Détails de l'incident</h1>
                        <div class="flex space-x-2">
                            <a href="{{ route('incidents.edit', $incident) }}" class="flex flex-col items-center text-yellow-600 hover:text-yellow-900">
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
                                <p class="mt-1 text-sm text-gray-900">{{ $incident->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Site principal</label>
                                <p class="mt-1 text-sm text-gray-900 font-medium">{{ $incident->site->nom_site ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type d'alarme</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">
                                        {{ $incident->typeAlarme->nom_type_alarme ?? '-' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Technicien</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $incident->technicien->nom_tech ?? '-' }} {{ $incident->technicien->prenom_tech ?? '' }}
                                </p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de création</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $incident->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dernière modification</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $incident->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Dates importantes</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 p-3 rounded">
                                <label class="block text-sm font-medium text-blue-700">Début incident</label>
                                <p class="mt-1 text-sm text-blue-900">
                                    {{ $incident->date_debut_incident ? $incident->date_debut_incident->format('d/m/Y H:i') : '-' }}
                                </p>
                            </div>
                            <div class="bg-green-50 p-3 rounded">
                                <label class="block text-sm font-medium text-green-700">Fin incident</label>
                                <p class="mt-1 text-sm text-green-900">
                                    {{ $incident->date_fin_incident ? $incident->date_fin_incident->format('d/m/Y H:i') : '-' }}
                                </p>
                            </div>
                            <div class="bg-orange-50 p-3 rounded">
                                <label class="block text-sm font-medium text-orange-700">Contact technicien</label>
                                <p class="mt-1 text-sm text-orange-900">
                                    {{ $incident->date_contact_technicien ? $incident->date_contact_technicien->format('d/m/Y H:i') : '-' }}
                                </p>
                            </div>
                            <div class="bg-purple-50 p-3 rounded">
                                <label class="block text-sm font-medium text-purple-700">Arrivée sur site</label>
                                <p class="mt-1 text-sm text-purple-900">
                                    {{ $incident->date_arrivee_sur_site ? $incident->date_arrivee_sur_site->format('d/m/Y H:i') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Détails -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Détails de l'incident</h3>
                        <div class="space-y-4">
                            @if($incident->intervenant)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Intervenant</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $incident->intervenant }}</p>
                                </div>
                            @endif
                            @if($incident->causes_incident)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Causes de l'incident</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $incident->causes_incident }}</p>
                                </div>
                            @endif
                            @if($incident->actions_effectuees)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Actions effectuées</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $incident->actions_effectuees }}</p>
                                </div>
                            @endif
                            @if($incident->observation)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Observation</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $incident->observation }}</p>
                                </div>
                            @endif
                            @if($incident->notes)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $incident->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Sites impactés -->
                    @if($incident->sites->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Sites impactés ({{ $incident->sites->count() }})</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Site</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Début</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fin</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intervenant</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($incident->sites as $site)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $site->nom_site }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $site->pivot->date_debut_incident ? \Carbon\Carbon::parse($site->pivot->date_debut_incident)->format('d/m/Y H:i') : '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $site->pivot->date_fin_incident ? \Carbon\Carbon::parse($site->pivot->date_fin_incident)->format('d/m/Y H:i') : '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $site->pivot->intervenant ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Secteurs -->
                    @if($incident->secteurs->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Secteurs concernés ({{ $incident->secteurs->count() }})</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($incident->secteurs as $secteur)
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">{{ $secteur->nom_secteur }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('incidents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded focus:outline-none focus:shadow-outline">
                    <i class="fas fa-arrow-left mr-2"></i> Retourner à la liste des incidents
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
                        Êtes-vous sûr de vouloir supprimer cet incident ?
                    </p>
                </div>
                <div class="flex justify-center mt-4 space-x-4">
                    <button onclick="document.getElementById('deleteModal').classList.add('hidden')" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Annuler</button>
                    <form action="{{ route('incidents.destroy', $incident) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 