<x-app-layout>
    <div class="w-full max-w-md mx-auto mt-10">
        <form method="POST" action="{{ route('sites.technologies.store', $site) }}" class="bg-white shadow rounded p-8">
            @csrf
            <h1 class="text-2xl font-bold mb-6 text-center">Associer une technologie au site</h1>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            <div class="mb-4">
                <label for="technologie_id" class="block font-medium text-sm text-gray-700">Technologie <span class="text-red-500">*</span></label>
                <select id="technologie_id" name="technologie_id" class="block mt-1 w-full border rounded px-2 py-1" required>
                    <option value="">-- Sélectionner une technologie --</option>
                    @foreach($technologies as $technologie)
                        <option value="{{ $technologie->id }}">{{ $technologie->nom_technologie }}</option>
                    @endforeach
                </select>
                @error('technologie_id')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('sites.show', $site) }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Annuler</a>
                <x-primary-button class="ms-4">Enregistrer</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout> 