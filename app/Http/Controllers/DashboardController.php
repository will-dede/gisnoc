<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\TypeAlarme;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfCurrentMonth = $now->copy()->startOfMonth();
        $endOfCurrentMonth = $now->copy()->endOfMonth();
        $startOfPrevMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfPrevMonth = $now->copy()->subMonth()->endOfMonth();

        // Charger tous les incidents avec relations
        $allIncidents = Incident::with(['typeAlarme', 'secteurs.frequence.technologie', 'site'])->get();
        $typeAlarmes = TypeAlarme::all();

        // === MÉTRIQUES GLOBALES ===
        
        // Mois précédent
        $prevMonthIncidents = $allIncidents->filter(fn($i) => 
            Carbon::parse($i->date_debut_incident)->between($startOfPrevMonth, $endOfPrevMonth)
        );
        $prevMonthTotal = $prevMonthIncidents->count();
        $prevMonthOpen = $prevMonthIncidents->whereNull('date_fin_incident')->count();
        $prevMonthClosed = $prevMonthIncidents->whereNotNull('date_fin_incident')->count();

        // Mois en cours
        $currentMonthIncidents = $allIncidents->filter(fn($i) => 
            Carbon::parse($i->date_debut_incident)->between($startOfCurrentMonth, $endOfCurrentMonth)
        );
        $currentMonthTotal = $currentMonthIncidents->count();
        $currentMonthOpen = $currentMonthIncidents->whereNull('date_fin_incident')->count();
        $currentMonthClosed = $currentMonthIncidents->whereNotNull('date_fin_incident')->count();

        // Cumulé (tous les mois)
        $cumulTotal = $allIncidents->count();
        $cumulOpen = $allIncidents->whereNull('date_fin_incident')->count();
        $cumulClosed = $allIncidents->whereNotNull('date_fin_incident')->count();

        // === MÉTRIQUES PAR TYPE D'ALARME ===
        
        $typeAlarmeMetrics = $typeAlarmes->mapWithKeys(function ($type) use ($allIncidents, $currentMonthIncidents, $prevMonthIncidents, $now) {
            $typeIncidents = $allIncidents->where('type_alarme_id', $type->id);
            $typeCurrentMonth = $currentMonthIncidents->where('type_alarme_id', $type->id);
            $typePrevMonth = $prevMonthIncidents->where('type_alarme_id', $type->id);

            // Calcul durées (en minutes)
            $calculateDuration = function ($incidents) use ($now) {
                return $incidents->sum(function ($incident) use ($now) {
                    $end = $incident->date_fin_incident ? Carbon::parse($incident->date_fin_incident) : $now;
                    return Carbon::parse($incident->date_debut_incident)->diffInMinutes($end);
                });
            };

            return [$type->nom_type => [
                'current_month_count' => $typeCurrentMonth->count(),
                'prev_month_count' => $typePrevMonth->count(),
                'cumul_count' => $typeIncidents->count(),
                'current_month_duration' => $calculateDuration($typeCurrentMonth),
                'cumul_duration' => $calculateDuration($typeIncidents),
            ]];
        });

        // === ÉVOLUTION 3 DERNIERS MOIS PAR TYPE D'ALARME ===
        
        $last3Months = collect([
            ['start' => $now->copy()->subMonths(2)->startOfMonth(), 'end' => $now->copy()->subMonths(2)->endOfMonth(), 'label' => $now->copy()->subMonths(2)->format('M Y')],
            ['start' => $startOfPrevMonth, 'end' => $endOfPrevMonth, 'label' => $now->copy()->subMonth()->format('M Y')],
            ['start' => $startOfCurrentMonth, 'end' => $endOfCurrentMonth, 'label' => $now->format('M Y')],
        ]);

        $evolutionData = $typeAlarmes->mapWithKeys(function ($type) use ($allIncidents, $last3Months) {
            $monthlyData = $last3Months->map(function ($month) use ($allIncidents, $type) {
                return $allIncidents->filter(fn($i) => 
                    Carbon::parse($i->date_debut_incident)->between($month['start'], $month['end']) &&
                    $i->type_alarme_id === $type->id
                )->count();
            });
            return [$type->nom_type => $monthlyData->values()];
        });

        // === CALCULS SUPPLÉMENTAIRES ===
        
        // Taux de variation mois/mois
        $monthlyGrowthRate = $prevMonthTotal > 0 ? 
            round((($currentMonthTotal - $prevMonthTotal) / $prevMonthTotal) * 100, 1) : 0;

        // MTTR (Mean Time To Resolution) en minutes
        $calculateMTTR = function ($incidents) {
            $closed = $incidents->whereNotNull('date_fin_incident');
            if ($closed->isEmpty()) return 0;
            return round($closed->avg(function ($incident) {
                return Carbon::parse($incident->date_debut_incident)
                    ->diffInMinutes(Carbon::parse($incident->date_fin_incident));
            }));
        };

        $mttrCurrent = $calculateMTTR($currentMonthIncidents);
        $mttrPrev = $calculateMTTR($prevMonthIncidents);

        return view('dashboard', compact(
            'prevMonthTotal', 'prevMonthOpen', 'prevMonthClosed',
            'currentMonthTotal', 'currentMonthOpen', 'currentMonthClosed',
            'cumulTotal', 'cumulOpen', 'cumulClosed',
            'typeAlarmeMetrics', 'evolutionData', 'last3Months',
            'monthlyGrowthRate', 'mttrCurrent', 'mttrPrev'
        ));
    }
}


