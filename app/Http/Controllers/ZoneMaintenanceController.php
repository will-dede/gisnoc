<?php

namespace App\Http\Controllers;

use App\Models\ZoneMaintenance;
use Illuminate\Http\Request;

class ZoneMaintenanceController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'Zone de maintenance créée avec succès.';
    const SUCCESS_UPDATE = 'Zone de maintenance mise à jour avec succès.';
    const SUCCESS_DELETE = 'Zone de maintenance supprimée avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des zones de maintenance
    public function index()
    {
        $zonemaintenance = ZoneMaintenance::withCount('sites')->get();
        // $zonemaintenance = ZoneMaintenance::paginate(10); // Pour la pagination
        return view('zonemaintenance.index', compact('zonemaintenance'));
    }

    // Affiche le formulaire de création d'une zone de maintenance
    public function create()
    {
        return view('zonemaintenance.create');
    }

    // Enregistre une nouvelle zone de maintenance
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules(), $this->validationMessages());
        
        try {
            ZoneMaintenance::create($validatedData);
            return redirect()->route('zonemaintenance.index')
                ->with('success', self::SUCCESS_CREATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Affiche les détails d'une zone de maintenance
    public function show(ZoneMaintenance $zonemaintenance)
    {
        return view('zonemaintenance.show', compact('zonemaintenance'));
    }

    // Affiche le formulaire d'édition d'une zone de maintenance
    public function edit(ZoneMaintenance $zonemaintenance)
    {
        return view('zonemaintenance.edit', compact('zonemaintenance'));
    }

    // Met à jour une zone de maintenance
    public function update(Request $request, ZoneMaintenance $zonemaintenance)
    {
        $validatedData = $request->validate(
            $this->validationRules($zonemaintenance->id),
            $this->validationMessages()
        );
        
        try {
            $zonemaintenance->update($validatedData);
            return redirect()->route('zonemaintenance.index')
                ->with('success', self::SUCCESS_UPDATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Supprime une zone de maintenance
    public function destroy(ZoneMaintenance $zonemaintenance)
    {
        try {
            $zonemaintenance->delete();
            return redirect()->route('zonemaintenance.index')
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
            'nom_zone' => [
                'required',
                'string',
                'max:255',
                'unique:zone_maintenances,nom_zone,' . $id
            ],
            'description' => 'nullable|string'
        ];
    }

    // Messages d'erreur personnalisés
    protected function validationMessages()
    {
        return [
            'nom_zone.unique' => 'Cette zone de maintenance existe déjà. Veuillez choisir un autre nom.',
            'nom_zone.required' => 'Le nom de la zone de maintenance est requis.',
            'nom_zone.max' => 'Le nom de la zone de maintenance ne peut pas dépasser 255 caractères.',
            'description.string' => 'La description doit être une chaîne de caractères.'
        ];
    }
}
