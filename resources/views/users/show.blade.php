<x-app-layout>
    @if(auth()->check() && auth()->user()->role === 'superadmin')
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