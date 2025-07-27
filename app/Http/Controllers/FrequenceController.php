<?php

namespace App\Http\Controllers;

use App\Models\Frequence;
use App\Models\Technologie;
use Illuminate\Http\Request;

class FrequenceController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'Fréquence créée avec succès.';
    const SUCCESS_UPDATE = 'Fréquence mise à jour avec succès.';
    const SUCCESS_DELETE = 'Fréquence supprimée avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Liste des fréquences
    public function index()
    {
        $frequences = Frequence::with('technologie')
            ->join('technologies', 'frequences.technologie_id', '=', 'technologies.id')
            ->orderBy('technologies.nom_technologie')
            ->orderBy('frequences.nom_freq')
            ->select('frequences.*')
            ->get();
        return view('frequences.index', compact('frequences'));
    }

    // Formulaire de création
    public function create()
    {
        $technologies = Technologie::orderBy('nom_technologie')->get();
        return view('frequences.create', compact('technologies'));
    }

    // Enregistrement
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());
        try {
            Frequence::create($validated);
            return redirect()->route('frequences.index')->with('success', self::SUCCESS_CREATE);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', self::ERROR_GENERAL . $e->getMessage())->withInput();
        }
    }

    // Affichage d'une fréquence
    public function show(Frequence $frequence)
    {
        $frequence->load('technologie');
        return view('frequences.show', compact('frequence'));
    }

    // Formulaire d'édition
    public function edit(Frequence $frequence)
    {
        $technologies = Technologie::orderBy('nom_technologie')->get();
        return view('frequences.edit', compact('frequence', 'technologies'));
    }

    // Mise à jour
    public function update(Request $request, Frequence $frequence)
    {
        $validated = $request->validate($this->validationRules($frequence->id), $this->validationMessages());
        try {
            $frequence->update($validated);
            return redirect()->route('frequences.index')->with('success', self::SUCCESS_UPDATE);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', self::ERROR_GENERAL . $e->getMessage())->withInput();
        }
    }

    // Suppression
    public function destroy(Frequence $frequence)
    {
        try {
            $frequence->delete();
            return redirect()->route('frequences.index')->with('success', self::SUCCESS_DELETE);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Règles de validation
    protected function validationRules($id = null)
    {
        return [
            'nom_freq' => ['required', 'string', 'max:255', 'unique:frequences,nom_freq,' . $id],
            'technologie_id' => ['required', 'exists:technologies,id'],
        ];
    }

    // Messages personnalisés
    protected function validationMessages()
    {
        return [
            'nom_freq.required' => 'Le nom de la fréquence est requis.',
            'nom_freq.unique' => 'Ce nom de fréquence existe déjà.',
            'nom_freq.max' => 'Le nom de la fréquence ne peut pas dépasser 255 caractères.',
            'technologie_id.required' => 'La technologie est requise.',
            'technologie_id.exists' => 'La technologie sélectionnée est invalide.',
        ];
    }
}
