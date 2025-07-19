<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen">
        <div class="max-w-md w-full bg-white p-8 rounded shadow text-center">
            <h1 class="text-2xl font-bold mb-4">Inscription en attente de validation</h1>
            <p class="mb-6">
                Vos informations ont bien été enregistrées. Un administrateur va examiner votre demande et valider votre compte si tout est conforme.<br>
                Vous pourrez vous connecter une fois votre compte validé.
            </p>
            <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full mb-2">Accéder à la page de connexion</a>
            <a href="/" class="inline-block bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 w-full">Retour à l'accueil</a>
        </div>
    </div>
</x-guest-layout> 