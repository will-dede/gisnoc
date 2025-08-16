<x-app-layout>
    @if(auth()->check() && (auth()->user()->role === 'network_lead' || auth()->user()->role === 'superadmin'))
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md">
            <h1 class="text-2xl font-bold mb-4 text-center">Ajouter un utilisateur</h1>
            <form method="POST" action="{{ route('users.store') }}" class="bg-white shadow rounded p-6">
                @csrf
                <div class="mb-4">
                    <label for="lastname" class="block font-semibold">Nom <span class="text-red-500">*</span></label>
                    <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}" class="border rounded px-2 py-1 w-full" required />
                </div>
                <div class="mb-4">
                    <label for="firstname" class="block font-semibold">Prénom <span class="text-red-500">*</span></label>
                    <input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}" class="border rounded px-2 py-1 w-full" required />
                </div>
                <div class="mb-4">
                    <label for="telephone" class="block font-semibold">Téléphone</label>
                    <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}" class="border rounded px-2 py-1 w-full" />
                </div>
                <div class="mb-4">
                    <label for="email" class="block font-semibold">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="border rounded px-2 py-1 w-full" required />
                </div>
                <div class="mb-4">
                    <label for="role" class="block font-semibold">Rôle <span class="text-red-500">*</span></label>
                    <select name="role" id="role" class="border rounded px-2 py-1 w-full" required>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Operations Observer</option>
                        <option value="noc_engineer" {{ old('role') == 'noc_engineer' ? 'selected' : '' }}>NOC Engineer</option>
                        <option value="network_lead" {{ old('role') == 'network_lead' ? 'selected' : '' }}>Network Lead</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="password" class="block font-semibold">Mot de passe (optionnel)</label>
                    <input type="text" name="password" id="password" class="border rounded px-2 py-1 w-full" placeholder="Laisser vide pour 'password' par défaut" />
                </div>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded w-full">Créer</button>
                <a href="{{ route('users.index') }}" class="mt-4 inline-block text-blue-600 hover:underline w-full text-center">Annuler</a>
            </form>
        </div>
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