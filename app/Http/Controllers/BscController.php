<?php

namespace App\Http\Controllers;

use App\Models\Bsc;
use Illuminate\Http\Request;

class BscController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'BSC créée avec succès.';
    const SUCCESS_UPDATE = 'BSC mise à jour avec succès.';
    const SUCCESS_DELETE = 'BSC supprimée avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des BSC
    public function index(Request $request)
    {
        $query = Bsc::query();

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nom_bsc', 'like', "%{$search}%");
        }

        // Tri alphabétique par défaut
        $query->orderBy('nom_bsc');

        $bscs = $query->get();
        return view('bscs.index', compact('bscs'));
    }

    // Affiche le formulaire de création d'une BSC
    public function create()
    {
        return view('bscs.create');
    }

    // Enregistre une nouvelle BSC
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules(), $this->validationMessages());
        
        try {
            Bsc::create($validatedData);
            return redirect()->route('bscs.index')->with('success', 'BSC créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création du BSC.')->withInput();
        }
    }

    // Affiche les détails d'une BSC
    public function show(Bsc $bsc)
    {
        $bsc->load(['sites' => function ($query){
            $query->orderBy('nom_site');
        }]);
        return view('bscs.show', compact('bsc'));
    }

    // Affiche le formulaire d'édition d'une BSC
    public function edit(Bsc $bsc)
    {
        return view('bscs.edit', compact('bsc'));
    }

    // Met à jour une BSC
    public function update(Request $request, Bsc $bsc)
    {
        $validatedData = $request->validate($this->validationRules($bsc->id), $this->validationMessages());
        
        try {
            $bsc->update($validatedData);
            return redirect()->route('bscs.index')->with('success', 'BSC mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour du BSC.')->withInput();
        }
    }

    // Supprime une BSC
    public function destroy(Bsc $bsc)
    {
        try {
            $bsc->delete();

            return redirect()->route('bscs.index')
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
            'nom_bsc' => [
                'required',
                'string',
                'max:50',
                'unique:bscs,nom_bsc,' . $id
            ]
        ];
    }

    // Messages de validation personnalisés
    protected function validationMessages()
    {
        return [
            'nom_bsc.unique' => 'Ce BSC existe déjà. Veuillez choisir un autre nom.',
            'nom_bsc.required' => 'Le nom du BSC est requis.',
            'nom_bsc.max' => 'Le nom du BSC ne peut pas dépasser 50 caractères.'
        ];
    }
} 