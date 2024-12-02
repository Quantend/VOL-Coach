<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">

        <!-- Logo -->
        <div class="flex justify-center items-center absolute inset-0 z-10 -translate-y-[230px]">
            <a href="{{ route('home') }}">
                <img class="w-40 shadow-none" src="{{ asset('logo-vol.png') }}" alt="Logo">
            </a>
        </div>


        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="myInput" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
                            <ion-icon class="absolute inset-y-9 left-96 pl-14 text-gray-600 cursor-pointer text-xl" onclick="myFunction()" name="eye-outline"></ion-icon>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-md text-gray-600 font-maaxRegular">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-8 mr-72">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            </div>

            <div class="ml-64 -mt-8">
            <x-primary-button class="ms-3 mr-2">
                {{ __('Log in') }}
            </x-primary-button>
            @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 hover:text-white  focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 no-underline"
                >
                {{__('register')}}
            </a>
        @endif
        </div>
    </form>
</x-guest-layout>

<script>
function myFunction() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
  </script>
  
