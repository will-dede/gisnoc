<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
        <div class="login-box">




            <div class="avatar"><i class="fa fa-user"></i></div>
            <h2 class="">Connexion</h2>
            <p>Veuillez entrer vos identifiants pour vous connecter.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <div class="input-group mt-4">
                        <!-- <x-input-label for="email" :value="__('Email')" /> -->
                        <i class="fa fa-envelope icon-left"></i>
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Adresse e-mail" required autofocus autocomplete="username" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <div class="input-group">
                        <!-- <x-input-label for="password" :value="__('Password')" /> -->
                        <i class="fa fa-lock icon-left"></i>
                        <x-text-input id="password" class="block mt-1 w-full"
                                      type="password"
                                      name="password"
                                      placeholder="Mot de passe"
                                      required autocomplete="current-password" />
                        <button type="button" class="toggle-password" id="togglePwd" aria-label="Afficher le mot de passe">
                            <i class="fa fa-eye"></i>
                        </button>    
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <!-- Remember Me -->
                {{-- A ajouter plus tard--}}
                {{--
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                --}}

                <div class="">
                    
                    <div class="text-center">
                        {{-- A ajouter plus tard --}}
                        @if (Route::has('password.request'))
                            <a class="" href="{{ route('password.request') }}">
                                {{--
                                {{ __('Mot de passe oublié ?') }}
                                --}}
                            </a>
                        @endif

                        <x-primary-button class="">
                            {{ __('Se connecter') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>

            <div class="">
                {{--
                    <span class="text-sm text-gray-600">{{ __("Vous n'avez pas de compte ?") }}</span>
                --}}
                <p class="signup-text font-bold text-center">
                    {{ __("Vous n'avez pas de compte ?") }}
                </p>
                <p class="signup-text font-bold text-center">
                    <a href="{{ route('register') }}">
                        {{ __('Inscrivez-vous') }}
                    </a>
                </p>
            </div>




        </div>


          <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body {
            font-family: Arial, sans-serif;
            background: #e0e0e0;
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            }

            .login-box {
            width: 360px; padding: 40px; text-align: center;
            border-radius: 20px; background: #e0e0e0;
            box-shadow: 10px 10px 20px #cbced1, -10px -10px 20px #ffffff;
            }

            .avatar {
            width: 90px; height: 90px; margin: 0 auto 20px;
            border-radius: 50%; background: #e0e0e0; color:#555; font-size: 40px;
            display:flex; align-items:center; justify-content:center;
            box-shadow: inset 5px 5px 10px #cbced1, inset -5px -5px 10px #ffffff;
            }

            h2 { margin-bottom: 20px; color:#333; font-size: 24px; font-weight: 600; }

            .input-group { position: relative; margin-bottom: 20px; }

            .input-group input {
            width: 100%;
            padding: 12px 44px;            /* espace pour l'œil à droite */
            padding-left: 44px;             /* espace pour l’icône à gauche */
            border: none; outline: none; border-radius: 30px; font-size: 14px;
            background: #e0e0e0;
            box-shadow: inset 5px 5px 10px #cbced1, inset -5px -5px 10px #ffffff;
            }

            /* Icône de gauche */
            .icon-left {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #555; font-size: 18px; pointer-events: none;
            }

            /* Bouton œil à droite */
            .toggle-password {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: transparent; border: 0; padding: 0; cursor: pointer;
            color: #555; font-size: 18px; line-height: 0;
            display: flex; align-items: center; justify-content: center;
            }
            .toggle-password:focus { outline: none; }

            button[type="submit"]{
            width: 100%; padding: 12px; margin-top: 4px;
            border: none; border-radius: 30px; cursor: pointer; color:#fff; font-size:16px;
            background: #4CAF50;
            box-shadow: 5px 5px 10px #b1b1b1, -5px -5px 10px #ffffff;
            transition: background .2s;
            }
            button[type="submit"]:hover { background:#45a049; }

            .signup-text{ margin-top: 20px; font-size:14px; }
            .signup-text a{ color:#4CAF50; text-decoration:none; }
        </style>

        <script>
            const pwd = document.getElementById('password');
            const toggleBtn = document.getElementById('togglePwd');
            const toggleIcon = toggleBtn.querySelector('i');

            toggleBtn.addEventListener('click', () => {
            const showing = pwd.type === 'text';
            pwd.type = showing ? 'password' : 'text';
            toggleIcon.classList.toggle('fa-eye', showing);
            toggleIcon.classList.toggle('fa-eye-slash', !showing);
            toggleBtn.setAttribute('aria-label', showing ? 'Afficher le mot de passe' : 'Masquer le mot de passe');
            });
        </script>

</x-guest-layout>
