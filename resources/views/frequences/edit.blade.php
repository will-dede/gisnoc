<x-app-layout>
    @if(auth()->check() && (auth()->user()->role === 'network_lead' || auth()->user()->role === 'superadmin'))
    <div class="w-full max-w-md mx-auto mt-10">
        <form method="POST" action="{{ route('frequences.update', $frequence) }}" class="bg-white shadow rounded p-8">
            @csrf
            @method('PUT')
            <h1 class="text-2xl font-bold mb-6 text-center">Modifier la fréquence</h1>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            <div>
                <label for="nom_freq" class="block font-medium text-sm text-gray-700">
                    Nom de la fréquence <span class="text-red-500">*</span>
                </label>
                <x-text-input id="nom_freq" name="nom_freq" type="text" class="block mt-1 w-full" :value="old('nom_freq', $frequence->nom_freq)" required autofocus />
                <x-input-error :messages="$errors->get('nom_freq')" class="mt-2" />
            </div>
            <div class="mt-4">
                <label for="technologie_id" class="block font-medium text-sm text-gray-700">
                    Technologie <span class="text-red-500">*</span>
                </label>
                <select id="technologie_id" name="technologie_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">Sélectionner une technologie</option>
                    @foreach($technologies as $technologie)
                        <option value="{{ $technologie->id }}" {{ old('technologie_id', $frequence->technologie_id) == $technologie->id ? 'selected' : '' }}>{{ $technologie->nom_technologie }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('technologie_id')" class="mt-2" />
            </div>
            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('frequences.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Annuler</a>
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
            </p>
            <a href="{{ route('incidents.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full mb-2">Retourner à la liste des incidents</a>
        </div>
    </div>
    @endif
</x-app-layout> 