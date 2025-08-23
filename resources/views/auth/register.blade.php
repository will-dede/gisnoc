<x-guest-layout>
    <div class="login-box">
        <div class="avatar"><i class="fa fa-user-plus"></i></div>
        <h2>Inscription</h2>
        <p>Veuillez remplir ce formulaire pour créer un compte</p>
    

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Lastname -->
        <div class="input-group">
            <i class="fa fa-user icon-left"></i>
            <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" placeholder="Nom" required autofocus autocomplete="family-name" />
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        </div>

        <!-- Firstname -->
        <div class="input-group">
            <i class="fa fa-user icon-left"></i>
            <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" placeholder="Prénom" required autocomplete="given-name" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        <!-- Telephone -->
        <div class="input-group">
            <i class="fa fa-phone icon-left"></i>
            <x-text-input id="telephone" class="block mt-1 w-full" type="text" name="telephone" :value="old('telephone')" placeholder="Téléphone" autocomplete="tel" />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="input-group">
            <i class="fa fa-envelope icon-left"></i>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required placeholder="E-mail" autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="input-group">
            <i class="fa fa-lock icon-left"></i>
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="Mot de passe"
                            required autocomplete="new-password" />
            <button type="button" class="toggle-password" id="togglePwd" aria-label="Afficher le mot de passe">
                <i class="fa fa-eye"></i>
            </button>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="input-group">
            <i class="fa fa-lock icon-left"></i>
            <x-text-input id="confirmPassword" class="block mt-1 w-full"
                            type="password"
                            placeholder="Confirmez le mot de passe"
                            name="password_confirmation" required autocomplete="new-password" />
            <button type="button" class="toggle-password" id="toggleConfirmPwd" aria-label="Afficher le mot de passe">
                <i class="fa fa-eye"></i>
            </button>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-primary-button>
                {{ __('Inscription') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center">
                <p class="signup-text font-bold text-center">{{ __('Vous avez déjà un compte ?') }}</p>
                <p class="signup-text font-bold text-center">
                    <a href="{{ route('login') }}">
                        {{ __('Veuillez vous connecter ici') }}
                    </a>
                </p>
            </div>
            
            
        </div>
    </form>
</div>

  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: Arial, sans-serif !important;
      background: #e0e0e0;
      min-height: 100vh; display: flex; align-items: center; justify-content: center;
    }

    .login-box {
      width: 400px; padding: 40px; text-align: center;
      border-radius: 20px; background: #e0e0e0;
      box-shadow: 10px 10px 20px #cbced1, -10px -10px 20px #ffffff;
    }

    .avatar {
      width: 90px; height: 90px; margin: 0 auto 10px;
      border-radius: 50%; background: #e0e0e0; color:#555; font-size: 40px;
      display:flex; align-items:center; justify-content:center;
      box-shadow: inset 5px 5px 10px #cbced1, inset -5px -5px 10px #ffffff;
    }

    h2 { margin-bottom: 20px; color:#333; font-size: 24px; font-weight: 600; }

    .input-group { position: relative; margin-bottom: 20px; }

    .input-group input {
      width: 100%;
      padding: 12px 44px;            
      padding-left: 44px;             
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
    .signup-text a{ color:#2da030ff; text-decoration:none; }
    .signup-text a:hover{ color:#4CAF50; text-decoration:none; }
  </style>

  <script>
    function togglePassword(inputId, btnId) {
      const input = document.getElementById(inputId);
      const btn = document.getElementById(btnId);
      const icon = btn.querySelector('i');
      
      btn.addEventListener('click', () => {
        const showing = input.type === 'text';
        input.type = showing ? 'password' : 'text';
        icon.classList.toggle('fa-eye', showing);
        icon.classList.toggle('fa-eye-slash', !showing);
        btn.setAttribute('aria-label', showing ? 'Afficher le mot de passe' : 'Masquer le mot de passe');
      });
    }

    togglePassword('password', 'togglePwd');
    togglePassword('confirmPassword', 'toggleConfirmPwd');
  </script>

</x-guest-layout>
