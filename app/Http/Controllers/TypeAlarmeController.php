<?php

namespace App\Http\Controllers;

use App\Models\TypeAlarme;
use Illuminate\Http\Request;

class TypeAlarmeController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'Alarme créée avec succès.';
    const SUCCESS_UPDATE = 'Alarme mise à jour avec succès.';
    const SUCCESS_DELETE = 'Alarme supprimée avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des types d'alarmes
    public function index()
    {
        $typesAlarme = TypeAlarme::withCount('incidents')
            ->orderBy('nom_type_alarme')
            ->orderBy('descr_type_alarme')
            ->get();
        return view('typealarme.index', compact('typesAlarme'));
    }

    // Affiche le formulaire de création d'un Alarme
    public function create()
    {
        return view('typealarme.create');
    }

    // Enregistre un nouveau Alarme
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules(), $this->validationMessages());

        try {
            TypeAlarme::create($validatedData);
            return redirect()->route('typealarme.index')
                ->with('success', self::SUCCESS_CREATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Affiche les détails d'un Alarme
    public function show(TypeAlarme $typealarme)
    {
        return view('typealarme.show', compact('typealarme'));
    }

    // Affiche le formulaire d'édition d'un Alarme
    public function edit(TypeAlarme $typealarme)
    {
        return view('typealarme.edit', compact('typealarme'));
    }

    // Met à jour un Alarme
    public function update(Request $request, TypeAlarme $typealarme)
    {
        $validatedData = $request->validate(
            $this->validationRules($typealarme->id),
            $this->validationMessages()
        );

        try {
            $typealarme->update($validatedData);
            return redirect()->route('typealarme.index')
                ->with('success', self::SUCCESS_UPDATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Supprime un Alarme
    public function destroy(TypeAlarme $typealarme)
    {
        try {
            $typealarme->delete();
            return redirect()->route('typealarme.index')
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
            'nom_type_alarme' => [
                'required',
                'string',
                'max:25',
                'unique:type_alarmes,nom_type_alarme,' . $id
            ],
            'descr_type_alarme' => [
                'nullable',
                'string',
                'max:255'
            ]
        ];
    }

    // Messages d'erreur personnalisés
    protected function validationMessages()
    {
        return [
            'nom_type_alarme.unique' => 'Ce Alarme existe déjà. Veuillez choisir un autre nom.',
            'nom_type_alarme.required' => 'Le nom du Alarme est requis.',
            'nom_type_alarme.max' => 'Le nom du Alarme ne peut pas dépasser 255 caractères.'
        ];
    }
}
