<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\TypeAlarme;
use App\Models\Site;
use App\Models\Technologie;
use App\Models\Technicien;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'Incident ajouté avec succès !';
    const SUCCESS_UPDATE = 'Incident mis à jour avec succès !';
    const SUCCESS_DELETE = 'Incident supprimé avec succès !';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des incidents
    public function index(Request $request)
    {
        $query = Incident::with(['typeAlarme', 'sites', 'technicien', 'secteurs', 'site']);

        // Recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('site', function($siteQuery) use ($search) {
                    $siteQuery->where('nom_site', 'like', "%{$search}%");
                })
                ->orWhere('causes_incident', 'like', "%{$search}%")
                ->orWhere('actions_effectuees', 'like', "%{$search}%");
            });
        }

        // Tri
        $sort = $request->get('sort', 'date_debut');
        $direction = $request->get('direction', 'desc');

        switch ($sort) {
            case 'site':
                $query->join('sites', 'incidents.site_id', '=', 'sites.id')
                      ->orderBy('sites.nom_site', $direction)
                      ->select('incidents.*');
                break;
            case 'type_alarme':
                $query->join('type_alarmes', 'incidents.type_alarme_id', '=', 'type_alarmes.id')
                      ->orderBy('type_alarmes.nom_type_alarme', $direction)
                      ->select('incidents.*');
                break;
            case 'technicien':
                $query->join('techniciens', 'incidents.technicien_id', '=', 'techniciens.id')
                      ->orderBy('techniciens.nom_tech', $direction)
                      ->select('incidents.*');
                break;
            case 'date_debut':
                $query->orderBy('date_debut_incident', $direction);
                break;
            case 'date_fin':
                $query->orderBy('date_fin_incident', $direction);
                break;
            default:
                $query->orderBy('date_debut_incident', 'desc');
        }

        $incidents = $query->get();
        
        return view('incidents.index', compact('incidents'));
    }

    // Affiche le formulaire de création d'un incident
    public function create()
    {
        $typesAlarme = TypeAlarme::all();
        $techniciens = Technicien::orderBy('nom_tech', 'asc', 'prenom_tech', 'asc')->get();
        $sites = Site::with('technologies')->orderBy('nom_site', 'asc')->get();
        $arbreTechnosFreqSecteurs = \App\Models\Technologie::with(['frequences.secteurs'])->get()->mapWithKeys(function($tech) {
            return [
                $tech->id => [
                    'id' => $tech->id,
                    'nom' => $tech->nom_technologie,
                    'frequences' => $tech->frequences->mapWithKeys(function($freq) {
                        return [
                            $freq->id => [
                                'id' => $freq->id,
                                'nom' => $freq->nom_freq,
                                'secteurs' => $freq->secteurs->map(function($secteur) {
                                    return [
                                        'id' => $secteur->id,
                                        'nom' => $secteur->nom_secteur
                                    ];
                                })->toArray()
                            ]
                        ];
                    })->toArray()
                ]
            ];
        })->toArray();
        return view('incidents.create', compact('typesAlarme', 'techniciens', 'sites', 'arbreTechnosFreqSecteurs'));
    }

    // Enregistre un nouvel incident
    public function store(Request $request)
    {
        try {
            // Validation des champs de l'incident principal
            $validatedData = $request->validate([
                'site_id' => 'required|exists:sites,id', // Site principal
                'type_alarme_id' => 'required|exists:type_alarmes,id',
                'technicien_id' => 'required|exists:techniciens,id',
                'date_debut_incident' => 'required|date',
                'date_fin_incident' => 'nullable|date|after_or_equal:date_debut_incident',
                'date_contact_technicien' => 'nullable|date',
                'date_arrivee_sur_site' => 'nullable|date',
                'intervenant' => 'nullable|string|max:50',
                'causes_incident' => 'nullable|string',
                'actions_effectuees' => 'nullable|string',
                'observation' => 'nullable|string',
                'notes' => 'nullable|string',
                // Validation des sites impactés (table pivot)
                'sites_impactes' => 'nullable|array', // tableau d'ids de sites impactés
                'sites_impactes.*.site_id' => 'required|exists:sites,id',
                'sites_impactes.*.date_debut_incident' => 'nullable|date',
                'sites_impactes.*.date_fin_incident' => 'nullable|date|after_or_equal:sites_impactes.*.date_debut_incident',
                'sites_impactes.*.date_arrivee_sur_site' => 'nullable|date',
                'sites_impactes.*.intervenant' => 'nullable|string|max:50',
                'sites_impactes.*.causes_incident' => 'nullable|string',
                'sites_impactes.*.actions_effectuees' => 'nullable|string',
                'sites_impactes.*.observation' => 'nullable|string',
                'sites_impactes.*.notes' => 'nullable|string',
                'sites_impactes.*.technicien_id' => 'nullable|exists:techniciens,id',
                'sites_impactes.*.type_alarme_id' => 'nullable|exists:type_alarmes,id',
            ]);

            // Création de l'incident principal
            $incident = Incident::create($validatedData);

            // Attacher les sites impactés avec toutes les infos de la table pivot
            if ($request->has('sites_impactes')) {
                $pivotData = [];
                foreach ($request->sites_impactes as $pivot) {
                    $pivotData[$pivot['site_id']] = [
                        'date_debut_incident' => $pivot['date_debut_incident'] ?? null,
                        'date_fin_incident' => $pivot['date_fin_incident'] ?? null,
                        'date_arrivee_sur_site' => $pivot['date_arrivee_sur_site'] ?? null,
                        'intervenant' => $pivot['intervenant'] ?? null,
                        'causes_incident' => $pivot['causes_incident'] ?? null,
                        'actions_effectuees' => $pivot['actions_effectuees'] ?? null,
                        'observation' => $pivot['observation'] ?? null,
                        'notes' => $pivot['notes'] ?? null,
                        'technicien_id' => $pivot['technicien_id'] ?? null,
                        'type_alarme_id' => $pivot['type_alarme_id'] ?? null,
                    ];
                }
                $incident->sites()->sync($pivotData);
            }

            // Attacher les secteurs sélectionnés
            if ($request->has('secteurs')) {
                $incident->secteurs()->sync($request->secteurs);
            }

            return redirect()->route('incidents.index')
                ->with('success', self::SUCCESS_CREATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Affiche les détails d'un incident
    public function show(Incident $incident)
    {
        return view('incidents.show', compact('incident'));
    }

    // Affiche le formulaire d'édition d'un incident
    public function edit(Incident $incident)
    {
        $typesAlarme = TypeAlarme::all();
        $techniciens = Technicien::all();
        $sites = Site::with(['technologies', 'zoneMaintenance'])->orderBy('nom_site', 'asc')->get();
        $incident->load(['sites', 'site.technologies']);
        return view('incidents.edit', compact('incident', 'typesAlarme', 'techniciens', 'sites'));
    }

    // Met à jour un incident
    public function update(Request $request, Incident $incident)
    {
        try {
            $request->validate($this->validationRules($incident->id));

            $incident->update($request->all());

            return redirect()->route('incidents.show')
                ->with('success', self::SUCCESS_UPDATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Supprime un incident
    public function destroy(Incident $incident)
    {
        try {
            $incident->delete();

            return redirect()->route('incidents.index')
                ->with('success', self::SUCCESS_DELETE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Règles de validation
    protected function validationRules($id = null)
    {
        return [
            'type_alarme_id' => 'required|exists:type_alarmes,id',
            'technicien_id' => 'nullable|exists:techniciens,id',
            'date_debut_incident' => 'required|date',
            'date_fin_incident' => 'nullable|date|after_or_equal:date_debut_incident',
            'observation' => 'nullable|string',
            'notes' => 'nullable|string'
        ];
    }
} 