<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Liste des technologies</h1>
            <a href="{{ route('technologie.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                <i class="fas fa-plus mr-2"></i> Ajouter une technologie
            </a>
        </div>
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
        @endif
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sites associés</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fréquences associées</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($technologies as $technologie)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $technologie->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $technologie->nom_technologie }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $technologie->sites_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $technologie->frequences_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-4 justify-center">
                                    <a href="{{ route('technologies.show', $technologie) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye text-xl"></i>
                                    </a>
                                    <a href="{{ route('technologies.edit', $technologie) }}" class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit text-xl"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> 