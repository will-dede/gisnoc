<x-app-layout>
    <style>
        /* Styles pour la barre de défilement personnalisée - Style moderne et classe */
        .custom-scrollbar::-webkit-scrollbar {
            width: 12px;  /* Largeur pour scrollbar verticale */
            height: 12px; /* Hauteur pour scrollbar horizontale */
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: linear-gradient(90deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 10px;
            border: 1px solid #1d4ed8;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transform: scaleY(1.1);
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:active {
            background: linear-gradient(90deg, #1d4ed8 0%, #1e3a8a 100%);
        }
        
        /* Styles pour Firefox - Style moderne */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #3b82f6 #f8fafc;
        }
        
        /* Animation pour indiquer le défilement */
        .table-container {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .table-container::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 30px;
            background: linear-gradient(to right, transparent, rgba(59, 130, 246, 0.1));
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.4s ease;
            border-radius: 0 12px 12px 0;
        }
        
        .table-container:hover::after {
            opacity: 1;
        }
        
        /* Effet de brillance sur la barre de défilement */
        .custom-scrollbar::-webkit-scrollbar-thumb::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.3) 0%, transparent 100%);
            border-radius: 10px 10px 0 0;
            pointer-events: none;
        }

        /* Styles spécifiques pour les scrollbars verticales et horizontales */
        .scroll-container {
            max-height: 70vh;
            max-width: 100%;
            overflow: auto;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Scrollbar verticale */
        .scroll-container::-webkit-scrollbar:vertical {
            width: 12px;
        }

        .scroll-container::-webkit-scrollbar-thumb:vertical {
            background: linear-gradient(180deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 10px;
            border: 1px solid #1d4ed8;
        }

        .scroll-container::-webkit-scrollbar-thumb:vertical:hover {
            background: linear-gradient(180deg, #2563eb 0%, #1e40af 100%);
        }

        /* Scrollbar horizontale */
        .scroll-container::-webkit-scrollbar:horizontal {
            height: 12px;
        }

        .scroll-container::-webkit-scrollbar-thumb:horizontal {
            background: linear-gradient(90deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 10px;
            border: 1px solid #1d4ed8;
        }

        .scroll-container::-webkit-scrollbar-thumb:horizontal:hover {
            background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
        }

        /* Track pour les deux directions */
        .scroll-container::-webkit-scrollbar-track {
            background: linear-gradient(90deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        /* Indicateurs de défilement */
        .scroll-indicator {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(59, 130, 246, 0.9);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .scroll-indicator.show {
            opacity: 1;
        }
    </style>

    <div class="container-fluid mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center flex-1">
                <h1 class="text-2xl font-bold p-2 text-gray-800 mx-3">Liste des incidents</h1>
                <form action="{{ route('incidents.index') }}" method="GET" class="relative flex items-center">
                    <div class="relative flex">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               class="pl-10 pr-10 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Rechercher un incident...">
                        @if(request('search'))
                            <a href="{{ route('incidents.index') }}" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                        <i class="fas fa-search"></i>
                        Rechercher
                    </button>
                </form>
            </div>
            <a href="{{ route('incidents.create') }}" class="bg-green-600 text-white font-bold px-4 py-2 rounded hover:bg-green-700">
                <i class="fas fa-plus mr-2"></i>Nouvel incident
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(request('search'))
            <div class="mb-4 text-sm text-gray-600">
                Résultats de recherche pour : "{{ request('search') }}"
                <span class="ml-2">({{ $incidents->count() }} résultat(s))</span>
            </div>
        @endif

        <div class="scroll-container custom-scrollbar">
            <table class="min-w-full divide-y divide-gray-200" style="min-width: 1400px;">
                <thead class="bg-gray-50">
                    <tr class="border-2 border-gray-200" style="font-weight:bold;">
                        <th class="px-6 py-3 text-left text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider">N°</th>
                        <th class="px-6 py-3 text-left text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider {{ request('sort') === 'site' ? 'bg-blue-50' : '' }}">
                            <div class="flex items-center space-x-1">
                                <span>Site</span>
                                <div class="flex flex-col px-1 -space-y-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'site', 'direction' => 'asc']) }}" 
                                       class="{{ request('sort') === 'site' && request('direction') === 'asc' ? 'text-blue-500' : 'text-gray-400' }} hover:text-blue-500">
                                        <i class="fas fa-sort-up text-xs"></i>
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'site', 'direction' => 'desc']) }}" 
                                       class="{{ request('sort') === 'site' && request('direction') === 'desc' ? 'text-blue-500' : 'text-gray-400' }} hover:text-blue-500">
                                        <i class="fas fa-sort-down text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider">Secteurs</th>
                        <th class="px-6 py-3 text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider {{ request('sort') === 'date_debut' || !request('sort') ? 'bg-blue-50' : '' }}">
                            <div class="flex text-center items-center space-x-1">
                                <span>Date début</span>
                                <div class="flex flex-col px-1 -space-y-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'date_debut', 'direction' => 'asc']) }}" 
                                       class="{{ (request('sort') === 'date_debut' && request('direction') === 'asc') || !request('sort') ? 'text-blue-500' : 'text-gray-400' }} hover:text-blue-500">
                                        <i class="fas fa-sort-up text-xs"></i>
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'date_debut', 'direction' => 'desc']) }}" 
                                       class="{{ request('sort') === 'date_debut' && request('direction') === 'desc' ? 'text-blue-500' : 'text-gray-400' }} hover:text-blue-500">
                                        <i class="fas fa-sort-down text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider {{ request('sort') === 'date_fin' ? 'bg-blue-50' : '' }}">
                            <div class="flex text-center items-center space-x-1">
                                <span>Date fin</span>
                                <div class="flex flex-col px-1 -space-y-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'date_fin', 'direction' => 'asc']) }}" 
                                       class="{{ request('sort') === 'date_fin' && request('direction') === 'asc' ? 'text-blue-500' : 'text-gray-400' }} hover:text-blue-500">
                                        <i class="fas fa-sort-up text-xs"></i>
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'date_fin', 'direction' => 'desc']) }}" 
                                       class="{{ request('sort') === 'date_fin' && request('direction') === 'desc' ? 'text-blue-500' : 'text-gray-400' }} hover:text-blue-500">
                                        <i class="fas fa-sort-down text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider">Down time</th>
                        <th class="px-6 py-3 text-center text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider {{ request('sort') === 'technicien' ? 'bg-blue-50' : '' }}">
                            <div class="flex items-center space-x-1">
                                <span>Technicien<br>contacté</span>
                                <div class="flex flex-col px-1 -space-y-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'technicien', 'direction' => 'asc']) }}" 
                                       class="{{ request('sort') === 'technicien' && request('direction') === 'asc' ? 'text-blue-500' : 'text-gray-400' }} hover:text-blue-500">
                                        <i class="fas fa-sort-up text-xs"></i>
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'technicien', 'direction' => 'desc']) }}" 
                                       class="{{ request('sort') === 'technicien' && request('direction') === 'desc' ? 'text-blue-500' : 'text-gray-400' }} hover:text-blue-500">
                                        <i class="fas fa-sort-down text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider">Zone de<br>maintenance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider">Intervenant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider">Causes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider">Actions <br>effectuées</th>
                        <th class="px-6 py-3 text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider {{ request('sort') === 'type_alarme' ? 'bg-blue-50' : '' }}">
                            <div class="flex items-center space-x-1">
                                <span class="text-center">Type <br>d'alarme</span>
                                <div class="flex flex-col px-1 -space-y-3">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'type_alarme', 'direction' => 'asc']) }}" 
                                       class="{{ request('sort') === 'type_alarme' && request('direction') === 'asc' ? 'text-blue-500' : 'text-gray-400' }} hover:text-blue-500">
                                        <i class="fas fa-sort-up text-xs"></i>
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'type_alarme', 'direction' => 'desc']) }}" 
                                       class="{{ request('sort') === 'type_alarme' && request('direction') === 'desc' ? 'text-blue-500' : 'text-gray-400' }} hover:text-blue-500">
                                        <i class="fas fa-sort-down text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider">Observation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider">Créé par</th>
                        <th class="px-6 py-3 text-left text-xs font-medium fw-bold text-gray-900 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $i = 1;
                    @endphp
                    @forelse($incidents as $incident)
                        <tr class="hover:bg-blue-50 even:bg-gray-50">
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900 uppercase">{{ $i++ }}</td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900 uppercase">
                                {{ $incident->site ? $incident->site->nom_site : '-' }}
                                @if($incident->sites->count() == 1)
                                    <br><span class="normal-case">{{ $incident->sites->count() }} site impacté</span>
                                    @elseif($incident->sites->count() > 1)
                                    <br><span class="normal-case">{{ $incident->sites->count() }} sites impactés</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($incident->secteurs && $incident->secteurs->count())
                                    @php
                                        // Regroupement par technologie > fréquence > secteurs
                                        $tree = [];
                                        $techObjects = [];
                                        $freqObjects = [];
                                        foreach($incident->secteurs as $secteur) {
                                            $freq = $secteur->frequence;
                                            $tech = $freq ? $freq->technologie : null;
                                            $techKey = $tech ? $tech->nom_technologie : '?';
                                            $freqKey = $freq ? $freq->nom_freq : '?';
                                            if (!isset($tree[$techKey])) $tree[$techKey] = [];
                                            if (!isset($tree[$techKey][$freqKey])) $tree[$techKey][$freqKey] = [];
                                            $tree[$techKey][$freqKey][] = $secteur->nom_secteur;
                                            if ($tech) $techObjects[$techKey] = $tech;
                                            if ($freq) $freqObjects[$techKey][$freqKey] = $freq;
                                        }
                                    @endphp
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($tree as $techKey => $freqs)
                                            @php
                                                $tech = $techObjects[$techKey] ?? null;
                                                // Liste complète des secteurs pour cette techno (toutes fréquences)
                                                $allSecteursTech = $tech ? $tech->frequences->flatMap(function($f) { return $f->secteurs->pluck('nom_secteur'); })->sort()->values()->toArray() : [];
                                                $secteursTech = collect($freqs)->flatten()->sort()->values()->toArray();
                                            @endphp
                                            @if($allSecteursTech && $secteursTech === $allSecteursTech)
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                                    {{ $techKey }}
                                                </span>
                                            @else
                                                @foreach($freqs as $freqKey => $secteurs)
                                                    @php
                                                        $freq = $freqObjects[$techKey][$freqKey] ?? null;
                                                        $allSecteursFreq = $freq ? $freq->secteurs->pluck('nom_secteur')->sort()->values()->toArray() : [];
                                                        $secteursSorted = collect($secteurs)->sort()->values()->toArray();
                                                    @endphp
                                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                                        {{ $techKey }} / {{ $freqKey }}@if($allSecteursFreq && $secteursSorted !== $allSecteursFreq) / {{ implode(', ', $secteursSorted) }}@endif
                                                    </span>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ $incident->date_debut_incident ? $incident->date_debut_incident->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ $incident->date_fin_incident ? $incident->date_fin_incident->format('d/m/Y H:i') : 'En cours' }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $incident->date_fin_incident && $incident->date_debut_incident ? \Carbon\Carbon::parse($incident->date_debut_incident)->diffInMinutes(\Carbon\Carbon::parse($incident->date_fin_incident)) : '-' }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ $incident->technicien ? $incident->technicien->nom_tech . ' ' . $incident->technicien->prenom_tech : '-' }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900 text-center">
                                {{ $incident->site->zoneMaintenance->nom_zone ?? '-' }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $incident->intervenant ?? '-' }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ Str::limit($incident->causes_incident, 40) ?? '-' }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ Str::limit($incident->actions_effectuees, 40) ?? '-' }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-center text-gray-900">
                                {{ $incident->typeAlarme->nom_type_alarme ?? '-' }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ Str::limit($incident->observation, 40) ?? '-' }}
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ $incident->user ? $incident->user->firstname . ' ' . $incident->user->lastname : '-' }}
                            </td>
                            <td class="px-1 py-2 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-4 text-xs justify-end">
                                    <div class="flex flex-col items-center">
                                        <a href="{{ route('incidents.show', $incident) }}" class="flex flex-col items-center text-blue-700 hover:text-blue-900">
                                            <i class="fas fa-eye text-xl mb-1"></i>
                                            <span class="fw-bold">Détails</span>
                                        </a>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <a href="{{ route('incidents.edit', $incident) }}" class="flex flex-col items-center text-yellow-700 hover:text-yellow-900">
                                            <i class="fas fa-edit text-xl mb-1"></i>
                                            <span class="fw-bold">Modifier</span>
                                        </a>
                                    </div>
                                    <!-- <div class="flex flex-col items-center">
                                        <button type="button" 
                                                onclick="document.getElementById('deleteModal{{ $incident->id }}').classList.remove('hidden')"
                                                class="flex flex-col items-center text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash text-xl mb-1"></i>
                                            <span class="">Supprimer</span>
                                        </button>
                                    </div> -->
                                </div>

                                <!-- Modal de confirmation de suppression -->
                                <div id="deleteModal{{ $incident->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                        <div class="mt-3 text-center">
                                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                                            </div>
                                            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Confirmation de suppression</h3>
                                            <div class="mt-2 px-7 py-3">
                                                <p class="text-sm text-gray-500">
                                                    Êtes-vous sûr de vouloir supprimer cet incident ? Cette action est irréversible.
                                                </p>
                                            </div>
                                            <div class="flex justify-center mt-4 space-x-4">
                                                <button onclick="document.getElementById('deleteModal{{ $incident->id }}').classList.add('hidden')" 
                                                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                                    Annuler
                                                </button>
                                                <form action="{{ route('incidents.destroy', $incident) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                                        Confirmer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                @if(request('search'))
                                    Aucun incident ne correspond à votre recherche.
                                @else
                                    Aucun incident trouvé.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Indicateur de défilement -->
        <div id="scrollIndicator" class="scroll-indicator">
            <i class="fas fa-arrows-alt mr-2"></i>
            <span id="scrollText">Défilement disponible</span>
        </div>

        <script>
            // Gestion de l'indicateur de défilement
            const scrollContainer = document.querySelector('.scroll-container');
            const scrollIndicator = document.getElementById('scrollIndicator');
            const scrollText = document.getElementById('scrollText');

            function updateScrollIndicator() {
                const hasVerticalScroll = scrollContainer.scrollHeight > scrollContainer.clientHeight;
                const hasHorizontalScroll = scrollContainer.scrollWidth > scrollContainer.clientWidth;
                
                if (hasVerticalScroll || hasHorizontalScroll) {
                    let text = '';
                    if (hasVerticalScroll && hasHorizontalScroll) {
                        text = 'Défilement vertical et horizontal';
                    } else if (hasVerticalScroll) {
                        text = 'Défilement vertical';
                    } else if (hasHorizontalScroll) {
                        text = 'Défilement horizontal';
                    }
                    
                    scrollText.textContent = text;
                    scrollIndicator.classList.add('show');
                    
                    // Masquer après 3 secondes
                    setTimeout(() => {
                        scrollIndicator.classList.remove('show');
                    }, 3000);
                }
            }

            // Vérifier au chargement et au redimensionnement
            window.addEventListener('load', updateScrollIndicator);
            window.addEventListener('resize', updateScrollIndicator);
        </script>
    </div>
</x-app-layout> 