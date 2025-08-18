<?php

namespace App\Http\Controllers;

use App\Models\TypeSite;
use Illuminate\Http\Request;

class TypeSiteController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'Node type créé avec succès.';
    const SUCCESS_UPDATE = 'Node type mis à jour avec succès.';
    const SUCCESS_DELETE = 'Node type supprimé avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des NodeTypes
    public function index()
    {
        $typesSite = TypeSite::withCount('sites')->get();
        return view('typesite.index', compact('typesSite'));
    }

    // Affiche le formulaire de création d'un Node type
    public function create()
    {
        return view('typesite.create');
    }

    // Enregistre un nouveau Node type
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules(), $this->validationMessages());

        try {
            TypeSite::create($validatedData);
            return redirect()->route('typesite.index')
                ->with('success', self::SUCCESS_CREATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Affiche les détails d'un Node type
    public function show(TypeSite $typesite)
    {
        return view('typesite.show', compact('typesite'));
    }

    // Affiche le formulaire d'édition d'un Node type
    public function edit(TypeSite $typesite)
    {
        return view('typesite.edit', compact('typesite'));
    }

    // Met à jour un Node type
    public function update(Request $request, TypeSite $typesite)
    {
        $validatedData = $request->validate(
            $this->validationRules($typesite->id),
            $this->validationMessages()
        );

        try {
            $typesite->update($validatedData);
            return redirect()->route('typesite.index')
                ->with('success', self::SUCCESS_UPDATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Supprime un Node type
    public function destroy(TypeSite $typesite)
    {
        try {
            $typesite->delete();
            return redirect()->route('typesite.index')
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
            'nom_type_site' => [
                'required',
                'string',
                'max:25',
                'unique:type_sites,nom_type_site,' . $id
            ]
        ];
    }

    // Messages d'erreur personnalisés
    protected function validationMessages()
    {
        return [
            'nom_type_site.unique' => 'Ce Node type existe déjà. Veuillez choisir un autre nom.',
            'nom_type_site.required' => 'Le nom du Node type est requis.',
            'nom_type_site.max' => 'Le nom du Node type ne peut pas dépasser 255 caractères.'
        ];
    }
}
