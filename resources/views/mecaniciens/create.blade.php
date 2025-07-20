<x-app-layout>
    <div class="w-full max-w-md mx-auto mt-10">
        <form method="POST" action="{{ route('mecaniciens.store') }}" class="bg-white shadow rounded p-8">
            @csrf
            <h1 class="text-2xl font-bold mb-6 text-center">Ajouter un mécanicien</h1>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            <div>
                <x-input-label for="nom_mecano" :value="'Nom'" />
                <x-text-input id="nom_mecano" name="nom_mecano" type="text" class="block mt-1 w-full" :value="old('nom_mecano')" required autofocus />
                <x-input-error :messages="$errors->get('nom_mecano')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="prenom_mecano" :value="'Prénom'" />
                <x-text-input id="prenom_mecano" name="prenom_mecano" type="text" class="block mt-1 w-full" :value="old('prenom_mecano')" required />
                <x-input-error :messages="$errors->get('prenom_mecano')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="tel_mecano" :value="'Téléphone'" />
                <x-text-input id="tel_mecano" name="tel_mecano" type="text" class="block mt-1 w-full" :value="old('tel_mecano')" required />
                <x-input-error :messages="$errors->get('tel_mecano')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="est_proprietaire" :value="'Responsable de la zone ?'" />
                <select id="est_proprietaire" name="est_proprietaire" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="0" {{ old('est_proprietaire') == '0' ? 'selected' : '' }}>Non</option>
                    <option value="1" {{ old('est_proprietaire') == '1' ? 'selected' : '' }}>Oui</option>
                </select>
                <x-input-error :messages="$errors->get('est_proprietaire')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="zone_maintenance_id" :value="'Zone de maintenance'" />
                <select id="zone_maintenance_id" name="zone_maintenance_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">Sélectionner une zone</option>
                    @foreach($zones as $zone)
                        <option value="{{ $zone->id }}" {{ old('zone_maintenance_id') == $zone->id ? 'selected' : '' }}>{{ $zone->nom_zone }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('zone_maintenance_id')" class="mt-2" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('mecaniciens.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Annuler</a>
                <x-primary-button class="ms-4">Enregistrer</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout> 