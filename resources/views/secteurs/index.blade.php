<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Liste des secteurs</h1>

                {{-- A ajouter plus tard --}}
                {{--
                    <a href="{{ route('secteurs.create') }}" class="bg-green-600 text-white font-bold px-4 py-2 rounded hover:bg-green-700"><i class="fas fa-plus text-sm"></i> Ajouter un secteur</a>
                --}}
            </div>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead>
                        <tr>
                            <th class="border px-2 py-1">Technologie</th>
                            <th class="border px-2 py-1">Fréquence</th>
                            <th class="border px-2 py-1">Secteurs</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Grouper les secteurs par technologie puis par fréquence
                            $grouped = $secteurs->sortBy(function($s) {
                                return ($s->frequence->technologie->nom_technologie ?? '') . '|' . ($s->frequence->nom_freq ?? '') . '|' . $s->nom_secteur;
                            })->groupBy(function($s) {
                                return ($s->frequence->technologie->nom_technologie ?? '-') . '||' . ($s->frequence->nom_freq ?? '-');
                            });
                        @endphp
                        @forelse($grouped as $key => $secteursGroup)
                            @php
                                [$tech, $freq] = explode('||', $key);
                                $rowspan = $grouped->filter(function($g, $k) use($tech) {
                                    return strpos($k, $tech.'||') === 0;
                                })->count();
                                $firstOfTech = true;
                            @endphp
                            <tr>
                                @if(!isset($techDisplayed[$tech]))
                                    <td class="border px-2 py-1 uppercase font-medium" rowspan="{{ $rowspan }}">{{ $tech }}</td>
                                    @php $techDisplayed[$tech] = true; @endphp
                                @endif
                                <td class="border px-2 py-1 uppercase font-medium">{{ $freq }}</td>
                                <td class="border px-2 py-1" style="display:flex; justify-content:space-around;">
                                    @foreach($secteursGroup as $secteur)
                                        <!-- <a href="{{ route('secteurs.show', $secteur) }}" title="Cliquez pour voir les détails" class="uppercase font-medium">{{ $secteur->nom_secteur }}</a> -->
                                        <span class="uppercase font-medium">{{ $secteur->nom_secteur }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-2">Aucun secteur trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout> 