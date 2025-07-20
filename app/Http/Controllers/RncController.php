<?php

namespace App\Http\Controllers;

use App\Models\Rnc;
use Illuminate\Http\Request;

class RncController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'RNC créée avec succès.';
    const SUCCESS_UPDATE = 'RNC mise à jour avec succès.';
    const SUCCESS_DELETE = 'RNC supprimée avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des RNC
    public function index(Request $request)
    {
        $query = Rnc::query();

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nom_rnc', 'like', "%{$search}%");
        }

        // Tri alphabétique par défaut
        $query->orderBy('nom_rnc');

        $rncs = $query->get();
        return view('rncs.index', compact('rncs'));
    }

    // Affiche le formulaire de création d'une RNC
    public function create()
    {
        return view('rncs.create');
    }

    // Enregistre une nouvelle RNC
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules(), $this->validationMessages());
        
        try {
            Rnc::create($validatedData);
            return redirect()->route('rncs.create')->with('success', 'RNC créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création du RNC.')->withInput();
        }
    }

    // Affiche les détails d'une RNC
    public function show(Rnc $rnc)
    {
        return view('rncs.show', compact('rnc'));
    }

    // Affiche le formulaire d'édition d'une RNC
    public function edit(Rnc $rnc)
    {
        return view('rncs.edit', compact('rnc'));
    }

    // Met à jour une RNC
    public function update(Request $request, Rnc $rnc)
    {
        $validatedData = $request->validate($this->validationRules($rnc->id), $this->validationMessages());
        
        try {
            $rnc->update($validatedData);
            return redirect()->route('rncs.index')->with('success', 'RNC mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour du RNC.')->withInput();
        }
    }

    // Supprime une RNC
    public function destroy(Rnc $rnc)
    {
        try {
            $rnc->delete();

            return redirect()->route('rncs.index')
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
            'nom_rnc' => [
                'required',
                'string',
                'max:50',
                'unique:rncs,nom_rnc,' . $id
            ]
        ];
    }

    // Messages de validation personnalisés
    protected function validationMessages()
    {
        return [
            'nom_rnc.unique' => 'Ce RNC existe déjà. Veuillez choisir un autre nom.',
            'nom_rnc.required' => 'Le nom du RNC est requis.',
            'nom_rnc.max' => 'Le nom du RNC ne peut pas dépasser 50 caractères.'
        ];
    }
} 