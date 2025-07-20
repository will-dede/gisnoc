<x-app-layout>
    <div class="w-full max-w-2xl mx-auto mt-10">
        <form method="POST" action="{{ route('sites.update', $site) }}" class="bg-white shadow rounded p-8">
            @csrf
            @method('PUT')
            <h1 class="text-2xl font-bold mb-6 text-center">Modifier le site</h1>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            
            <!-- Nom du site et NodeType -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <x-input-label for="nom_site" :value="'Nom du site'" />
                    <span class="text-red-500">*</span>
                    <x-text-input id="nom_site" name="nom_site" type="text" class="block mt-1 w-full" :value="old('nom_site', $site->nom_site)" required autofocus />
                    <x-input-error :messages="$errors->get('nom_site')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="type_site_id" :value="'NodeType'" />
                    <span class="text-red-500">*</span>
                    <select id="type_site_id" name="type_site_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="">Sélectionner un type</option>
                        @foreach($type_sites as $type)
                            <option value="{{ $type->id }}" {{ old('type_site_id', $site->type_site_id) == $type->id ? 'selected' : '' }}>{{ $type->nom_type_site }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('type_site_id')" class="mt-2" />
                </div>
            </div>

            <!-- Cellules 2G et 3G -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <x-input-label for="cell2G" :value="'Cellule 2G'" />
                    <x-text-input id="cell2G" name="cell2G" type="text" class="block mt-1 w-full" :value="old('cell2G', $site->cell2G)" />
                    <x-input-error :messages="$errors->get('cell2G')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="cell3G" :value="'Cellule 3G'" />
                    <x-text-input id="cell3G" name="cell3G" type="text" class="block mt-1 w-full" :value="old('cell3G', $site->cell3G)" />
                    <x-input-error :messages="$errors->get('cell3G')" class="mt-2" />
                </div>
            </div>

            <!-- Cellule 4G et NodeName -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <x-input-label for="cell4G" :value="'Cellule 4G'" />
                    <x-text-input id="cell4G" name="cell4G" type="text" class="block mt-1 w-full" :value="old('cell4G', $site->cell4G)" />
                    <x-input-error :messages="$errors->get('cell4G')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="nodeName" :value="'Node Name'" />
                    <x-text-input id="nodeName" name="nodeName" type="text" class="block mt-1 w-full" :value="old('nodeName', $site->nodeName)" />
                    <x-input-error :messages="$errors->get('nodeName')" class="mt-2" />
                </div>
            </div>

            <!-- IPs 3G et 4G -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <x-input-label for="ip3G" :value="'IP 3G'" />
                    <x-text-input id="ip3G" name="ip3G" type="text" class="block mt-1 w-full" :value="old('ip3G', $site->ip3G)" />
                    <x-input-error :messages="$errors->get('ip3G')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="ip4G" :value="'IP 4G'" />
                    <x-text-input id="ip4G" name="ip4G" type="text" class="block mt-1 w-full" :value="old('ip4G', $site->ip4G)" />
                    <x-input-error :messages="$errors->get('ip4G')" class="mt-2" />
                </div>
            </div>

            <!-- BSC et RNC -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <x-input-label for="bsc_id" :value="'BSC'" />
                    <span class="text-red-500">*</span>
                    <select id="bsc_id" name="bsc_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="">Sélectionner un BSC</option>
                        @foreach($bscs as $bsc)
                            <option value="{{ $bsc->id }}" {{ old('bsc_id', $site->bsc_id) == $bsc->id ? 'selected' : '' }}>{{ $bsc->nom_bsc }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('bsc_id')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="rnc_id" :value="'RNC'" />
                    <span class="text-red-500">*</span>
                    <select id="rnc_id" name="rnc_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="">Sélectionner un RNC</option>
                        @foreach($rncs as $rnc)
                            <option value="{{ $rnc->id }}" {{ old('rnc_id', $site->rnc_id) == $rnc->id ? 'selected' : '' }}>{{ $rnc->nom_rnc }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('rnc_id')" class="mt-2" />
                </div>
            </div>

            <!-- Zone de maintenance et Région -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <x-input-label for="zone_maintenance_id" :value="'Zone de maintenance'" />
                    <span class="text-red-500">*</span>
                    <select id="zone_maintenance_id" name="zone_maintenance_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="">Sélectionner une zone</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}" {{ old('zone_maintenance_id', $site->zone_maintenance_id) == $zone->id ? 'selected' : '' }}>{{ $zone->nom_zone }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('zone_maintenance_id')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="region_id" :value="'Région'" />
                    <span class="text-red-500">*</span>
                    <select id="region_id" name="region_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="">Sélectionner une région</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ old('region_id', $site->region_id) == $region->id ? 'selected' : '' }}>{{ $region->nom_region }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('region_id')" class="mt-2" />
                </div>
            </div>

            <!-- Technologies -->
            @if($technologies->count() > 0)
                <div class="mb-6">
                    <x-input-label :value="'Technologies'" />
                    <div class="mt-2 grid grid-cols-3 gap-2">
                        @foreach($technologies as $tech)
                            <label class="flex items-center">
                                <input type="checkbox" name="technologies[]" value="{{ $tech->id }}" 
                                       {{ in_array($tech->id, old('technologies', $site->technologies->pluck('id')->toArray())) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">{{ $tech->nom_technologie }}</span>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('technologies')" class="mt-2" />
                </div>
            @endif

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('sites.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Annuler</a>
                <x-primary-button class="ms-4">Mettre à jour</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout> 