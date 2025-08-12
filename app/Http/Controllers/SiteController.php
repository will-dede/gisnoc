<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Region;
use App\Models\TypeSite;
use App\Models\Bsc;
use App\Models\Rnc;
use App\Models\ZoneMaintenance;
use App\Models\Technologie;
use App\Models\Incident;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'Site créé avec succès.';
    const SUCCESS_UPDATE = 'Site mis à jour avec succès.';
    const SUCCESS_DELETE = 'Site supprimé avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des sites
    public function index(Request $request)
    {
        $query = Site::with(['typeSite', 'bsc', 'rnc', 'zoneMaintenance', 'region', 'incidents']);

        // Recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $searchType = $request->get('search_type', 'all');
            
            if ($searchType === 'all') {
                // Recherche dans tous les champs
                $query->where(function($q) use ($search) {
                    $q->where('nom_site', 'like', "%{$search}%")
                      ->orWhere('ip3G', 'like', "%{$search}%")
                      ->orWhere('ip4G', 'like', "%{$search}%")
                      ->orWhere('nodeName', 'like', "%{$search}%")
                      ->orWhere('cell2G', 'like', "%{$search}%")
                      ->orWhere('cell3G', 'like', "%{$search}%")
                      ->orWhere('cell4G', 'like', "%{$search}%");
                });
            } else {
                // Recherche ciblée
                $query->where($searchType, 'like', "%{$search}%");
            }
        }

        // Tri
        $sort = $request->get('sort', 'nom_site');
        $direction = $request->get('direction', 'asc');

        switch ($sort) {
            case 'nom_site':
                $query->orderBy('nom_site', $direction);
                break;
            case 'cell2G':
                $query->orderBy('cell2G', $direction);
                break;
            case 'cell3G':
                $query->orderBy('cell3G', $direction);
                break;
            case 'cell4G':
                $query->orderBy('cell4G', $direction);
                break;
            case 'nodeName':
                $query->orderBy('nodeName', $direction);
                break;
            case 'ip3G':
                $query->orderBy('ip3G', $direction);
                break;
            case 'ip4G':
                $query->orderBy('ip4G', $direction);
                break;
            case 'type_site':
                $query->join('type_sites', 'sites.type_site_id', '=', 'type_sites.id')
                      ->orderBy('type_sites.nom_type_site', $direction)
                      ->select('sites.*');
                break;
            case 'bsc':
                $query->join('bscs', 'sites.bsc_id', '=', 'bscs.id')
                      ->orderBy('bscs.nom_bsc', $direction)
                      ->select('sites.*');
                break;
            case 'rnc':
                $query->join('rncs', 'sites.rnc_id', '=', 'rncs.id')
                      ->orderBy('rncs.nom_rnc', $direction)
                      ->select('sites.*');
                break;
            case 'zone':
                $query->join('zone_maintenances', 'sites.zone_maintenance_id', '=', 'zone_maintenances.id')
                      ->orderBy('zone_maintenances.nom_zone', $direction)
                      ->select('sites.*');
                break;
            case 'region':
                $query->join('regions', 'sites.region_id', '=', 'regions.id')
                      ->orderBy('regions.nom_region', $direction)
                      ->select('sites.*');
                break;
            case 'incidents_count':
                $query->withCount(['incidentsPrincipal as incidents_count'])->orderBy('incidents_count', $direction);
                break;
            default:
                $query->orderBy('nom_site', $direction);
        }

        $sites = $query->get();

        return view('sites.index', compact('sites'));
    }

    // Affiche le formulaire de création d'un site
    public function create()
    {
        //Essayons de filtrer pour voir
        $regions = Region::orderBy('nom_region', 'asc')->get();
        $type_sites = TypeSite::orderBy('nom_type_site', 'asc')->get();
        $bscs = Bsc::orderBy('nom_bsc', 'asc')->get();
        $rncs = Rnc::orderBy('nom_rnc', 'asc')->get();
        $zones = ZoneMaintenance::orderBy('nom_zone', 'asc')->get();
        $technologies = Technologie::orderBy('nom_technologie', 'asc')->get();
        $sites = Site::orderBy('nom_site', 'asc')->get();
        
        return view('sites.create', compact('regions', 'type_sites', 'bscs', 'rncs', 'zones', 'technologies', 'sites'));

        $sites = Site::orderBy('nom_site', 'asc')->get();
        return view('sites.create', compact('regions', 'type_sites', 'bscs', 'rncs', 'zones', 'technologies', 'sites'));
    }

    // Enregistre un nouveau site
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules(), $this->validationMessages());
        
        try {
            $site = Site::create($validatedData);
            
            // Gestion des technologies si présentes dans la requête
            if ($request->has('technologies')) {
                $site->technologies()->sync($request->technologies);
            }
            
            return redirect()->route('sites.create')->with('success', self::SUCCESS_CREATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage())
                ->withInput();
        }
    }

    // Affiche les détails d'un site
    public function show(Site $site)
    {
        $site->load(['region', 'typeSite', 'bsc', 'rnc', 'zoneMaintenance', 'technologies', 'incidentsPrincipal']);
        return view('sites.show', compact('site'));
    }

    // Affiche le formulaire d'édition d'un site
    public function edit(Site $site)
    {
        $regions = Region::all();
        $type_sites = TypeSite::all();
        $bscs = Bsc::all();
        $rncs = Rnc::all();
        $zones = ZoneMaintenance::all();
        $technologies = Technologie::all();
        $site->load('technologies');
        return view('sites.edit', compact('site', 'regions', 'type_sites', 'bscs', 'rncs', 'zones', 'technologies'));
    }

    // Met à jour un site
    public function update(Request $request, Site $site)
    {
        $validatedData = $request->validate($this->validationRules($site->id), $this->validationMessages());
        
        try {
            $site->update($validatedData);
            
            // Mise à jour des technologies
            if ($request->has('technologies')) {
                $site->technologies()->sync($request->technologies);
            } else {
                $site->technologies()->detach();
            }
            
            return redirect()->route('sites.index')->with('success', self::SUCCESS_UPDATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage())
                ->withInput();
        }
    }

    // Supprime un site
    public function destroy(Site $site)
    {
        try {
            $site->delete();
            return redirect()->route('sites.index')->with('success', self::SUCCESS_DELETE);
        } catch (\Exception $e) {
            return redirect()->route('sites.index')->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    /**
     * Affiche l'historique des incidents d'un site
     */
    public function incidents(Request $request, Site $site)
    {
        // 1) Incidents où ce site est impacté (relation pivot)
        $pivotQuery = $site->incidents()
            ->with(['typeAlarme', 'user', 'secteurs.frequence.technologie']);

        if ($request->filled('date_debut')) {
            $pivotQuery->where('site_incident.date_debut_incident', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $pivotQuery->where('site_incident.date_debut_incident', '<=', $request->date_fin . ' 23:59:59');
        }
        $pivotIncidents = $pivotQuery->orderBy('site_incident.date_debut_incident', 'desc')->get();

        // 2) Incidents où ce site est le site principal (one-to-many via site_id)
        $principalQuery = $site->incidentsPrincipal()
            ->with(['typeAlarme', 'user', 'secteurs.frequence.technologie']);

        if ($request->filled('date_debut')) {
            $principalQuery->where('date_debut_incident', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $principalQuery->where('date_debut_incident', '<=', $request->date_fin . ' 23:59:59');
        }
        $principalIncidents = $principalQuery->orderBy('date_debut_incident', 'desc')->get();

        // Normaliser les champs attendus par la vue (qui lit via $incident->pivot->...)
        $principalIncidents->each(function ($incident) {
            $incident->setAttribute('pivot', (object) [
                'date_debut_incident'   => $incident->date_debut_incident,
                'date_fin_incident'     => $incident->date_fin_incident,
                'date_arrivee_sur_site' => $incident->date_arrivee_sur_site,
                'intervenant'           => $incident->intervenant,
                'causes_incident'       => $incident->causes_incident,
                'actions_effectuees'    => $incident->actions_effectuees,
                'observation'           => $incident->observation,
                'notes'                 => $incident->notes,
                'technicien_id'         => $incident->technicien_id,
                'type_alarme_id'        => $incident->type_alarme_id,
            ]);
        });

        // Fusionner les deux listes et trier par date début (desc)
        $incidents = $pivotIncidents
            ->merge($principalIncidents)
            ->sortByDesc(function ($incident) {
                return $incident->pivot->date_debut_incident ?? $incident->date_debut_incident;
            })
            ->values();

        return view('sites.incidents', compact('site', 'incidents'));
    }

    /**
     * Récupère les données pour le formulaire de création/édition
     */
    protected function validationRules($id = null)
    {
        return [
            'nom_site' => [
                'required',
                'string',
                'max:255',
                'unique:sites,nom_site,' . $id
            ],
            'cell2G' => [
                'nullable',
                'string',
                'max:30',
                'unique:sites,cell2G,' . $id
            ],
            'cell3G' => [
                'nullable',
                'string',
                'max:30',
                'unique:sites,cell3G,' . $id
            ],
            'cell4G' => [
                'nullable',
                'string',
                'max:30',
                'unique:sites,cell4G,' . $id
            ],
            'nodeName' => [
                'nullable',
                'string',
                'max:30',
                'unique:sites,nodeName,' . $id
            ],
            'ip3G' => [
                'nullable',
                'string',
                'max:19',
                'unique:sites,ip3G,' . $id
            ],
            'ip4G' => [
                'nullable',
                'string',
                'max:19',
                'unique:sites,ip4G,' . $id
            ],
            'region_id' => 'required|exists:regions,id',
            'type_site_id' => 'required|exists:type_sites,id',
            'bsc_id' => 'required|exists:bscs,id',
            'rnc_id' => 'required|exists:rncs,id',
            'zone_maintenance_id' => 'required|exists:zone_maintenances,id',
            'technologies' => 'nullable|array',
            'technologies.*' => 'exists:technologies,id'
        ];
    }

    // Messages d'erreur personnalisés
    protected function validationMessages()
    {
        return [
            'nom_site.unique' => 'Ce nom de site existe déjà. Veuillez choisir un autre nom.',
            'nom_site.required' => 'Le nom du site est requis.',
            'nom_site.max' => 'Le nom du site ne peut pas dépasser 255 caractères.',
            'cell2G.unique' => 'Cette cellule 2G existe déjà.',
            'cell2G.max' => 'La cellule 2G ne peut pas dépasser 30 caractères.',
            'cell3G.unique' => 'Cette cellule 3G existe déjà.',
            'cell3G.max' => 'La cellule 3G ne peut pas dépasser 30 caractères.',
            'cell4G.unique' => 'Cette cellule 4G existe déjà.',
            'cell4G.max' => 'La cellule 4G ne peut pas dépasser 30 caractères.',
            'nodeName.unique' => 'Ce node name existe déjà.',
            'nodeName.max' => 'Le node name ne peut pas dépasser 30 caractères.',
            'ip3G.unique' => 'Cette IP 3G existe déjà.',
            'ip3G.max' => 'L\'IP 3G ne peut pas dépasser 19 caractères.',
            'ip4G.unique' => 'Cette IP 4G existe déjà.',
            'ip4G.max' => 'L\'IP 4G ne peut pas dépasser 19 caractères.',
            'region_id.required' => 'La région est requise.',
            'region_id.exists' => 'La région sélectionnée est invalide.',
            'type_site_id.required' => 'Le type de site est requis.',
            'type_site_id.exists' => 'Le type de site sélectionné est invalide.',
            'bsc_id.required' => 'Le BSC est requis.',
            'bsc_id.exists' => 'Le BSC sélectionné est invalide.',
            'rnc_id.required' => 'Le RNC est requis.',
            'rnc_id.exists' => 'Le RNC sélectionné est invalide.',
            'zone_maintenance_id.required' => 'La zone de maintenance est requise.',
            'zone_maintenance_id.exists' => 'La zone de maintenance sélectionnée est invalide.',
            'technologies.array' => 'Les technologies doivent être sélectionnées sous forme de liste.',
            'technologies.*.exists' => 'Une ou plusieurs technologies sélectionnées sont invalides.'
        ];
    }
} 