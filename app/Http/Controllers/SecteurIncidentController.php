<?php

namespace App\Http\Controllers;

use App\Models\Secteur;
use App\Models\Incident;
use Illuminate\Http\Request;

class SecteurIncidentController extends Controller
{
    // Messages de succès
    const SUCCESS_ATTACH = 'Secteur attaché à l\'incident avec succès.';
    const SUCCESS_DETACH = 'Secteur détaché de l\'incident avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des secteurs d'un incident
    public function index(Incident $incident)
    {
        $secteurs = $incident->secteurs;
        return view('secteur-incidents.index', compact('incident', 'secteurs'));
    }

    // Affiche le formulaire d'ajout de secteurs à un incident
    public function create(Incident $incident)
    {
        $secteurs = Secteur::whereNotIn('id', $incident->secteurs->pluck('id'))->get();
        return view('secteur-incidents.create', compact('incident', 'secteurs'));
    }

    // Attache un secteur à un incident
    public function store(Request $request, Incident $incident)
    {
        try {
            $request->validate([
                'secteur_id' => 'required|exists:secteurs,id'
            ]);

            $incident->secteurs()->attach($request->secteur_id);

            return redirect()->route('incidents.show', $incident)
                ->with('success', self::SUCCESS_ATTACH);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Détache un secteur d'un incident
    public function destroy(Incident $incident, Secteur $secteur)
    {
        try {
            $incident->secteurs()->detach($secteur->id);

            return redirect()->route('incidents.show', $incident)
                ->with('success', self::SUCCESS_DETACH);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }
} 