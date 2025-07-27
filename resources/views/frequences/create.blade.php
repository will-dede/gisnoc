<x-app-layout>
    <div class="w-full max-w-md mx-auto mt-10">
        <form method="POST" action="{{ route('frequences.store') }}" class="bg-white shadow rounded p-8">
            @csrf
            <h1 class="text-2xl font-bold mb-6 text-center">Ajouter une fréquence</h1>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            <div>
                <label for="technologie_id" class="block font-medium text-sm text-gray-700">
                    Technologie concernée <span class="text-red-500">*</span>
                </label>
                <select id="technologie_id" name="technologie_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">Sélectionner une technologie</option>
                    @foreach($technologies as $technologie)
                        <option value="{{ $technologie->id }}" {{ old('technologie_id') == $technologie->id ? 'selected' : '' }}>{{ $technologie->nom_technologie }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('technologie_id')" class="mt-2" />
            </div>
            <div class="mt-4">
                <label for="nom_freq" class="block font-medium text-sm text-gray-700">
                    Nom de la fréquence <span class="text-red-500">*</span>
                </label>
                <x-text-input id="nom_freq" name="nom_freq" type="text" class="block mt-1 w-full" :value="old('nom_freq')" required autofocus />
                <x-input-error :messages="$errors->get('nom_freq')" class="mt-2" />
            </div>
            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('frequences.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Annuler</a>
                <x-primary-button class="ms-4">Enregistrer</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout> 