<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-chart-line mr-2 text-indigo-600"></i>
                {{ __('Tableau de bord') }}
            </h2>
            <div class="text-sm text-gray-500">
                Dernière mise à jour : {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- ========== SECTION 1: VUE D'ENSEMBLE ========== -->
            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl p-6 border border-indigo-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-tachometer-alt mr-2 text-indigo-600"></i>
                    Vue d'ensemble
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Cumulé</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($cumulTotal) }}</div>
                                <div class="text-xs text-gray-400 mt-1">Tous les incidents</div>
                            </div>
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-database text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-xs font-medium text-amber-600 uppercase tracking-wide">En Cours Global</div>
                                <div class="mt-1 text-2xl font-bold text-amber-600">{{ number_format($cumulOpen) }}</div>
                                <div class="text-xs text-amber-400 mt-1">Non résolus</div>
                            </div>
                            <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-amber-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-xs font-medium text-emerald-600 uppercase tracking-wide">Résolus Global</div>
                                <div class="mt-1 text-2xl font-bold text-emerald-600">{{ number_format($cumulClosed) }}</div>
                                <div class="text-xs text-emerald-400 mt-1">Clôturés</div>
                            </div>
                            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-circle text-emerald-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-xs font-medium text-purple-600 uppercase tracking-wide">Évolution M/M</div>
                                <div class="mt-1 text-2xl font-bold {{ $monthlyGrowthRate >= 0 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $monthlyGrowthRate > 0 ? '+' : '' }}{{ $monthlyGrowthRate }}%
                                </div>
                                <div class="text-xs text-gray-400 mt-1">vs mois précédent</div>
                            </div>
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-{{ $monthlyGrowthRate >= 0 ? 'arrow-up' : 'arrow-down' }} text-purple-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========== SECTION 2: COMPARAISON MENSUELLE ========== -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>
                        Comparaison mensuelle
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Mois précédent -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-700 flex items-center">
                                <i class="fas fa-calendar-minus mr-2 text-gray-500"></i>
                                Mois précédent ({{ now()->subMonth()->format('M Y') }})
                            </h4>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <div class="text-lg font-bold text-gray-700">{{ $prevMonthTotal }}</div>
                                    <div class="text-xs text-gray-500">Total</div>
                                </div>
                                <div class="bg-amber-50 rounded-lg p-3 text-center">
                                    <div class="text-lg font-bold text-amber-700">{{ $prevMonthOpen }}</div>
                                    <div class="text-xs text-amber-600">En cours</div>
                                </div>
                                <div class="bg-emerald-50 rounded-lg p-3 text-center">
                                    <div class="text-lg font-bold text-emerald-700">{{ $prevMonthClosed }}</div>
                                    <div class="text-xs text-emerald-600">Résolus</div>
                                </div>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-3">
                                <div class="text-sm font-medium text-blue-700">MTTR: {{ $mttrPrev }} min</div>
                                <div class="text-xs text-blue-600">Temps moyen de résolution</div>
                            </div>
                        </div>

                        <!-- Mois en cours -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-700 flex items-center">
                                <i class="fas fa-calendar-check mr-2 text-indigo-600"></i>
                                Mois en cours ({{ now()->format('M Y') }})
                            </h4>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-gray-50 rounded-lg p-3 text-center border-2 border-gray-200">
                                    <div class="text-lg font-bold text-gray-700">{{ $currentMonthTotal }}</div>
                                    <div class="text-xs text-gray-500">Total</div>
                                </div>
                                <div class="bg-amber-50 rounded-lg p-3 text-center border-2 border-amber-200">
                                    <div class="text-lg font-bold text-amber-700">{{ $currentMonthOpen }}</div>
                                    <div class="text-xs text-amber-600">En cours</div>
                                </div>
                                <div class="bg-emerald-50 rounded-lg p-3 text-center border-2 border-emerald-200">
                                    <div class="text-lg font-bold text-emerald-700">{{ $currentMonthClosed }}</div>
                                    <div class="text-xs text-emerald-600">Résolus</div>
                                </div>
                            </div>
                            <div class="bg-indigo-50 rounded-lg p-3 border-2 border-indigo-200">
                                <div class="text-sm font-medium text-indigo-700">MTTR: {{ $mttrCurrent }} min</div>
                                <div class="text-xs text-indigo-600">Temps moyen de résolution</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========== SECTION 3: ANALYSE PAR TYPE D'ALARME ========== -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-bell mr-2 text-orange-600"></i>
                        Analyse par type d'alarme
                    </h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-medium text-gray-700">Type d'alarme</th>
                                    <th class="text-center py-3 px-4 font-medium text-gray-700">Mois préc.</th>
                                    <th class="text-center py-3 px-4 font-medium text-gray-700">Mois actuel</th>
                                    <th class="text-center py-3 px-4 font-medium text-gray-700">Total cumulé</th>
                                    <th class="text-center py-3 px-4 font-medium text-gray-700">Durée mois (min)</th>
                                    <th class="text-center py-3 px-4 font-medium text-gray-700">Durée totale (min)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($typeAlarmeMetrics as $typeName => $metrics)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 font-medium text-gray-800">{{ $typeName }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $metrics['prev_month_count'] }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $metrics['current_month_count'] > $metrics['prev_month_count'] ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $metrics['current_month_count'] }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center text-sm font-semibold text-gray-700">
                                        {{ $metrics['cumul_count'] }}
                                    </td>
                                    <td class="py-3 px-4 text-center text-sm text-gray-600">
                                        {{ number_format($metrics['current_month_duration']) }}
                                    </td>
                                    <td class="py-3 px-4 text-center text-sm font-medium text-indigo-600">
                                        {{ number_format($metrics['cumul_duration']) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ========== SECTION 4: ÉVOLUTION TEMPORELLE ========== -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-chart-line mr-2 text-green-600"></i>
                        Évolution des incidents par type d'alarme (3 derniers mois)
                    </h3>
                </div>
                <div class="p-6">
                    <canvas id="evolutionChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js & FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            // Configuration des couleurs pour cohérence visuelle
            const colors = [
                '#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6',
                '#06B6D4', '#F97316', '#84CC16', '#EC4899', '#6B7280'
            ];

            // Graphique d'évolution
            const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
            
            const datasets = @json(array_keys($typeAlarmeMetrics->toArray())).map((typeName, index) => ({
                label: typeName,
                data: @json($evolutionData)[typeName],
                borderColor: colors[index % colors.length],
                backgroundColor: colors[index % colors.length] + '20',
                tension: 0.3,
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2,
                fill: false
            }));

            new Chart(evolutionCtx, {
                type: 'line',
                data: {
                    labels: @json($last3Months->pluck('label')),
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 12 } }
                        },
                        y: {
                            beginAtZero: true,
                            precision: 0,
                            grid: { color: '#f3f4f6' },
                            ticks: { font: { size: 12 } }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: { size: 11 }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#374151',
                            borderWidth: 1,
                            cornerRadius: 6
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
