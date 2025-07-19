<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Incident;
use Illuminate\Http\Request;

class SiteIncidentController extends Controller
{
    // Messages de succès
    const SUCCESS_ATTACH = 'Site attaché à l\'incident avec succès.';
    const SUCCESS_DETACH = 'Site détaché de l\'incident avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des sites d'un incident
    public function index(Incident $incident)
    {
        $sites = $incident->sites;
        return view('site-incidents.index', compact('incident', 'sites'));
    }

    // Affiche le formulaire d'ajout de sites à un incident
    public function create(Incident $incident)
    {
        $sites = Site::whereNotIn('id', $incident->sites->pluck('id'))->get();
        return view('site-incidents.create', compact('incident', 'sites'));
    }

    // Attache un site à un incident
    public function store(Request $request, Incident $incident)
    {
        try {
            $request->validate([
                'site_id' => 'required|exists:sites,id',
                'is_hub' => 'boolean'
            ]);

            // Si c'est un site hub, on s'assure qu'il n'y en a pas déjà un
            if ($request->is_hub) {
                $incident->sites()->updateExistingPivot($incident->sites->pluck('id'), ['is_hub' => false]);
            }

            $incident->sites()->attach($request->site_id, ['is_hub' => $request->is_hub ?? false]);

            return redirect()->route('incidents.show', $incident)
                ->with('success', self::SUCCESS_ATTACH);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Détache un site d'un incident
    public function destroy(Incident $incident, Site $site)
    {
        try {
            $incident->sites()->detach($site->id);

            return redirect()->route('incidents.show', $incident)
                ->with('success', self::SUCCESS_DETACH);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }
} 