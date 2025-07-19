<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Technologie;
use Illuminate\Http\Request;

class SiteTechnologieController extends Controller
{
    // Messages de succès
    const SUCCESS_ATTACH = 'Technologie attachée au site avec succès.';
    const SUCCESS_DETACH = 'Technologie détachée du site avec succès.';
    const ERROR_GENERAL = 'Une erreur est survenue : ';

    // Affiche la liste des technologies d'un site
    public function index(Site $site)
    {
        $technologies = $site->technologies;
        return view('site-technologies.index', compact('site', 'technologies'));
    }

    // Affiche le formulaire d'ajout de technologies à un site
    public function create(Site $site)
    {
        $technologies = Technologie::whereNotIn('id', $site->technologies->pluck('id'))->get();
        return view('site-technologies.create', compact('site', 'technologies'));
    }

    // Attache une technologie à un site
    public function store(Request $request, Site $site)
    {
        try {
            $request->validate([
                'technologie_id' => 'required|exists:technologies,id'
            ]);

            $site->technologies()->attach($request->technologie_id);

            return redirect()->route('sites.show', $site)
                ->with('success', self::SUCCESS_ATTACH);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }

    // Détache une technologie d'un site
    public function destroy(Site $site, Technologie $technologie)
    {
        try {
            $site->technologies()->detach($technologie->id);

            return redirect()->route('sites.show', $site)
                ->with('success', self::SUCCESS_DETACH);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', self::ERROR_GENERAL . $e->getMessage());
        }
    }
} 