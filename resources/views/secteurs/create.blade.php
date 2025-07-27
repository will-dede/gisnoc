<x-app-layout>
    <div class="w-full max-w-md mx-auto mt-10">
        <form method="POST" action="{{ route('secteurs.store') }}" class="bg-white shadow rounded p-8">
            @csrf
            <h1 class="text-2xl font-bold mb-6 text-center">Ajouter un secteur</h1>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            <div>
                <label for="frequence_id" class="block font-medium text-sm text-gray-700">
                    Fréquence <span class="text-red-500">*</span>
                </label>
                <select id="frequence_id" name="frequence_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">Sélectionner une fréquence</option>
                    @foreach($frequences as $frequence)
                        <option value="{{ $frequence->id }}" {{ old('frequence_id') == $frequence->id ? 'selected' : '' }}>
                            {{ ($frequence->technologie->nom_technologie ?? '-') . ' - ' . $frequence->nom_freq }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('frequence_id')" class="mt-2" />
            </div>
            <div class="mt-4">
                <label for="nom_secteur" class="block font-medium text-sm text-gray-700">
                    Nom du secteur <span class="text-red-500">*</span>
                </label>
                <x-text-input id="nom_secteur" name="nom_secteur" type="text" class="block mt-1 w-full" :value="old('nom_secteur')" required autofocus />
                <x-input-error :messages="$errors->get('nom_secteur')" class="mt-2" />
            </div>
            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('secteurs.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Annuler</a>
                <x-primary-button class="ms-4">Enregistrer</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout> 