<?php

namespace App\Http\Controllers;

use App\Models\Frequence;
use Illuminate\Http\Request;

class FrequenceController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'Fréquence créée avec succès.';
    const SUCCESS_UPDATE = 'Fréquence mise à jour avec succès.';
    const SUCCESS_DELETE = 'Fréquence supprimée avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des fréquences
    public function index()
    {
        $frequences = Frequence::all();
        // $frequences = Frequence::paginate(10); // Pour la pagination
        return view('frequences.index', compact('frequences'));
    }

    // Affiche le formulaire de création d'une fréquence
    public function create()
    {
        return view('frequences.create');
    }

    // Enregistre une nouvelle fréquence
    public function store(Request $request)
    {
        try {
            $request->validate($this->validationRules());

            Frequence::create($request->all());

            return redirect()->route('frequences.index')
                ->with('success', self::SUCCESS_CREATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Affiche les détails d'une fréquence
    public function show(Frequence $frequence)
    {
        return view('frequences.show', compact('frequence'));
    }

    // Affiche le formulaire d'édition d'une fréquence
    public function edit(Frequence $frequence)
    {
        return view('frequences.edit', compact('frequence'));
    }

    // Met à jour une fréquence
    public function update(Request $request, Frequence $frequence)
    {
        try {
            $request->validate($this->validationRules($frequence->id));

            $frequence->update($request->all());

            return redirect()->route('frequences.index')
                ->with('success', self::SUCCESS_UPDATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Supprime une fréquence
    public function destroy(Frequence $frequence)
    {
        try {
            $frequence->delete();

            return redirect()->route('frequences.index')
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
            'nom_frequence' => 'required|string|max:255|unique:frequences,nom_frequence,' . $id,
            'valeur' => 'required|numeric|min:0',
            'unite' => 'required|string|max:50'
        ];
    }
} 