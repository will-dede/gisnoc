<?php

namespace App\Http\Controllers;

use App\Models\Technicien;
use App\Models\ZoneMaintenance;
use Illuminate\Http\Request;

class TechnicienController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'Technicien créé avec succès.';
    const SUCCESS_UPDATE = 'Technicien mis à jour avec succès.';
    const SUCCESS_DELETE = 'Technicien supprimé avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des techniciens
    public function index(Request $request)
    {
        $query = Technicien::with('zoneMaintenance');

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom_tech', 'like', "%{$search}%")
                  ->orWhere('prenom_tech', 'like', "%{$search}%")
                  ->orWhere('tel_tech', 'like', "%{$search}%");
            });
        }

        // Tri alphabétique par défaut
        $query->orderBy('nom_tech')->orderBy('prenom_tech');

        $techniciens = $query->get();

        return view('techniciens.index', compact('techniciens'));
    }

    // Affiche le formulaire de création d'un technicien
    public function create()
    {
        $zones = ZoneMaintenance::all();
        return view('techniciens.create', compact('zones'));
    }

    // Enregistre un nouveau technicien
    public function store(Request $request)
    {
        try {
            $request->validate($this->validationRules());

            Technicien::create($request->all());

            return redirect()->route('techniciens.create')
                ->with('success', self::SUCCESS_CREATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Affiche les détails d'un technicien par ordre alphabétique
    public function show(Technicien $technicien)
    {
        return view('techniciens.show', compact('technicien'));
    }

    // Affiche le formulaire d'édition d'un technicien
    public function edit(Technicien $technicien)
    {
        $zones = ZoneMaintenance::all();
        return view('techniciens.edit', compact('technicien', 'zones'));
    }

    // Met à jour un technicien
    public function update(Request $request, Technicien $technicien)
    {
        try {
            $request->validate($this->validationRules($technicien->id));

            $technicien->update($request->all());

            return redirect()->route('techniciens.index')
                ->with('success', self::SUCCESS_UPDATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Supprime un technicien
    public function destroy(Technicien $technicien)
    {
        try {
            $technicien->delete();

            return redirect()->route('techniciens.index')
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
            'nom_tech' => 'required|string|max:255',
            'prenom_tech' => 'required|string|max:255',
            'tel_tech' => 'required|string|max:20',
            'est_proprietaire' => 'required|boolean',
            'zone_maintenance_id' => 'required|exists:zone_maintenances,id'
        ];
    }
} 