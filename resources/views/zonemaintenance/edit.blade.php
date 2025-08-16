<x-app-layout>
    @if(auth()->check() && auth()->user()->role === 'superadmin')
    <div class="w-full max-w-md mx-auto mt-10">
        <form method="POST" action="{{ route('zonemaintenance.update', $zonemaintenance) }}" class="bg-white shadow rounded p-8">
            @csrf
            @method('PUT')
            <h1 class="text-2xl font-bold mb-6 text-center">Modifier la zone de maintenance</h1>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            <div>
                <label for="nom_zone" class="block font-medium text-sm text-gray-700">Nom de la zone <span class="text-red-500">*</span></label>
                <x-text-input id="nom_zone" name="nom_zone" type="text" class="block mt-1 w-full" :value="old('nom_zone', $zonemaintenance->nom_zone)" required autofocus />
                <x-input-error :messages="$errors->get('nom_zone')" class="mt-2" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('zonemaintenance.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Annuler</a>
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