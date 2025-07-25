<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center bg-primary">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/img/GISNOC_Logo.png') }}" alt="Logo GISNOC" class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('incidents.index')" :active="request()->routeIs('incidents.*')">
                        {{ __('Incidents') }}
                    </x-nav-link>
                    @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
                        <x-nav-link :href="route('sites.index')" :active="request()->routeIs('sites.*')">
                            {{ __('Sites') }}
                        </x-nav-link>
                        <x-nav-link :href="route('bscs.index')" :active="request()->routeIs('bscs.*')">
                            {{ __('BSC') }}
                        </x-nav-link>
                        <x-nav-link :href="route('rncs.index')" :active="request()->routeIs('rncs.*')">
                            {{ __('RNC') }}
                        </x-nav-link>
                        <x-nav-link :href="route('secteurs.index')" :active="request()->routeIs('secteurs.*')">
                            {{ __('Secteurs') }}
                        </x-nav-link>
                        <x-nav-link :href="route('frequences.index')" :active="request()->routeIs('frequences.*')">
                            {{ __('Fréquences') }}
                        </x-nav-link>
                        <x-nav-link :href="route('technologie.index')" :active="request()->routeIs('technologie.*')">
                            {{ __('Technologies') }}
                        </x-nav-link>
                        <x-nav-link :href="route('zonemaintenance.index')" :active="request()->routeIs('zonemaintenance.*')">
                            <i class="fas fa-tools mr-2"></i> Zones de maintenance
                        </x-nav-link>
                    @endif
                    
                    {{-- Onglets à supprimer --}}
                    {{-- <x-nav-link :href="route('siteincident.index')" :active="request()->routeIs('siteincident.*')">Incidents site</x-nav-link> --}}
                    {{-- <x-nav-link :href="route('sitetechnologie.index')" :active="request()->routeIs('sitetechnologie.*')">Technologies site</x-nav-link> --}}
                    {{-- <x-nav-link :href="route('secteurincident.index')" :active="request()->routeIs('secteurincident.*')">Incidents secteur</x-nav-link> --}}

                    {{-- Dropdown Informations opérationnelles --}}
                    <div class="relative items-center">
                        <x-dropdown align="left" width="56">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <i class="fas fa-cogs mr-2"></i> Informations opérationnelles
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('typesite.index')">
                                    <i class="fas fa-layer-group mr-2"></i> NodeType
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('regions.index')">
                                    <i class="fas fa-map mr-2"></i> Régions
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('technologie.index')">
                                    <i class="fas fa-microchip mr-2"></i> Technologies
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('frequences.index')">
                                    <i class="fas fa-wave-square mr-2"></i> Fréquences
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('secteurs.index')">
                                    <i class="fas fa-project-diagram mr-2"></i> Secteurs
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('techniciens.index')">
                                    <i class="fas fa-user-cog mr-2"></i> Techniciens
                                </x-dropdown-link>
                                
                                {{-- A afficher lorsqu'il y aura besoin de gérer les mécaniciens --}}
                                {{--
                                    <x-dropdown-link :href="route('mecaniciens.index')">
                                        <i class="fas fa-tools mr-2"></i> Mécaniciens
                                    </x-dropdown-link>
                                --}}
                                <x-dropdown-link :href="route('typealarme.index')">
                                    <i class="fas fa-bell mr-2"></i> Types d'alarme
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Si l'utilisateur est superadmin, il peut voir les liens suivants -->
                    @if(auth()->check() && auth()->user()->role === 'superadmin')
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            {{ __('Utilisateurs') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="font-bold text-gray-700">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('incidents.index')" :active="request()->routeIs('incidents.*')">
                {{ __('Incidents') }}
            </x-responsive-nav-link>
            @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin'))
                <x-responsive-nav-link :href="route('sites.index')" :active="request()->routeIs('sites.*')">
                    {{ __('Sites') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('bscs.index')" :active="request()->routeIs('bscs.*')">
                    {{ __('BSC') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('rncs.index')" :active="request()->routeIs('rncs.*')">
                    {{ __('RNC') }}
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('secteurs.index')" :active="request()->routeIs('secteurs.*')">
                {{ __('Secteurs') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('frequences.index')" :active="request()->routeIs('frequences.*')">
                {{ __('Fréquences') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('technologie.index')" :active="request()->routeIs('technologie.*')">
                {{ __('Technologies') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('zonemaintenance.index')" :active="request()->routeIs('zonemaintenance.*')">
                {{ __('Zones de maintenance') }}
            </x-responsive-nav-link>
            {{-- Suppression des onglets pivot responsive --}}
            {{-- <x-responsive-nav-link :href="route('siteincident.index')" :active="request()->routeIs('siteincident.*')">Incidents site</x-responsive-nav-link> --}}
            {{-- <x-responsive-nav-link :href="route('sitetechnologie.index')" :active="request()->routeIs('sitetechnologie.*')">Technologies site</x-responsive-nav-link> --}}
            {{-- <x-responsive-nav-link :href="route('secteurincident.index')" :active="request()->routeIs('secteurincident.*')">Incidents secteur</x-responsive-nav-link> --}}
        </div>

        {{-- Dropdown responsive Informations opérationnelles --}}
        <div class="block sm:hidden">
            <x-dropdown align="left" width="56">
                <x-slot name="trigger" class="bg-primary">
                    <button class="w-full flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <i class="fas fa-cogs mr-2"></i> Informations opérationnelles
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('typesite.index')">
                        <i class="fas fa-layer-group mr-2"></i> NodeType
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('regions.index')">
                        <i class="fas fa-map mr-2"></i> Régions
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('technologie.index')">
                        <i class="fas fa-microchip mr-2"></i> Technologies
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('frequences.index')">
                        <i class="fas fa-wave-square mr-2"></i> Fréquences
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('secteurs.index')">
                        <i class="fas fa-project-diagram mr-2"></i> Secteurs
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('techniciens.index')">
                        <i class="fas fa-user-cog mr-2"></i> Techniciens
                    </x-dropdown-link>

                    {{-- A afficher lorsqu'il y aura besoin de gérer les mécaniciens --}}
                    {{-- 
                        <x-dropdown-link :href="route('mecaniciens.index')">
                            <i class="fas fa-tools mr-2"></i> Mécaniciens
                        </x-dropdown-link>
                    --}}
                    <x-dropdown-link :href="route('typealarme.index')">
                        <i class="fas fa-bell mr-2"></i> Types d'alarme
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
