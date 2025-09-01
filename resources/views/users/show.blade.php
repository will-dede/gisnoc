<x-app-layout>
    @if(auth()->check() && auth()->user()->role === 'superadmin')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- En-tête avec navigation -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Détails de l'utilisateur</h1>
                    <p class="text-gray-600 mt-2">Gestion et informations du compte</p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('users.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour
                    </a>
                    
                    <a href="{{ route('users.edit', $user) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier
                    </a>
                    
                    @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Supprimer
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Grille d'informations -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
                <!-- Carte principale - Informations personnelles -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Informations personnelles</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-500">Nom complet</p>
                                        <p class="text-base text-gray-900">{{ $user->lastname }} {{ $user->firstname }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-envelope text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-500">Adresse email</p>
                                        <p class="text-base text-gray-900">{{ $user->email }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-phone text-purple-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-500">Téléphone</p>
                                        <p class="text-base text-gray-900">{{ $user->telephone ?: 'Non renseigné' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
 
                 <!-- Carte latérale - Informations du compte -->
                 <div class="lg:col-span-1">
                     <div class="bg-white rounded-lg border border-gray-200 shadow-sm h-full">
                         <div class="px-6 py-4 border-b border-gray-200">
                             <h2 class="text-lg font-semibold text-gray-900">Informations du compte</h2>
                         </div>
                         <div class="p-6 space-y-4">
                             <!-- Rôle -->
                             <div>
                                 <p class="text-sm font-medium text-gray-500 mb-2">Rôle</p>
                                 @php
                                     $roleConfig = [
                                         'superadmin' => ['color' => 'bg-red-100 text-red-800 border-red-200', 'icon' => 'fas fa-shield-alt'],
                                         'admin' => ['color' => 'bg-purple-100 text-purple-800 border-purple-200', 'icon' => 'fas fa-user-shield'],
                                         'noc_engineer' => ['color' => 'bg-blue-100 text-blue-800 border-blue-200', 'icon' => 'fas fa-tools'],
                                         'technicien' => ['color' => 'bg-green-100 text-green-800 border-green-200', 'icon' => 'fas fa-wrench'],
                                         'user' => ['color' => 'bg-gray-100 text-gray-800 border-gray-200', 'icon' => 'fas fa-user']
                                     ];
                                     $role = $roleConfig[$user->role] ?? $roleConfig['user'];
                                 @endphp
                                 <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium border {{ $role['color'] }}">
                                     <i class="{{ $role['icon'] }} mr-2"></i>
                                     {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                 </span>
                             </div>
 
                             <!-- Statut du compte -->
                             <div>
                                 <p class="text-sm font-medium text-gray-500 mb-2">Statut</p>
                                 @if($user->is_validated)
                                 <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                     <i class="fas fa-check-circle mr-2"></i>
                                     Actif
                                 </span>
                                 @else
                                 <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                     <i class="fas fa-clock mr-2"></i>
                                     En attente
                                 </span>
                                 @endif
                                 
                             </div>
 
                             <!-- Date d'inscription -->
                             <div>
                                 <p class="text-sm font-medium text-gray-500 mb-2">Membre depuis</p>
                                 <p class="text-sm text-gray-900">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Date inconnue' }}</p>
                             </div>
 
                             <!-- Dernière connexion -->
                             <div>
                                 <p class="text-sm font-medium text-gray-500 mb-2">Dernière connexion</p>
                                 <p class="text-sm text-gray-900">{{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i') : 'Jamais connecté' }}</p>
                             </div>
                         </div>
                     </div>
 
                </div>

                <!-- Carte des actions rapides -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm h-full">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Actions rapides</h2>
                        </div>
                        <div class="p-6 space-y-3">
                            
                            <div class="text-xs text-gray-500 text-center">
                                ID utilisateur : {{ $user->id }}
                            </div>
                            <a href="{{ route('users.edit', $user) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                                <i class="fas fa-edit mr-2"></i>
                                Modifier le profil
                            </a>

                            @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" 
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                                        <i class="fas fa-trash mr-2"></i>
                                        Supprimer l'utilisateur
                                    </button>
                                </form>
                            @else
                                <span class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                                    <i class="fas fa-ban mr-2"></i>
                                    Suppression indisponible sur votre compte
                                </span>
                            @endif
                             
                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages de session -->
            @if(session('success'))
                <div class="mt-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mt-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif
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