<x-app-layout>
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
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Utilisateur</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                        <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Administrateur</option>
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
</x-app-layout> 