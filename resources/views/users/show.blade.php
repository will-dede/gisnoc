<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Détails de l'utilisateur</h1>
        <div class="bg-white shadow rounded p-6 w-full max-w-lg">
            <dl>
                <dt class="font-semibold">Nom</dt>
                <dd class="mb-2">{{ $user->lastname }}</dd>
                <dt class="font-semibold">Prénom</dt>
                <dd class="mb-2">{{ $user->firstname }}</dd>
                <dt class="font-semibold">Téléphone</dt>
                <dd class="mb-2">{{ $user->telephone }}</dd>
                <dt class="font-semibold">Email</dt>
                <dd class="mb-2">{{ $user->email }}</dd>
                <dt class="font-semibold">Rôle</dt>
                <dd class="mb-2">{{ $user->role }}</dd>
            </dl>
            <a href="{{ route('users.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">Retour à la liste</a>
        </div>
    </div>
</x-app-layout> 