<x-app-layout>
    <div class="container mx-auto p-4">
        <div style="display: flex; justify-content: space-between;">
            <h1 class="text-2xl font-bold mb-4">Utilisateurs</h1>
            @if(auth()->user() && auth()->user()->role === 'superadmin')
                <a href="{{ route('users.create') }}" class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajouter un utilisateur</a>
            @endif
        </div>
        <form method="GET" action="" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Recherche..." class="border rounded px-2 py-1 w-64" />
            <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Rechercher</button>
        </form>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="border px-2 py-1">Nom</th>
                    <th class="border px-2 py-1">Prénom</th>
                    <th class="border px-2 py-1">Téléphone</th>
                    <th class="border px-2 py-1">Email</th>
                    <th class="border px-2 py-1">Rôle</th>
                    <th class="border px-2 py-1">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="border px-2 py-1 uppercase">{{ $user->lastname }}</td>
                        <td class="border px-2 py-1">{{ $user->firstname }}</td>
                        <td class="border px-2 py-1">{{ $user->telephone }}</td>
                        <td class="border px-2 py-1">{{ $user->email }}</td>
                        <td class="border px-2 py-1">{{ $user->role }}</td>
                        <td class="border px-2 py-1">
                            <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:underline">Voir</a>
                            <a href="{{ route('users.edit', $user) }}" class="ml-2 text-green-600 hover:underline">Modifier</a>
                            @if(auth()->user() && auth()->user()->role === 'superadmin' && !$user->is_validated)
                                <form action="{{ route('users.validate', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="ml-2 text-green-600 hover:underline bg-transparent border-none cursor-pointer">Accepter</button>
                                </form>
                                <form action="{{ route('users.refuse', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 text-red-600 hover:underline bg-transparent border-none cursor-pointer">Refuser</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-2">Aucun utilisateur trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout> 