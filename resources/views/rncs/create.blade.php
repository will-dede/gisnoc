<x-app-layout>
    <div class="w-full max-w-md mx-auto mt-10">
        <form method="POST" action="{{ route('rncs.store') }}" class="bg-white shadow rounded p-8">
            @csrf
            <h1 class="text-2xl font-bold mb-6 text-center">Ajouter un RNC</h1>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            <div>
                <label for="nom_rnc" class="block font-medium text-sm text-gray-700">Nom du RNC <span class="text-red-500">*</span></label>
                <x-text-input id="nom_rnc" name="nom_rnc" type="text" class="block mt-1 w-full" :value="old('nom_rnc')" required autofocus />
                <x-input-error :messages="$errors->get('nom_rnc')" class="mt-2" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('rncs.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Annuler</a>
                <x-primary-button class="ms-4">Enregistrer</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout> 