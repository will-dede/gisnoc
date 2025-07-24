<x-app-layout>
    <div class="w-full max-w-md mx-auto mt-10">
        <form method="POST" action="{{ route('techniciens.store') }}" class="bg-white shadow rounded p-8">
            @csrf
            <h1 class="text-2xl font-bold mb-6 text-center">Ajouter un technicien</h1>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            <div>
                <label for="nom_technicien" class="block font-medium text-sm text-gray-700">
                    Nom <span class="text-red-500">*</span>
                </label>
                <x-text-input id="nom_technicien" name="nom_technicien" type="text" class="block mt-1 w-full" :value="old('nom_technicien')" required autofocus />
                <x-input-error :messages="$errors->get('nom_technicien')" class="mt-2" />
            </div>
            <div class="mt-4">
                <label for="prenom_technicien" class="block font-medium text-sm text-gray-700">
                    Prénom <span class="text-red-500">*</span>
                </label>
                <x-text-input id="prenom_technicien" name="prenom_technicien" type="text" class="block mt-1 w-full" :value="old('prenom_technicien')" required />
                <x-input-error :messages="$errors->get('prenom_technicien')" class="mt-2" />
            </div>
            <div class="mt-4">
                <label for="tel_technicien" class="block font-medium text-sm text-gray-700">
                    Téléphone <span class="text-red-500">*</span>
                </label>
                <x-text-input id="tel_technicien" name="tel_technicien" type="text" class="block mt-1 w-full" :value="old('tel_technicien')" required />
                <x-input-error :messages="$errors->get('tel_technicien')" class="mt-2" />
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
                <label for="zone_maintenance_id" class="block font-medium text-sm text-gray-700">
                    Zone de maintenance <span class="text-red-500">*</span>
                </label>
                <select id="zone_maintenance_id" name="zone_maintenance_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">Sélectionner une zone</option>
                    @foreach($zones as $zone)
                        <option value="{{ $zone->id }}" {{ old('zone_maintenance_id') == $zone->id ? 'selected' : '' }}>{{ $zone->nom_zone }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('zone_maintenance_id')" class="mt-2" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('techniciens.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Annuler</a>
                <x-primary-button class="ms-4">Enregistrer</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout> 