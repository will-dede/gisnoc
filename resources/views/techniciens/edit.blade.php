<x-app-layout>
    @if(auth()->check() && (auth()->user()->role === 'noc_engineer' || auth()->user()->role === 'network_lead' || auth()->user()->role === 'superadmin'))
    <div class="w-full max-w-md mx-auto mt-10">
        <form method="POST" action="{{ route('techniciens.update', $technicien) }}" class="bg-white shadow rounded p-8">
            @csrf
            @method('PUT')
            <h1 class="text-2xl font-bold mb-6 text-center">Modifier le technicien</h1>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            <div>
                <label for="nom_tech" class="block font-medium text-sm text-gray-700">
                    Nom <span class="text-red-500">*</span>
                </label>
                <x-text-input id="nom_tech" name="nom_tech" type="text" class="block mt-1 w-full" :value="old('nom_tech', $technicien->nom_tech)" required autofocus />
                <x-input-error :messages="$errors->get('nom_tech')" class="mt-2" />
            </div>
            <div class="mt-4">
                <label for="prenom_tech" class="block font-medium text-sm text-gray-700">
                    Prénom <span class="text-red-500">*</span>
                </label>
                <x-text-input id="prenom_tech" name="prenom_tech" type="text" class="block mt-1 w-full" :value="old('prenom_tech', $technicien->prenom_tech)" required />
                <x-input-error :messages="$errors->get('prenom_tech')" class="mt-2" />
            </div>
            <div class="mt-4">
                <label for="tel_tech" class="block font-medium text-sm text-gray-700">
                    Téléphone <span class="text-red-500">*</span>
                </label>
                <x-text-input id="tel_tech" name="tel_tech" type="text" class="block mt-1 w-full" :value="old('tel_tech', $technicien->tel_tech)" required />
                <x-input-error :messages="$errors->get('tel_tech')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="est_proprietaire" :value="'Responsable de la zone ?'" />
                <select id="est_proprietaire" name="est_proprietaire" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="0" {{ old('est_proprietaire', $technicien->est_proprietaire) == '0' ? 'selected' : '' }}>Non</option>
                    <option value="1" {{ old('est_proprietaire', $technicien->est_proprietaire) == '1' ? 'selected' : '' }}>Oui</option>
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
                        <option value="{{ $zone->id }}" {{ old('zone_maintenance_id', $technicien->zone_maintenance_id) == $zone->id ? 'selected' : '' }}>{{ $zone->nom_zone }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('zone_maintenance_id')" class="mt-2" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('techniciens.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Annuler</a>
                <x-primary-button class="ms-4">Mettre à jour</x-primary-button>
            </div>
        </form>
    </div>
    @else
    <div class="flex items-center justify-center min-h-screen">
        <div class="max-w-md w-full bg-white p-8 rounded shadow text-center">
            <h1 class="text-2xl font-bold mb-6" style="color:red"><i class="fa-solid fa-triangle-exclamation"></i> Accès non autorisé !</h1>
            <p class="mb-6">
                Vous tentez d'accéder à une page non autorisée.<br>
                Pour y avoir accès, merci de contacter un administrateur.
            </p>
            <a href="{{ route('incidents.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full mb-2">Retourner à la liste des incidents</a>
        </div>
    </div>
    @endif
</x-app-layout> 