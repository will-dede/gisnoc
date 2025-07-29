<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Modifier l'incident</h1>
                    <a href="{{ route('incidents.show', $incident) }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('incidents.update', $incident) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Informations de base -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="site_id" class="block font-medium text-sm text-gray-700">Site principal <span class="text-red-500">*</span></label>
                            <select id="site_id" name="site_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Sélectionner un site</option>
                                @foreach($sites as $site)
                                    <option value="{{ $site->id }}" {{ old('site_id', $incident->site_id) == $site->id ? 'selected' : '' }}>
                                        {{ $site->nom_site }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('site_id')" class="mt-2" />
                        </div>

                        <div>
                            <label for="type_alarme_id" class="block font-medium text-sm text-gray-700">Type d'alarme <span class="text-red-500">*</span></label>
                            <select id="type_alarme_id" name="type_alarme_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Sélectionner un type d'alarme</option>
                                @foreach($typesAlarme as $type)
                                    <option value="{{ $type->id }}" {{ old('type_alarme_id', $incident->type_alarme_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->nom_type_alarme }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('type_alarme_id')" class="mt-2" />
                        </div>

                        <div>
                            <label for="technicien_id" class="block font-medium text-sm text-gray-700">Technicien <span class="text-red-500">*</span></label>
                            <select id="technicien_id" name="technicien_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Sélectionner un technicien</option>
                                @foreach($techniciens as $technicien)
                                    <option value="{{ $technicien->id }}" {{ old('technicien_id', $incident->technicien_id) == $technicien->id ? 'selected' : '' }}>
                                        {{ $technicien->nom_tech }} {{ $technicien->prenom_tech }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('technicien_id')" class="mt-2" />
                        </div>

                        <div>
                            <label for="intervenant" class="block font-medium text-sm text-gray-700">Intervenant</label>
                            <x-text-input id="intervenant" name="intervenant" type="text" class="block mt-1 w-full" :value="old('intervenant', $incident->intervenant)" />
                            <x-input-error :messages="$errors->get('intervenant')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date_debut_incident" class="block font-medium text-sm text-gray-700">Date début incident <span class="text-red-500">*</span></label>
                            <x-text-input id="date_debut_incident" name="date_debut_incident" type="datetime-local" class="block mt-1 w-full" :value="old('date_debut_incident', $incident->date_debut_incident ? $incident->date_debut_incident->format('Y-m-d\TH:i') : '')" required />
                            <x-input-error :messages="$errors->get('date_debut_incident')" class="mt-2" />
                        </div>

                        <div>
                            <label for="date_fin_incident" class="block font-medium text-sm text-gray-700">Date fin incident</label>
                            <x-text-input id="date_fin_incident" name="date_fin_incident" type="datetime-local" class="block mt-1 w-full" :value="old('date_fin_incident', $incident->date_fin_incident ? $incident->date_fin_incident->format('Y-m-d\TH:i') : '')" />
                            <x-input-error :messages="$errors->get('date_fin_incident')" class="mt-2" />
                        </div>

                        <div>
                            <label for="date_contact_technicien" class="block font-medium text-sm text-gray-700">Date contact technicien</label>
                            <x-text-input id="date_contact_technicien" name="date_contact_technicien" type="datetime-local" class="block mt-1 w-full" :value="old('date_contact_technicien', $incident->date_contact_technicien ? $incident->date_contact_technicien->format('Y-m-d\TH:i') : '')" />
                            <x-input-error :messages="$errors->get('date_contact_technicien')" class="mt-2" />
                        </div>

                        <div>
                            <label for="date_arrivee_sur_site" class="block font-medium text-sm text-gray-700">Date arrivée sur site</label>
                            <x-text-input id="date_arrivee_sur_site" name="date_arrivee_sur_site" type="datetime-local" class="block mt-1 w-full" :value="old('date_arrivee_sur_site', $incident->date_arrivee_sur_site ? $incident->date_arrivee_sur_site->format('Y-m-d\TH:i') : '')" />
                            <x-input-error :messages="$errors->get('date_arrivee_sur_site')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Détails -->
                    <div class="space-y-4">
                        <div>
                            <label for="causes_incident" class="block font-medium text-sm text-gray-700">Causes de l'incident</label>
                            <textarea id="causes_incident" name="causes_incident" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('causes_incident', $incident->causes_incident) }}</textarea>
                            <x-input-error :messages="$errors->get('causes_incident')" class="mt-2" />
                        </div>

                        <div>
                            <label for="actions_effectuees" class="block font-medium text-sm text-gray-700">Actions effectuées</label>
                            <textarea id="actions_effectuees" name="actions_effectuees" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('actions_effectuees', $incident->actions_effectuees) }}</textarea>
                            <x-input-error :messages="$errors->get('actions_effectuees')" class="mt-2" />
                        </div>

                        <div>
                            <label for="observation" class="block font-medium text-sm text-gray-700">Observation</label>
                            <textarea id="observation" name="observation" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('observation', $incident->observation) }}</textarea>
                            <x-input-error :messages="$errors->get('observation')" class="mt-2" />
                        </div>

                        <div>
                            <label for="notes" class="block font-medium text-sm text-gray-700">Notes</label>
                            <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('notes', $incident->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('incidents.show', $incident) }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Annuler</a>
                        <x-primary-button class="ms-4">Mettre à jour</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 