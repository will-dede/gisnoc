<?php

namespace App\Http\Controllers;

use App\Models\Secteur;
use App\Models\Region;
use App\Models\Frequence;
use Illuminate\Http\Request;

class SecteurController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'Secteur créé avec succès.';
    const SUCCESS_UPDATE = 'Secteur mis à jour avec succès.';
    const SUCCESS_DELETE = 'Secteur supprimé avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des secteurs
    public function index()
    {
        $secteurs = Secteur::with('region')->get();
        // $secteurs = Secteur::with('region')->paginate(10); // Pour la pagination
        return view('secteurs.index', compact('secteurs'));
    }

    // Affiche le formulaire de création d'un secteur
    public function create()
    {
        $frequences = Frequence::with('technologies')->orderBy('nom_freq', 'asc')->get();
        $regions = Region::orderBy('nom_region', 'asc')->get();
        // $regions = Region::all();
        return view('secteurs.create', compact('regions'));
    }

    // Enregistre un nouveau secteur
    public function store(Request $request)
    {
        try {
            $request->validate($this->validationRules());

            Secteur::create($request->all());

            return redirect()->route('secteurs.index')
                ->with('success', self::SUCCESS_CREATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Affiche les détails d'un secteur
    public function show(Secteur $secteur)
    {
        return view('secteurs.show', compact('secteur'));
    }

    // Affiche le formulaire d'édition d'un secteur
    public function edit(Secteur $secteur)
    {
        $regions = Region::all();
        return view('secteurs.edit', compact('secteur', 'regions'));
    }

    // Met à jour un secteur
    public function update(Request $request, Secteur $secteur)
    {
        try {
            $request->validate($this->validationRules($secteur->id));

            $secteur->update($request->all());

            return redirect()->route('secteurs.index')
                ->with('success', self::SUCCESS_UPDATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Supprime un secteur
    public function destroy(Secteur $secteur)
    {
        try {
            $secteur->delete();

            return redirect()->route('secteurs.index')
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
            'nom_secteur' => 'required|string|max:255|unique:secteurs,nom_secteur,' . $id,
            'region_id' => 'required|exists:regions,id'
        ];
    }
} 