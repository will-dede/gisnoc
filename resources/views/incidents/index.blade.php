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

    <div class="container-fluid mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center space-x-6">
                <h1 class="text-2xl font-bold text-gray-800">Liste des incidents</h1>
                
                <!-- Barre de recherche -->
                <form method="GET" action="" class="ml-3 flex items-center gap-2">
                    <select name="search_type" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="all" {{ request('search_type', 'all') == 'all' ? 'selected' : '' }}>Tout rechercher</option>
                        <option value="nom_site" {{ request('search_type') == 'nom_site' ? 'selected' : '' }}>Nom du site</option>
                        <option value="causes_incident" {{ request('search_type') == 'causes_incident' ? 'selected' : '' }}>Cause de l'incident</option>
                        <option value="actions_effectuees" {{ request('search_type') == 'actions_effectuees' ? 'selected' : '' }}>Action effectuée</option>
                    </select>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Terme de recherche..." 
                           class="border border-gray-300 rounded-md px-3 py-2 w-64 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        <i class="fas fa-search mr-2"></i>Rechercher
                    </button>
                </form>
            </div>
            
            @if(auth()->check() && (auth()->user()->role === 'noc_engineer' || auth()->user()->role === 'superadmin'))
            <a href="{{ route('incidents.create') }}" class="bg-green-600 text-white font-bold px-4 py-2 rounded hover:bg-green-700">
                <i class="fas fa-plus mr-2"></i>Nouvel incident
            </a>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filtres et informations de recherche -->
        <div class="mb-4">
            <!-- Filtres principaux avec comptage intégré -->
            <div class="flex flex-wrap items-center gap-2 mb-4">
                @php
                    // Calculer les compteurs sur TOUS les incidents, pas seulement ceux filtrés
                    $allIncidents = \App\Models\Incident::query();
                    
                    // Appliquer seulement la recherche si elle existe
                    if (request('search')) {
                        $search = request('search');
                        $searchType = request('search_type', 'all');
                        
                        $allIncidents->where(function($query) use ($search, $searchType) {
                            switch($searchType) {
                                case 'nom_site':
                                    $query->whereHas('site', function($q) use ($search) {
                                        $q->where('nom_site', 'like', "%$search%");
                                    });
                                    break;
                                case 'causes_incident':
                                    $query->where('causes_incident', 'like', "%$search%");
                                    break;
                                case 'actions_effectuees':
                                    $query->where('actions_effectuees', 'like', "%$search%");
                                    break;
                                default:
                                    $query->where(function($q) use ($search) {
                                        $q->whereHas('site', function($siteQuery) use ($search) {
                                            $siteQuery->where('nom_site', 'like', "%$search%");
                                        })
                                        ->orWhere('causes_incident', 'like', "%$search%")
                                        ->orWhere('actions_effectuees', 'like', "%$search%");
                                    });
                            }
                        });
                    }
                    
                    $allIncidents = $allIncidents->get();
                    
                    $totalCount = $allIncidents->count();
                    $enCoursCount = $allIncidents->whereNull('date_fin_incident')->count();
                    $cloturesCount = $allIncidents->whereNotNull('date_fin_incident')->count();
                @endphp
                
                <a href="{{ request()->fullUrlWithQuery(['filter' => '']) }}" 
                   class="px-4 py-2 text-sm font-medium rounded-lg {{ !request('filter') ? 'bg-blue-100 text-blue-700 border border-blue-300' : 'bg-gray-100 text-gray-700 border border-gray-300 hover:bg-gray-200' }} transition-colors">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-list"></i>
                        Tous les incidents
                        <span class="bg-blue-200 text-blue-800 text-xs font-bold px-2 py-1 rounded-full">{{ $totalCount }}</span>
                    </span>
                </a>
                
                <a href="{{ request()->fullUrlWithQuery(['filter' => 'en_cours']) }}" 
                   class="px-4 py-2 text-sm font-medium rounded-lg {{ request('filter') === 'en_cours' ? 'bg-yellow-100 text-yellow-700 border border-yellow-300' : 'bg-gray-100 text-gray-700 border border-gray-300 hover:bg-gray-200' }} transition-colors">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-clock"></i>
                        En cours
                        <span class="bg-yellow-200 text-yellow-800 text-xs font-bold px-2 py-1 rounded-full">{{ $enCoursCount }}</span>
                    </span>
                </a>
                
                <a href="{{ request()->fullUrlWithQuery(['filter' => 'clotures']) }}" 
                   class="px-4 py-2 text-sm font-medium rounded-lg {{ request('filter') === 'clotures' ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-gray-100 text-gray-700 border border-gray-300 hover:bg-gray-200' }} transition-colors">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        Clôturés
                        <span class="bg-green-200 text-green-800 text-xs font-bold px-2 py-1 rounded-full">{{ $cloturesCount }}</span>
                    </span>
                </a>
            </div>
            
            <!-- Filtres par technologie avec comptage -->
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <span class="text-sm font-medium text-gray-700 mr-2">Technologies :</span>
                @foreach($technologies as $tech)
                    @php
                        // Calculer le compteur sur TOUS les incidents (avec recherche si applicable)
                        $techCount = $allIncidents->filter(function($incident) use ($tech) {
                            return $incident->secteurs->some(function($secteur) use ($tech) {
                                return $secteur->frequence->technologie->id === $tech->id;
                            });
                        })->count();
                    @endphp
                    <a href="{{ request()->fullUrlWithQuery(['tech_filter' => $tech->id]) }}" 
                       class="px-3 py-2 text-sm font-medium rounded-lg {{ request('tech_filter') == $tech->id ? 'bg-purple-100 text-purple-700 border border-purple-300' : 'bg-gray-100 text-gray-700 border border-gray-300 hover:bg-gray-200' }} transition-colors">
                        <span class="flex items-center gap-2">
                            {{ $tech->nom_technologie }}
                            <span class="bg-purple-200 text-purple-800 text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $techCount }}</span>
                        </span>
                    </a>
                @endforeach
                @if(request('tech_filter'))
                    <a href="{{ request()->fullUrlWithQuery(['tech_filter' => '']) }}" 
                       class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-times mr-1"></i>
                        Effacer
                    </a>
                @endif
            </div>
            
            <!-- Informations de recherche simplifiées -->
            @if(request('search'))
                <div class="text-sm text-gray-600 bg-blue-50 px-3 py-2 rounded-lg border border-blue-200">
                    <span class="inline-flex items-center gap-2">
                        <i class="fas fa-search text-blue-600"></i>
                        Recherche : "{{ request('search') }}"
                        <span class="bg-blue-200 text-blue-800 text-xs font-bold px-2 py-1 rounded-full">{{ $incidents->count() }} résultat(s)</span>
                    </span>
                </div>
            @endif
        </div>

        <div class="scroll-container custom-scrollbar">
            <table class="min-w-full divide-y divide-gray-200" style="min-width: 1400px;">
                <thead class="bg-gray-50">
                    <tr class="border-2 border-gray-200 text-sm" style="font-weight:600!important;">
                        <th class="border px-2 py-1">N°</th>
                        <th class="border px-2 py-1">
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
                        <th class="border px-2 py-1">Secteurs</th>
                        <th class="border px-2 py-1">Date début</th>
                        <th class="border px-2 py-1">Date fin</th>
                        <th class="border px-2 py-1">Down time</th>
                        <th class="border px-2 py-1">Technicien<br>contacté</th>
                        <th class="border px-2 py-1">Zone de<br>maintenance</th>
                        <th class="border px-2 py-1">Intervenant</th>
                        <th class="border px-2 py-1">Causes</th>
                        <th class="border px-2 py-1">Actions <br>effectuées</th>
                        <th class="border px-2 py-1">Type <br>d'alarme</th>
                        <th class="border px-2 py-1">Observation</th>
                        <th class="border px-2 py-1">NOC Engineer</th>
                        <th class="border px-2 py-1">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $i = 1;
                    @endphp
                    @forelse($incidents as $incident)
                        <tr class="hover:bg-blue-50 even:bg-gray-50">
                            <td class="border px-6 py-2 whitespace-nowrap text-sm text-gray-900 uppercase">{{ $i++ }}</td>
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
                                @if($incident->date_fin_incident && $incident->date_debut_incident)
                                    {{ \Carbon\Carbon::parse($incident->date_debut_incident)->diffInMinutes(\Carbon\Carbon::parse($incident->date_fin_incident)) }} min
                                @else
                                    <span class="inline-block bg-yellow-50 text-yellow-800 px-2 py-1 rounded text-xs font-medium">
                                        En cours
                                    </span>
                                @endif
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
                                    @if(auth()->check() && (auth()->user()->role === 'noc_engineer' || auth()->user()->role === 'superadmin'))

                                    <div class="flex flex-col items-center">
                                        <a href="{{ route('incidents.edit', $incident) }}" class="flex flex-col items-center text-yellow-700 hover:text-yellow-900">
                                            <i class="fas fa-edit text-xl mb-1"></i>
                                            <span class="fw-bold">Modifier</span>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
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