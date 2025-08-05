<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-7xl mx-auto">
            <!-- En-tête avec informations du site -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold text-gray-800">
                        Historique des incidents - {{ $site->nom_site }}
                    </h1>
                    <a href="{{ route('sites.show', $site) }}" class="text-blue-700 px-2 py-1 rounded hover:bg-blue-100 flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Retour au site</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2">
                <!-- Filtre par période -->
                <div class="bg-white rounded-lg shadow p-4 mb-2 me-4">
                    <form method="GET" action="{{ route('sites.incidents', $site) }}">
                        <div>
                            <div class="flex justify-between">
                                <h2 class="text-lg font-semibold text-gray-700 mb-4">Filtrer par période</h2>
                                <div class="flex gap-2">
                                    <button type="submit" class="text-blue-700 px-2 py-1 rounded hover:bg-blue-100 flex items-center gap-2">
                                        <i class="fas fa-filter"></i>
                                        <span>Filtrer</span>
                                    </button>
                                    
                                    @if(request('date_debut') || request('date_fin'))
                                        <a href="{{ route('sites.incidents', $site) }}" class="text-gray-700 px-4 py-1 rounded hover:bg-gray-100 flex items-center gap-2">
                                            <i class="fas fa-times"></i>
                                            <span>Effacer</span>
                                        </a>
                                    @endif
                                </div>
                            </div>


                            <div class="flex flex-wrap gap-4 items-end">
                                <div class="flex-1 min-w-48">
                                    <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                                    <input type="date" 
                                        id="date_debut" 
                                        name="date_debut" 
                                        value="{{ request('date_debut') }}"
                                        class="w-full px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div class="flex-1 min-w-48">
                                    <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                                    <input type="date" 
                                        id="date_fin" 
                                        name="date_fin" 
                                        value="{{ request('date_fin') }}"
                                        class="w-full px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <!-- @if(request('date_debut') || request('date_fin'))
                        <div class="mt-3 p-3 bg-blue-50 rounded-md">
                            <p class="text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                Filtrage actif : 
                                @if(request('date_debut') && request('date_fin'))
                                    du {{ \Carbon\Carbon::parse(request('date_debut'))->format('d/m/Y') }} au {{ \Carbon\Carbon::parse(request('date_fin'))->format('d/m/Y') }}
                                @elseif(request('date_debut'))
                                    à partir du {{ \Carbon\Carbon::parse(request('date_debut'))->format('d/m/Y') }}
                                @elseif(request('date_fin'))
                                    jusqu'au {{ \Carbon\Carbon::parse(request('date_fin'))->format('d/m/Y') }}
                                @endif
                            </p>
                        </div>
                    @endif -->
                </div>
    
                <!-- Statistiques -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
                    <div class="bg-white rounded-lg flex items-center shadow p-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-red-100 rounded-lg">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Total incidents</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $incidents->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg flex items-center shadow p-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-yellow-100 rounded-lg">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Durée moyenne</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    @php
                                        $totalDuration = 0;
                                        $count = 0;
                                        foreach($incidents as $incident) {
                                            if($incident->pivot->date_debut_incident && $incident->pivot->date_fin_incident) {
                                                $duration = \Carbon\Carbon::parse($incident->pivot->date_debut_incident)->diffInMinutes(\Carbon\Carbon::parse($incident->pivot->date_fin_incident));
                                                $totalDuration += $duration;
                                                $count++;
                                            }
                                        }
                                        echo $count > 0 ? round($totalDuration / $count, 0) . ' min' : '-';
                                    @endphp
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg flex items-center shadow p-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <i class="fas fa-calendar text-green-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Dernier incident</p>
                                <p class="text-sm font-bold text-gray-900">
                                    {{ $incidents->first() && $incidents->first()->pivot->date_debut_incident ? \Carbon\Carbon::parse($incidents->first()->pivot->date_debut_incident)->format('d/m/Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(request('date_debut') || request('date_fin'))
                <div class="mb-3 p-3 bg-blue-50 rounded-md">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-1"></i>
                        Filtrage actif : 
                        @if(request('date_debut') && request('date_fin'))
                            du {{ \Carbon\Carbon::parse(request('date_debut'))->format('d/m/Y') }} au {{ \Carbon\Carbon::parse(request('date_fin'))->format('d/m/Y') }}
                        @elseif(request('date_debut'))
                            à partir du {{ \Carbon\Carbon::parse(request('date_debut'))->format('d/m/Y') }}
                        @elseif(request('date_fin'))
                            jusqu'au {{ \Carbon\Carbon::parse(request('date_fin'))->format('d/m/Y') }}
                        @endif
                    </p>
                </div>
            @endif

            <!-- Tableau des incidents -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Historique détaillé des incidents</h3>
                </div>
                
                @if($incidents->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        N°
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date de début
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Durée (min)
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Techn-Fréq-Sect
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Causes
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions effectuées
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php $i = 1; @endphp
                                @foreach($incidents as $incident)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                            {{ $i++ }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $incident->pivot->date_debut_incident ? \Carbon\Carbon::parse($incident->pivot->date_debut_incident)->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($incident->pivot->date_debut_incident && $incident->pivot->date_fin_incident)
                                                @php
                                                    $duration = \Carbon\Carbon::parse($incident->pivot->date_debut_incident)->diffInMinutes(\Carbon\Carbon::parse($incident->pivot->date_fin_incident));
                                                    echo $duration . ' min';
                                                @endphp
                                            @else
                                                <span class="text-yellow-600 font-medium">En cours</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            @if($incident->secteurs && $incident->secteurs->count() > 0)
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
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="max-w-xs">
                                                {{ Str::limit($incident->pivot->causes_incident, 80) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="max-w-xs">
                                                {{ Str::limit($incident->pivot->actions_effectuees, 80) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <a href="{{ route('incidents.show', $incident) }}" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                                                <i class="fas fa-eye mr-1"></i>
                                                Voir plus
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-8 text-center">
                        <i class="fas fa-check-circle text-green-500 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun incident</h3>
                        <p class="text-gray-500">Ce site n'a enregistré aucun incident pour le moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 