<x-app-layout>
    @if(auth()->check() && (auth()->user()->role === 'noc_engineer' || auth()->user()->role === 'superadmin'))
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Ajouter un nouvel incident</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('incidents.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 my-2">
                    <!-- Sites -->
                    <div class="mb-6">
                        <label for="site_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Site concerné <span class="text-red-500">*</span>
                        </label>
                        <select id="site_id"
                                name="site_id"
                                class="form-select block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                onchange="afficherTechnologies()"
                                required>
                            <option value="">Sélectionnez un site</option>
                            @foreach($sites as $site)
                                <option class="uppercase" value="{{ $site->id }}">{{ $site->nom_site }}</option>
                            @endforeach
                        </select>
                        <!-- <span id="site-error" style="color:red; display:none;">Aucune technologie trouvée pour ce site.</span> -->
                    </div>

                    <!-- Technicien -->
                    <div>
                        <label for="technicien_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Technicien contacté <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select name="technicien_id" id="technicien_id"
                                    class="form-select block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('technicien_id') border-red-500 @enderror"
                                    required>
                                <option value="">Sélectionnez</option>
                                @foreach($techniciens as $tech)
                                    <option value="{{ $tech->id }}" {{ old('technicien_id') == $tech->id ? 'selected' : '' }}>
                                        {{ $tech->nom_tech }} {{ $tech->prenom_tech }}  ({{ $tech->tel_tech }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('technicien_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Technologies, Fréquences, Secteurs -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Technologies, Fréquences et Secteurs concernés <span class="text-red-500">*</span>
                    </label>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <div id="tech-freq-secteur-tree">
                            <!-- L'arborescence sera générée dynamiquement par JavaScript -->
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 my-2">
                    <!-- Date début -->
                    <div>
                        <label for="date_debut_incident" class="block text-sm font-medium text-gray-700 mb-1">
                            Date début <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="datetime-local"
                                   name="date_debut_incident"
                                   id="date_debut_incident"
                                   class="form-input block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('date_debut_incident') border-red-500 @enderror"
                                   value="{{ old('date_debut_incident') }}"
                                   step="60"
                                   required>
                        </div>
                        @error('date_debut_incident')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date fin -->
                    <div>
                        <label for="date_fin_incident" class="block text-sm font-medium text-gray-700 mb-1">
                            Date fin
                        </label>
                        <div class="mt-1">
                            <input type="datetime-local"
                                   name="date_fin_incident"
                                   id="date_fin_incident"
                                   class="form-input block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('date_fin_incident') border-red-500 @enderror"
                                   value="{{ old('date_fin_incident') }}"
                                   step="60">
                        </div>
                        @error('date_fin_incident')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date contact technicien -->
                    <div>
                        <label for="date_contact_technicien" class="block text-sm font-medium text-gray-700 mb-1">
                            Date contact technicien
                        </label>
                        <div class="mt-1">
                            <input type="datetime-local"
                                   name="date_contact_technicien"
                                   id="date_contact_technicien"
                                   class="form-input block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('date_contact_technicien') border-red-500 @enderror"
                                   value="{{ old('date_contact_technicien') }}"
                                   step="60">
                        </div>
                        @error('date_contact_technicien')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date arrivée sur site -->
                    <div>
                        <label for="date_arrivee_sur_site" class="block text-sm font-medium text-gray-700 mb-1">
                            Date arrivée sur site
                        </label>
                        <div class="mt-1">
                            <input type="datetime-local"
                                   name="date_arrivee_sur_site"
                                   id="date_arrivee_sur_site"
                                   class="form-input block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('date_arrivee_sur_site') border-red-500 @enderror"
                                   value="{{ old('date_arrivee_sur_site') }}"
                                   step="60">
                        </div>
                        @error('date_arrivee_sur_site')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 my-2">
                    <!-- Causes incident -->
                    <div class="mt-6">
                        <label for="causes_incident" class="block text-sm font-medium text-gray-700 mb-1">
                            Causes incident
                        </label>
                        <div class="mt-1">
                            <textarea name="causes_incident" id="causes_incident" rows="3"
                                    class="form-textarea block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('causes_incident') border-red-500 @enderror">{{ old('causes_incident') }}</textarea>
                        </div>
                        @error('causes_incident')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions effectuées -->
                    <div class="mt-6">
                        <label for="actions_effectuees" class="block text-sm font-medium text-gray-700 mb-1">
                            Actions effectuées
                        </label>
                        <div class="mt-1">
                            <textarea name="actions_effectuees" id="actions_effectuees" rows="3"
                                    class="form-textarea block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('actions_effectuees') border-red-500 @enderror">{{ old('actions_effectuees') }}</textarea>
                        </div>
                        @error('actions_effectuees')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6 mb-2">
                    <!-- Intervenant -->
                    <div>
                        <label for="intervenant" class="block text-sm font-medium text-gray-700 mb-1">
                            Intervenant
                        </label>
                        <div class="mt-1">
                            <input type="text"
                                    name="intervenant"
                                    id="intervenant"
                                    maxlength="50"
                                    class="form-input block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('intervenant') border-red-500 @enderror"
                                    value="{{ old('intervenant') }}">
                        </div>
                        @error('intervenant')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <!-- Type d'alarme -->
                    <div>
                        <label for="type_alarme_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Type d'alarme <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select name="type_alarme_id" id="type_alarme_id"
                                    class="form-select block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('type_alarme_id') border-red-500 @enderror"
                                    required>
                                <option value="">Sélectionnez</option>
                                @foreach($typesAlarme as $type)
                                    <option value="{{ $type->id }}" {{ old('type_alarme_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->nom_type_alarme }} ({{ $type->descr_type_alarme }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('type_alarme_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 my-2">
                    <!-- Observation -->
                    <div class="mt-6">
                        <label for="observation" class="block text-sm font-medium text-gray-700 mb-1">
                            Observation
                        </label>
                        <div class="mt-1">
                            <textarea name="observation" id="observation" rows="3"
                                      class="form-textarea block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('observation') border-red-500 @enderror">{{ old('observation') }}</textarea>
                        </div>
                        @error('observation')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>    
    
                    <!-- Notes -->
                    <div class="mt-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <div class="mt-1">
                            <textarea name="notes" id="notes" rows="3"
                                      class="form-textarea block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('notes') border-red-500 @enderror"
                                      placeholder="Vous pouvez ajouter des notes de rappel">{{ old('notes') }}</textarea>
                        </div>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div id="technologies-container" class="mb-6"></div>
                <span id="tech-error" style="color:red; display:none;">Veuillez sélectionner au moins une technologie.</span>
                <div id="tech-toast" style="display:none; position: fixed; top: 30px; right: 30px; background: #f87171; color: white; padding: 16px 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); z-index: 9999; font-weight: bold;">Veuillez sélectionner au moins une technologie.</div>

                <!-- Sites impactés dynamiques -->
                <div class="mt-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sites impactés (autres que le site principal)</label>
                    <div id="sites-impactes-container"></div>
                    <button type="button" id="add-site-impacte" class="mt-2 px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                        + Ajouter un site impacté
                    </button>
                </div>

                <!-- Secteurs concernés -->
                <!-- <div class="mt-8">
                    <label for="secteurs" class="block text-sm font-medium text-gray-700 mb-2">
                        Secteurs concernés <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <select name="secteurs[]" id="secteurs" multiple 
                                class="form-select block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('secteurs') border-red-500 @enderror"
                                size="8"
                                required>
                            @foreach($arbreTechnosFreqSecteurs as $techId => $technologie)
                                <optgroup label="{{ $technologie['nom'] }}">
                                    @foreach($technologie['frequences'] as $freqId => $frequence)
                                        <optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;{{ $frequence['nom'] }}">
                                            @foreach($frequence['secteurs'] as $secteur)
                                                <option value="{{ $secteur['id'] }}" {{ in_array($secteur['id'], old('secteurs', [])) ? 'selected' : '' }}>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $secteur['nom'] }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="mt-1 text-sm text-gray-500">
                            Maintenez Ctrl (ou Cmd sur Mac) pour sélectionner plusieurs secteurs
                        </p>
                    </div>
                    @error('secteurs')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div> -->

                <div class="flex items-center justify-between mt-8">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-150">
                        <i class="fas fa-save mr-2"></i>Enregistrer
                    </button>
                    <a href="{{ route('incidents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white font-medium rounded-md transition-colors duration-150">
                        <i class="fas fa-arrow-left mr-2"></i>Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Aération des cases à cocher */
        .checkbox-list label {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            gap: 0.5rem;
        }
        .checkbox-list.techs {
            flex-direction: column;
        }
        .checkbox-list.freqs {
            flex-wrap: wrap;
            gap: 1.2rem 2.5rem;
        }
        .checkbox-list.secteurs {
            flex-direction: column;
        }
    </style>

    <script>
    const siteSelect = document.getElementById('site_id');
    const techContainer = document.getElementById('technologies-container');
    const siteError = document.getElementById('site-error');
    siteSelect.onchange = function() {
        const siteId = siteSelect.value;
        techContainer.innerHTML = '';
        siteError.style.display = 'none';
        if (!siteId) return;
        fetch(`/api/sites/${siteId}/technologies`)
            .then(res => res.json())
            .then(data => {
                if (!data.technologies || data.technologies.length === 0) {
                    siteError.style.display = 'inline';
                    return;
                }
                let html = '<label class="block text-sm font-medium text-gray-700 mb-2">Technologies concernées <span class="text-red-500">*</span></label>';
                html += '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">';
                data.technologies.forEach(tech => {
                    html += `<div class='flex items-center'>` +
                            `<input type='checkbox' name='technologies[]' value='${tech.id}' id='tech_${tech.id}' class='h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded'>` +
                            `<label for='tech_${tech.id}' class='ml-2 block text-sm text-gray-900'>${tech.nom_technologie}</label>` +
                            `</div>`;
                });
                html += '</div>';
                techContainer.innerHTML = html;
            })
            .catch(() => { siteError.style.display = 'inline'; });
    };

    // Validation à la soumission
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const techCheckboxes = techContainer.querySelectorAll('input[type="checkbox"]');
        const checked = Array.from(techCheckboxes).some(cb => cb.checked);
        if (techCheckboxes.length > 0 && !checked) {
            e.preventDefault();
            document.getElementById('tech-error').style.display = 'inline';
            // Toast notification
            const toast = document.getElementById('tech-toast');
            toast.style.display = 'block';
            setTimeout(() => { toast.style.display = 'none'; }, 3000);
        } else {
            document.getElementById('tech-error').style.display = 'none';
        }
    });

    const sites = @json($sites);
    const techniciens = @json($techniciens);
    const typesAlarme = @json($typesAlarme);
    const sitesImpactesContainer = document.getElementById('sites-impactes-container');
    const addSiteImpacteBtn = document.getElementById('add-site-impacte');

    function getSiteOptions(selected = null) {
        let principal = document.getElementById('site_id').value;
        return sites
            .filter(site => site.id != principal)
            .map(site => `<option value="${site.id}" ${selected == site.id ? 'selected' : ''}>${site.nom_site}</option>`)
            .join('');
    }

    function getTechOptions(selected = null) {
        return techniciens.map(tech => `<option value="${tech.id}" ${selected == tech.id ? 'selected' : ''}>${tech.nom_tech} ${tech.prenom_tech}</option>`).join('');
    }
    function getTypeAlarmeOptions(selected = null) {
        return typesAlarme.map(type => `<option value="${type.id}" ${selected == type.id ? 'selected' : ''}}>${type.nom_type_alarme}</option>`).join('');
    }

    let siteImpacteIndex = 0;
    addSiteImpacteBtn.addEventListener('click', function() {
        const idx = siteImpacteIndex++;
        const bloc = document.createElement('div');
        bloc.className = 'border rounded p-4 mb-4 bg-gray-50 relative';
        bloc.innerHTML = `
            <button type="button" class="absolute top-2 right-2 text-red-500 remove-site-impacte" title="Retirer ce site">&times;</button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700">Site impacté</label>
                    <select name="sites_impactes[${idx}][site_id]" class="form-select w-full" required>
                        <option value="">Sélectionnez un site</option>
                        ${getSiteOptions()}
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700">Technicien contacté</label>
                    <select name="sites_impactes[${idx}][technicien_id]" class="form-select w-full">
                        <option value="">--</option>
                        ${getTechOptions()}
                    </select>
                </div>
               <div>
                    <label class="block text-xs font-medium text-gray-700">Date début</label>
                    <input type="datetime-local" name="sites_impactes[${idx}][date_debut_incident]" class="form-input w-full">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700">Date fin</label>
                    <input type="datetime-local" name="sites_impactes[${idx}][date_fin_incident]" class="form-input w-full">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700">Date contact du technicien</label>
                    <input type="datetime-local" name="sites_impactes[${idx}][date_arrivee_sur_site]" class="form-input w-full">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700">Date arrivée sur site</label>
                    <input type="datetime-local" name="sites_impactes[${idx}][date_arrivee_sur_site]" class="form-input w-full">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700">Intervenant</label>
                    <input type="text" name="sites_impactes[${idx}][intervenant]" maxlength="50" class="form-input w-full">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700">Type d'alarme</label>
                    <select name="sites_impactes[${idx}][type_alarme_id]" class="form-select w-full">
                        <option value="">--</option>
                        ${getTypeAlarmeOptions()}
                    </select>
                </div>
                 <div>
                    <label class="block text-xs font-medium text-gray-700">Causes incident</label>
                    <textarea name="sites_impactes[${idx}][causes_incident]" class="form-textarea w-full"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700">Actions effectuées</label>
                    <textarea name="sites_impactes[${idx}][actions_effectuees]" class="form-textarea w-full"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700">Observation</label>
                    <textarea name="sites_impactes[${idx}][observation]" class="form-textarea w-full"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700">Notes</label>
                    <textarea name="sites_impactes[${idx}][notes]" class="form-textarea w-full"></textarea>
                </div>
            </div>
        `;
        sitesImpactesContainer.appendChild(bloc);
    });

    // Suppression d'un bloc site impacté
    sitesImpactesContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-site-impacte')) {
            e.target.closest('div.border').remove();
        }
    });

    const data = @json($arbreTechnosFreqSecteurs);
    const tableBody = document.getElementById('tech-freq-secteur-tbody');

    // Utilitaires pour générer les cases à cocher
    function createCheckbox(name, value, text, id, checked = false, inline = false) {
        const divClass = inline ? 'form-check form-check-inline me-3' : 'form-check mb-1';
        return `<div class="${divClass}">
            <input type="checkbox" name="${name}" value="${value}" id="${id}" class="form-check-input" ${checked ? 'checked' : ''}>
            <label for="${id}" class="form-check-label ms-1">${text}</label>
        </div>`;
    }

    // Récupère la liste cumulative des fréquences pour les technos cochées
    function getUnionFrequences(checkedTechIds) {
        const freqMap = {};
        checkedTechIds.forEach(techId => {
            const tech = data[techId];
            if (tech) {
                Object.values(tech.frequences).forEach(freq => {
                    freqMap[freq.id] = freq;
                });
            }
        });
        return Object.values(freqMap);
    }
    // Récupère la liste cumulative des secteurs pour les fréquences cochées
    function getUnionSecteurs(checkedFreqIds) {
        const secteurMap = {};
        Object.values(data).forEach(tech => {
            Object.values(tech.frequences).forEach(freq => {
                if (checkedFreqIds.includes(freq.id.toString())) {
                    freq.secteurs.forEach(secteur => {
                        secteurMap[secteur.id] = secteur;
                    });
                }
            });
        });
        return Object.values(secteurMap);
    }

    // Génère l'arborescence hiérarchique
    function renderTechTree() {
        const treeContainer = document.getElementById('tech-freq-secteur-tree');
        let html = '';
        
        // Checkbox "Tout cocher"
        html += `<div class="mb-3 p-2 bg-blue-50 rounded border border-blue-200">
            <label class="flex items-center">
                <input type="checkbox" onclick="toggleAll(this)" class="border-gray-300 rounded mr-2">
                <span class="font-bold text-blue-700 text-sm">Tout cocher</span>
            </label>
        </div>`;
        
        // Grille des technologies
        html += `<div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-3 gap-3">`;
        
        // Parcourir chaque technologie
        Object.values(data).forEach(tech => {
            html += `<div class="p-2 bg-white rounded border border-gray-200 shadow-sm">`;
            
            // En-tête de la technologie
            html += `<div class="mb-2 p-1 bg-gray-100 rounded">
                <label class="flex items-center">
                    <input type="checkbox" name="technologies[]" value="${tech.id}" id="tech_${tech.id}" 
                           class="border-gray-300 rounded mr-2" onchange="toggleTech(this, '${tech.id}')">
                    <span class="font-semibold text-gray-800 text-sm">${tech.nom}</span>
                </label>
            </div>`;
            
            // Fréquences de cette technologie
            Object.values(tech.frequences).forEach(freq => {
                html += `<div class="ml-3 mb-1 p-1 bg-gray-50 rounded">`;
                
                // En-tête de la fréquence
                html += `<div class="mb-1">
                    <label class="flex items-center">
                        <input type="checkbox" name="frequences[]" value="${freq.id}" id="freq_${freq.id}" 
                               class="border-gray-300 rounded mr-2" onchange="toggleFreq(this, '${tech.id}', '${freq.id}')">
                        <span class="font-bold text-gray-700 text-xs">${freq.nom}</span>
                    </label>
                </div>`;
                
                // Secteurs de cette fréquence
                html += `<div class="ml-3 flex flex-wrap gap-2">`;
                freq.secteurs.forEach(secteur => {
                    html += `<label class="ml-3 flex items-center">
                        <input type="checkbox" name="secteurs[]" value="${secteur.id}" id="secteur_${secteur.id}" 
                               class="border-gray-300 rounded mr-1" onchange="toggleSecteur(this, '${tech.id}', '${freq.id}')">
                        <span class="text-xs text-gray-600">${secteur.nom}</span>
                    </label>`;
                });
                html += `</div>`;
                
                html += `</div>`;
            });
            
            html += `</div>`;
        });
        
        html += `</div>`;
        
        treeContainer.innerHTML = html;
    }

    // Fonction pour tout cocher/décocher
    function toggleAll(sourceCheckbox) {
        const allCheckboxes = document.querySelectorAll('input[name="technologies[]"], input[name="frequences[]"], input[name="secteurs[]"]');
        allCheckboxes.forEach(cb => {
            cb.checked = sourceCheckbox.checked;
        });
    }

    // Fonction pour gérer la technologie
    function toggleTech(sourceCheckbox, techId) {
        const tech = data[techId];
        if (!tech) return;
        
        // Cocher/décocher toutes les fréquences de cette technologie
        Object.values(tech.frequences).forEach(freq => {
            const freqCheckbox = document.getElementById(`freq_${freq.id}`);
            if (freqCheckbox) {
                freqCheckbox.checked = sourceCheckbox.checked;
            }
            
            // Cocher/décocher tous les secteurs de cette fréquence
            freq.secteurs.forEach(secteur => {
                const secteurCheckbox = document.getElementById(`secteur_${secteur.id}`);
                if (secteurCheckbox) {
                    secteurCheckbox.checked = sourceCheckbox.checked;
                }
            });
        });
    }

    // Fonction pour gérer la fréquence
    function toggleFreq(sourceCheckbox, techId, freqId) {
        const tech = data[techId];
        if (!tech) return;
        
        const freq = tech.frequences[freqId];
        if (!freq) return;
        
        // Cocher/décocher tous les secteurs de cette fréquence
        freq.secteurs.forEach(secteur => {
            const secteurCheckbox = document.getElementById(`secteur_${secteur.id}`);
            if (secteurCheckbox) {
                secteurCheckbox.checked = sourceCheckbox.checked;
            }
        });
        
        // Vérifier si toutes les fréquences de la technologie sont cochées
        const allFreqsChecked = Object.values(tech.frequences).every(f => {
            const freqCheckbox = document.getElementById(`freq_${f.id}`);
            return freqCheckbox && freqCheckbox.checked;
        });
        
        // Mettre à jour la checkbox de la technologie
        const techCheckbox = document.getElementById(`tech_${techId}`);
        if (techCheckbox) {
            techCheckbox.checked = allFreqsChecked;
        }
    }

    // Fonction pour gérer le secteur
    function toggleSecteur(sourceCheckbox, techId, freqId) {
        const tech = data[techId];
        if (!tech) return;
        
        const freq = tech.frequences[freqId];
        if (!freq) return;
        
        // Vérifier si tous les secteurs de cette fréquence sont cochés
        const allSecteursChecked = freq.secteurs.every(s => {
            const secteurCheckbox = document.getElementById(`secteur_${s.id}`);
            return secteurCheckbox && secteurCheckbox.checked;
        });
        
        // Mettre à jour la checkbox de la fréquence
        const freqCheckbox = document.getElementById(`freq_${freqId}`);
        if (freqCheckbox) {
            freqCheckbox.checked = allSecteursChecked;
        }
        
        // Vérifier si toutes les fréquences de la technologie sont cochées
        const allFreqsChecked = Object.values(tech.frequences).every(f => {
            const freqCheckbox = document.getElementById(`freq_${f.id}`);
            return freqCheckbox && freqCheckbox.checked;
        });
        
        // Mettre à jour la checkbox de la technologie
        const techCheckbox = document.getElementById(`tech_${techId}`);
        if (techCheckbox) {
            techCheckbox.checked = allFreqsChecked;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        renderTechTree();
    });
    </script>
    @else
    <div class="flex items-center justify-center min-h-screen">
        <div class="max-w-md w-full bg-white p-8 rounded shadow text-center">
            <h1 class="text-2xl font-bold mb-6" style="color:red"><i class="fa-solid fa-triangle-exclamation"></i> Accès non autorisé !</h1>
            <p class="mb-6">
                Désolé, cet espace est réservé au NOC Engineer !
            </p>
            <a href="{{ route('incidents.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full mb-2">Retourner à la liste des incidents</a>
        </div>
    </div>
    @endif


    <script>
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById('date_debut_incident');
    if (!input.value) {
        const now = new Date();
        now.setSeconds(0, 0); // pour que les secondes soient toujours 00
        const offset = now.getTimezoneOffset();
        now.setMinutes(now.getMinutes() - offset); // ajuster au fuseau pour éviter le décalage
        input.value = now.toISOString().slice(0,16);
    }
});
</script>

</x-app-layout> 