<?php

namespace App\Http\Controllers;

use App\Models\Mecanicien;
use App\Models\ZoneMaintenance;
use Illuminate\Http\Request;

class MecanicienController extends Controller
{
    // Messages de succès
    const SUCCESS_CREATE = 'Mecanicien créé avec succès.';
    const SUCCESS_UPDATE = 'Mecanicien mis à jour avec succès.';
    const SUCCESS_DELETE = 'Mecanicien supprimé avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des mécaniciens
    public function index(Request $request)
    {
        $query = Mecanicien::with('zoneMaintenance');

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom_mecano', 'like', "%{$search}%")
                  ->orWhere('prenom_mecano', 'like', "%{$search}%")
                  ->orWhere('tel_mecano', 'like', "%{$search}%");
            });
        }

        // Tri alphabétique par défaut
        $query->orderBy('nom_mecano')->orderBy('prenom_mecano');

        $mecaniciens = $query->get();

        return view('mecaniciens.index', compact('mecaniciens'));
    }

    // Affiche le formulaire de création d'un mecanicien
    public function create()
    {
        $zones = ZoneMaintenance::all();
        return view('mecaniciens.create', compact('zones'));
    }

    // Enregistre un nouveau mecanicien
    public function store(Request $request)
    {
        try {
            $request->validate($this->validationRules());

            Mecanicien::create($request->all());

            return redirect()->route('mecaniciens.create')
                ->with('success', self::SUCCESS_CREATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Affiche les détails d'un mecanicien par ordre alphabétique
    public function show(Mecanicien $mecanicien)
    {
        return view('mecaniciens.show', compact('mecanicien'));
    }

    // Affiche le formulaire d'édition d'un mecanicien
    public function edit(Mecanicien $mecanicien)
    {
        $zones = ZoneMaintenance::all();
        return view('mecaniciens.edit', compact('mecanicien', 'zones'));
    }

    // Met à jour un mecanicien
    public function update(Request $request, Mecanicien $mecanicien)
    {
        try {
            $request->validate($this->validationRules($mecanicien->id));

            $mecanicien->update($request->all());

            return redirect()->route('mecaniciens.index')
                ->with('success', self::SUCCESS_UPDATE);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Supprime un mecanicien
    public function destroy(Mecanicien $mecanicien)
    {
        try {
            $mecanicien->delete();

            return redirect()->route('mecaniciens.index')
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
            'nom_mecano' => 'required|string|max:255',
            'prenom_mecano' => 'required|string|max:255',
            'tel_mecano' => 'required|string|max:20',
            'est_proprietaire' => 'required|boolean',
            'zone_maintenance_id' => 'required|exists:zone_maintenances,id'
        ];
    }
} 