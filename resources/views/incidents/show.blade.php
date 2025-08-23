<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex">
                            <a href="{{ route('incidents.index') }}" class="inline-flex text-center items-center px-1 py-1 hover:bg-blue-50 rounded focus:outline-none focus:shadow-outline">
                                <i class="fas fa-arrow-left mr-2"></i> &nbsp;
                            </a>
                            <h1 class="text-2xl font-semibold text-gray-800">Détails de l'incident sur <span class="uppercase">{{ $incident->site->nom_site }}</span>
                            @if($incident->sites->count() == 1)
                                ({{ $incident->sites->count() }} site impacté)
                            @elseif($incident->sites->count() > 1)
                                ({{ $incident->sites->count() }} sites impactés)
                            @endif
                            </h1>
                        </div>
                        @if(auth()->check() && (auth()->user()->role === 'noc_engineer' || auth()->user()->role === 'superadmin'))
                        <div class="flex space-x-2">
                            <a href="{{ route('incidents.edit', $incident) }}" class="flex flex-col items-center text-yellow-600 hover:text-yellow-900">
                                <i class="fas fa-edit text-xl mb-1"></i>
                                <span class="text-xs">Modifier</span>
                            </a>
                            <button type="button" 
                                    onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                                    class="flex flex-col items-center text-red-600 hover:text-red-900">
                                <i class="fas fa-trash text-xl mb-1"></i>
                                <span class="text-xs">Supprimer</span>
                            </button>
                        </div>
                        @endif
                    </div>

                    <!-- Informations de base -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="space-y-4">
                            {{--
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nom du site</label>
                                    <p class="mt-1 text-sm text-gray-900 font-bold uppercase">{{ $incident->site ? $incident->site->nom_site : '-' }}</p>
                                </div>
                            --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Technicien contacté</label>
                                <p class="mt-1 text-sm text-gray-900 font-bold">{{ $incident->technicien ? $incident->technicien->nom_tech . ' ' . $incident->technicien->prenom_tech : '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Zone de maintenance</label>
                                <p class="mt-1 text-sm text-gray-900 font-bold">{{ $incident->site->zoneMaintenance->nom_zone ?? '-' }}</p>
                            </div>
                            {{--
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Intervenant</label>
                                    <p class="mt-1 text-sm text-gray-900 font-bold">{{ $incident->intervenant ?: '-' }}</p>
                                </div>
                            --}}
                            <!-- <div>
                                <label class="block text-sm font-medium text-gray-700">Incident enregistré par</label>
                                <p class="mt-1 text-sm text-gray-900 font-bold">{{ $incident->user ? $incident->user->firstname . ' ' . $incident->user->lastname : '-' }}</p>
                            </div> -->
                        </div>
                        <div class="space-y-4">
                            {{--
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date d'enregistrement</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $incident->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Dernière modification</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $incident->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Secteurs concernés</label>
                                @if($incident->secteurs && $incident->secteurs->count())
                                <div class="mb-6">
                                    <div class="mt-1 text-sm text-gray-900 font-bold">
                                        <div class="flex flex-wrap gap-2">
                                            <!-- @foreach($incident->secteurs as $secteur)
                                                <div>
                                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $secteur->nom_secteur }}</span>
                                                </div>
                                            @endforeach -->
                                            <div>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type d'alarme</label>
                                <p class="mt-1 text-sm text-gray-900 font-bold">{{ $incident->typeAlarme->nom_type_alarme ?? '-' }}</p>
                                {{--
                                    @if($incident->typeAlarme && $incident->typeAlarme->descr_type_alarme)
                                        <p class="mt-1 text-xs text-gray-500">{{ $incident->typeAlarme->descr_type_alarme }}</p>
                                    @endif
                                --}}
                            </div>
                        </div>
                    </div>

                    <!-- Détails de l'incident -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Détails de l'incident</h3>
                        @if(auth()->check() && (auth()->user()->role === 'noc_engineer' || auth()->user()->role === 'superadmin'))
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Causes de l'incident</label>
                                <div class="mt-1 p-3 bg-red-50 rounded">
                                    <p class="text-sm text-red-900 whitespace-pre-line">{{ $incident->causes_incident ?: '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Actions effectuées</label>
                                <div class="mt-1 p-3 bg-green-50 rounded">
                                    <p class="text-sm text-green-900 whitespace-pre-line">{{ $incident->actions_effectuees ?: '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Observation</label>
                                <div class="mt-1 p-3 bg-blue-50 rounded">
                                    <p class="text-sm text-blue-900 whitespace-pre-line">{{ $incident->observation ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Causes de l'incident</label>
                                    <div class="mt-1 p-3 bg-red-50 rounded">
                                        <p class="text-sm text-red-900 whitespace-pre-line">{{ $incident->causes_incident ?: 'Aucune cause renseignée.' }}</p>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Actions effectuées</label>
                                    <div class="mt-1 p-3 bg-green-50 rounded">
                                        <p class="text-sm text-green-900 whitespace-pre-line">{{ $incident->actions_effectuees ?: 'Aucune action renseignée.' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Observation</label>
                                    <div class="mt-1 p-3 bg-blue-50 rounded">
                                        <p class="text-sm text-blue-900 whitespace-pre-line">{{ $incident->observation ?: 'Aucune observation.' }}</p>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                                    <div class="mt-1 p-3 bg-yellow-50 rounded">
                                        <p class="text-sm text-yellow-900 whitespace-pre-line">{{ $incident->notes ?: 'Aucune note.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>

                    <!-- Dates -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Dates de l'incident</h3>
                        <div class="">
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <div class="bg-blue-50 p-3 rounded">
                                    <label class="block text-sm font-medium text-blue-700">Début de l'incident</label>
                                    <p class="mt-1 text-sm text-blue-900">{{ $incident->date_debut_incident ? ( $incident->date_debut_incident instanceof \Carbon\Carbon ? $incident->date_debut_incident->format('d/m/Y H:i') : \Carbon\Carbon::parse($incident->date_debut_incident)->format('d/m/Y H:i') ) : '-' }}</p>
                                </div>
                                <div class="bg-green-50 p-3 rounded">
                                    <label class="block text-sm font-medium text-green-700">Fin de l'incident</label>
                                    <p class="mt-1 text-sm text-green-900">{{ $incident->date_fin_incident ? ( $incident->date_fin_incident instanceof \Carbon\Carbon ? $incident->date_fin_incident->format('d/m/Y H:i') : \Carbon\Carbon::parse($incident->date_fin_incident)->format('d/m/Y H:i') ) : 'En cours' }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <label class="block text-sm font-medium text-gray-700">Downtime</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $incident->date_fin_incident && $incident->date_debut_incident ? \Carbon\Carbon::parse($incident->date_debut_incident)->diffInMinutes(\Carbon\Carbon::parse($incident->date_fin_incident)) . ' min' : '-' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <div class="bg-orange-50 p-3 rounded">
                                    <label class="block text-sm font-medium text-orange-700">Date de contact du technicien</label>
                                    <p class="mt-1 text-sm text-orange-900">{{ $incident->date_contact_technicien ? ( $incident->date_contact_technicien instanceof \Carbon\Carbon ? $incident->date_contact_technicien->format('d/m/Y H:i') : \Carbon\Carbon::parse($incident->date_contact_technicien)->format('d/m/Y H:i') ) : '-' }}</p>
                                </div>
                                <div class="bg-purple-50 p-3 rounded">
                                    <label class="block text-sm font-medium text-purple-700">Intervenant</label>
                                    <p class="mt-1 text-sm text-purple-900">{{ $incident->intervenant ?: '-' }}</p>
                                </div>
                                <div class="bg-purple-50 p-3 rounded">
                                    <label class="block text-sm font-medium text-purple-700">Arrivée sur site</label>
                                    <p class="mt-1 text-sm text-purple-900">{{ $incident->date_arrivee_sur_site ? ( $incident->date_arrivee_sur_site instanceof \Carbon\Carbon ? $incident->date_arrivee_sur_site->format('d/m/Y H:i') : \Carbon\Carbon::parse($incident->date_arrivee_sur_site)->format('d/m/Y H:i') ) : '-' }}</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Sites impactés -->
                    @if($incident->sites->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Sites impactés ({{ $incident->sites->count() }})</h3>
                        <div class="overflow-x-auto custom-scrollbar">
                            <table class="min-w-full divide-y divide-gray-200" style="min-width: 1200px;">
                                <thead class="bg-gray-50">
                                    <tr style="font-weight: bold;">
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Site</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date début</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date fin</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DownTime</th>
                                        {{--
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date contact</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date arrivée</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technicien</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type alarme</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intervenant</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Causes</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                        --}}
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observation</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($incident->sites as $site)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900 uppercase">
                                            {{ $site->nom_site }}
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                            @if($site->pivot->date_debut_incident)
                                                {{ \Carbon\Carbon::parse($site->pivot->date_debut_incident)->format('d/m/Y H:i') }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                            @if($site->pivot->date_fin_incident)
                                                {{ \Carbon\Carbon::parse($site->pivot->date_fin_incident)->format('d/m/Y H:i') }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                            @if($site->pivot->date_debut_incident && $site->pivot->date_fin_incident)
                                                {{ \Carbon\Carbon::parse($site->pivot->date_debut_incident)->diffInMinutes(\Carbon\Carbon::parse($site->pivot->date_fin_incident)) . ' min' }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        {{--
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                                @if($site->pivot->date_contact_technicien)
                                                    {{ \Carbon\Carbon::parse($site->pivot->date_contact_technicien)->format('d/m/Y H:i') }}
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                                @if($site->pivot->date_arrivee_sur_site)
                                                    {{ \Carbon\Carbon::parse($site->pivot->date_arrivee_sur_site)->format('d/m/Y H:i') }}
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                                @if($site->pivot->technicien_id)
                                                    @php
                                                        $technicien = App\Models\Technicien::find($site->pivot->technicien_id);
                                                    @endphp
                                                    {{ $technicien ? $technicien->nom_tech . ' ' . $technicien->prenom_tech : '-' }}
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                                @if($site->pivot->type_alarme_id)
                                                    @php
                                                        $typeAlarme = App\Models\TypeAlarme::find($site->pivot->type_alarme_id);
                                                    @endphp
                                                    {{ $typeAlarme ? $typeAlarme->nom_type_alarme : '-' }}
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                                {{ $site->pivot->intervenant ?: '-' }}
                                            </td>
                                            <td class="px-3 py-2 text-sm text-gray-900 max-w-xs">
                                                @if($site->pivot->causes_incident)
                                                    <div class="truncate" title="{{ $site->pivot->causes_incident }}">
                                                        {{ Str::limit($site->pivot->causes_incident, 50) }}
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 text-sm text-gray-900 max-w-xs">
                                                @if($site->pivot->actions_effectuees)
                                                    <div class="truncate" title="{{ $site->pivot->actions_effectuees }}">
                                                        {{ Str::limit($site->pivot->actions_effectuees, 50) }}
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 text-sm text-gray-900 max-w-xs">
                                                @if($site->pivot->notes)
                                                    <div class="truncate" title="{{ $site->pivot->notes }}">
                                                        {{ Str::limit($site->pivot->notes, 50) }}
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        --}}
                                        <td class="px-3 py-2 text-sm text-gray-900 max-w-xs">
                                            @if($site->pivot->observation)
                                                <div class="truncate" title="{{ $site->pivot->observation }}">
                                                    {{ Str::limit($site->pivot->observation, 50) }}
                                                </div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    
                    <div class="mt-10 text-center">
                        <label class="block text-sm font-medium text-gray-700">Incident enregistré par</label>
                        <p class="mt-1 text-sm text-gray-900 font-bold">{{ $incident->user ? $incident->user->firstname . ' ' . $incident->user->lastname : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
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
                    <button onclick="document.getElementById('deleteModal').classList.add('hidden')" 
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
</x-app-layout> 