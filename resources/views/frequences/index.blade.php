<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Liste des fréquences</h1>
                {{-- A ajouter plus tard --}}
                {{--
                    <a href="{{ route('frequences.create') }}" class="bg-green-600 text-white font-bold px-4 py-2 rounded hover:bg-green-700"><i class="fas fa-plus text-sm"></i> Ajouter une fréquence</a>
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
                            <th class="border px-2 py-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Trier et grouper les fréquences par technologie
                            $grouped = $frequences->sortBy(function($f) {
                                return ($f->technologie->nom_technologie ?? '') . '|' . $f->nom_freq;
                            })->groupBy(function($f) {
                                return $f->technologie->nom_technologie ?? '-';
                            });
                        @endphp

                        @forelse($grouped as $tech => $frequencesGroup)
                            @php $first = true; @endphp
                            @foreach($frequencesGroup as $frequence)
                                <tr>
                                    @if($first)
                                        <td class="border px-2 py-1 uppercase font-medium" rowspan="{{ count($frequencesGroup) }}">{{ $tech }}</td>
                                        @php $first = false; @endphp
                                    @endif
                                    <td class="border px-2 py-1 uppercase font-medium">{{ $frequence->nom_freq }}</td>
                                    <td class="border px-2 py-1 text-center text-xs font-bold">
                                        <div class="flex space-x-4 justify-center font-bold">
                                            <a href="{{ route('frequences.show', $frequence) }}" class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-eye text-sm"></i><br>Détails
                                            </a>
                                            <a href="{{ route('frequences.edit', $frequence) }}" class="ml-2 text-green-600 hover:text-green-800">
                                                <i class="fas fa-edit text-sm"></i><br>Modifier
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-2">Aucune fréquence trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout> 