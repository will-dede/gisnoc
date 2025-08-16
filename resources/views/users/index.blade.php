<x-app-layout>
    @if(auth()->check() && (auth()->user()->role === 'network_lead' || auth()->user()->role === 'superadmin'))
    <div class="container mx-auto p-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Liste des utilisateurs</h1>
                @if(auth()->user()->role === 'network_lead' || auth()->user()->role === 'superadmin')
                    <a href="{{ route('users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center gap-2">
                        <i class="fas fa-plus"></i>
                        <span>Ajouter un utilisateur</span>
                    </a>
                @endif
            </div>

            {{-- Barre de recherche --}}
            <form method="GET" action="{{ route('users.index') }}" class="mb-4 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un utilisateur..." class="border rounded px-2 py-1 w-64" />
                <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Rechercher</button>
            </form>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif

            <table class="min-w-full bg-white border">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="border px-2 py-1">N°</th>
                        <th class="border px-2 py-1">Nom</th>
                        <th class="border px-2 py-1">Prénom</th>
                        <th class="border px-2 py-1">Téléphone</th>
                        <th class="border px-2 py-1">Email</th>
                        <th class="border px-2 py-1">Rôle</th>
                        <th class="border px-2 py-1">Statut</th>
                        <th class="border px-2 py-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                        @endphp
                    @forelse($users as $user)
                        <tr>
                            <td class="border px-2 py-1 text-center">{{ $i++ }}</td>
                            <td class="border px-2 py-1">{{ $user->lastname }}</td>
                            <td class="border px-2 py-1">{{ $user->firstname }}</td>
                            <td class="border px-2 py-1">{{ $user->telephone }}</td>
                            <td class="border px-2 py-1">{{ $user->email }}</td>
                            <td class="border px-2 py-1">
                                @if($user->role === 'user')
                                    <span class="text-sm">Network observer</span>
                                @elseif($user->role === 'noc_engineer')
                                    <span class="text-sm">NOC Engineer</span>
                                @elseif($user->role === 'network_lead')
                                    <span class="text-sm">Network Lead</span>
                                @elseif($user->role === 'superadmin')
                                    <span class="text-sm">Super admin</span>
                                @endif
                            </td>
                            <td class="border px-2 py-1">
                                @if($user->is_validated)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Validé</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">En attente</span>
                                @endif
                            </td>
                            <td class="border px-2 py-1 text-center">
                                <div class="flex space-x-4 justify-center font-bold">
                                    <a href="{{ route('users.show', $user) }}" class="flex flex-col items-center text-blue-600 hover:text-blue-900 mx-2">
                                        <i class="fas fa-eye text-sm"></i>
                                        <span class="text-sm">Voir</span>
                                    </a>
                                    @if(auth()->user()->role === 'network_lead' || auth()->user()->role === 'superadmin')
                                    <a href="{{ route('users.edit', $user) }}" class="flex flex-col items-center text-yellow-600 hover:text-yellow-900 mx-2">
                                        <i class="fas fa-edit text-sm"></i>
                                        <span class="text-sm">Modifier</span>
                                    </a>
                                    @endif
                                    @if(auth()->user()->role === 'superadmin' && !$user->is_validated)
                                        <form action="{{ route('users.validate', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="flex flex-col items-center text-green-600 hover:text-green-900 mx-2">
                                                <i class="fas fa-check text-sm"></i>
                                                <span class="text-sm">Accepter</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('users.refuse', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex flex-col items-center text-red-600 hover:text-red-900 mx-2" onclick="return confirm('Refuser cet utilisateur ?')">
                                                <i class="fas fa-times text-sm"></i>
                                                <span class="text-sm">Refuser</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-2">Aucun utilisateur trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $users->links() }}
            </div>
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