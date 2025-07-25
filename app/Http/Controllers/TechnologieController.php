<?php

namespace App\Http\Controllers;

use App\Models\Technologie;
use Illuminate\Http\Request;

class TechnologieController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'Technologie créée avec succès.';
    const SUCCESS_UPDATE = 'Technologie mise à jour avec succès.';
    const SUCCESS_DELETE = 'Technologie supprimée avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des technologies
    public function index()
    {
        $technologies = Technologie::withCount(['sites', 'frequences'])->get();
        return view('technologies.index', compact('technologies'));
    }

    // Affiche le formulaire de création d'une technologie
    public function create()
    {
        return view('technologies.create');
    }

    // Enregistre une nouvelle technologie
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules(), $this->validationMessages());
        
        try {
            Technologie::create($validatedData);
            return redirect()->route('technologie.index')
                ->with('success', self::SUCCESS_CREATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Affiche les détails d'une technologie
    public function show(Technologie $technologie)
    {
        return view('technologies.show', compact('technologie'));
    }

    // Affiche le formulaire d'édition d'une technologie
    public function edit(Technologie $technologie)
    {
        return view('technologies.edit', compact('technologie'));
    }

    // Met à jour une technologie
    public function update(Request $request, Technologie $technologie)
    {
        $validatedData = $request->validate(
            $this->validationRules($technologie->id),
            $this->validationMessages()
        );
        
        try {
            $technologie->update($validatedData);
            return redirect()->route('technologie.index')
                ->with('success', self::SUCCESS_UPDATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Supprime une technologie
    public function destroy(Technologie $technologie)
    {
        try {
            $technologie->delete();
            return redirect()->route('technologie.index')
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
            'nom_technologie' => [
                'required',
                'string',
                'max:15',
                'unique:technologies,nom_technologie,' . $id
            ]
        ];
    }

    // Messages d'erreur personnalisés
    protected function validationMessages()
    {
        return [
            'nom_technologie.unique' => 'Cette technologie existe déjà. Veuillez choisir un autre nom.',
            'nom_technologie.required' => 'Le nom de la technologie est requis.',
            'nom_technologie.max' => 'Le nom de la technologie ne peut pas dépasser 15 caractères.'
        ];
    }
} 