<?php

namespace App\Http\Controllers;

use App\Models\TypeAlarme;
use Illuminate\Http\Request;

class TypeAlarmeController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'type d\'alarme créé avec succès.';
    const SUCCESS_UPDATE = 'type d\'alarme mis à jour avec succès.';
    const SUCCESS_DELETE = 'type d\'alarme supprimé avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des types de alarmes
    public function index()
    {
        $typesAlarme = TypeAlarme::withCount('incidents')->get();
        return view('typealarme.index', compact('typesAlarme'));
    }

    // Affiche le formulaire de création d'un type d'alarme
    public function create()
    {
        return view('typealarme.create');
    }

    // Enregistre un nouveau type d'alarme
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

    // Affiche les détails d'un type d'alarme
    public function show(TypeAlarme $types_alarme)
    {
        return view('typealarme.show', compact('types_alarme'));
    }

    // Affiche le formulaire d'édition d'un type d'alarme
    public function edit(TypeAlarme $types_alarme)
    {
        return view('typealarme.edit', compact('types_alarme'));
    }

    // Met à jour un type d'alarme
    public function update(Request $request, TypeAlarme $types_alarme)
    {
        $validatedData = $request->validate(
            $this->validationRules($types_alarme->id),
            $this->validationMessages()
        );

        try {
            $types_alarme->update($validatedData);
            return redirect()->route('typealarme.index')
                ->with('success', self::SUCCESS_UPDATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Supprime un type d'alarme
    public function destroy(TypeAlarme $types_alarme)
    {
        try {
            $types_alarme->delete();
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
                'max:100'
            ]
        ];
    }

    // Messages d'erreur personnalisés
    protected function validationMessages()
    {
        return [
            'nom_type_alarme.unique' => 'Ce type d\'alarme existe déjà. Veuillez choisir un autre nom.',
            'nom_type_alarme.required' => 'Le nom du type d\'alarme est requis.',
            'nom_type_alarme.max' => 'Le nom du type d\'alarme ne peut pas dépasser 25 caractères.',
            'descr_type_alarme.max' => 'La description ne peut pas dépasser 100 caractères.'
        ];
    }
}
