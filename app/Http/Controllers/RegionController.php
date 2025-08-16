<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'Région créée avec succès.';
    const SUCCESS_UPDATE = 'Région mise à jour avec succès.';
    const SUCCESS_DELETE = 'Région supprimée avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des régions
    public function index()
    {
        $regions = Region::all();
        // $regions = Region::paginate(10); // Pour la pagination
        return view('regions.index', compact('regions'));
    }

    // Affiche le formulaire de création d'une région
    public function create()
    {
        return view('regions.create');
    }

    // Enregistre une nouvelle région
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules(), $this->validationMessages());
        
        try {
            Region::create($validatedData);
            return redirect()->route('regions.index')->with('success', 'Région créée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création de la région.')->withInput();
        }
    }

    // Affiche les détails d'une région
    public function show(Region $region)
    {
        $region->load(['sites' => function ($query){
            $query->orderBy('nom_site');
        }]);
        return view('regions.show', compact('region'));
    }

    // Affiche le formulaire d'édition d'une région
    public function edit(Region $region)
    {
        return view('regions.edit', compact('region'));
    }

    // Met à jour une région
    public function update(Request $request, Region $region)
    {
        $validatedData = $request->validate($this->validationRules($region->id), $this->validationMessages());
        
        try {
            $region->update($validatedData);
            return redirect()->route('regions.index')->with('success', 'Région mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour de la région.')->withInput();
        }
    }

    // Supprime une région
    public function destroy(Region $region)
    {
        try {
            $region->delete();

            return redirect()->route('regions.index')
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
            'nom_region' => [
                'required',
                'string',
                'max:50',
                'unique:regions,nom_region,' . $id
            ]
        ];
    }

    // Messages de validation personnalisés
    protected function validationMessages()
    {
        return [
            'nom_region.unique' => 'Cette région existe déjà. Veuillez choisir un autre nom.',
            'nom_region.required' => 'Le nom de la région est requis.',
            'nom_region.max' => 'Le nom de la région ne peut pas dépasser 50 caractères.'
        ];
    }
} 