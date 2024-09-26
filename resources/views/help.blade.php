<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-14">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-xl">
            <div class="max-w-xl mx-auto">

                <h1 class="text-3xl text-center mb-2">{{__('Help')}}</h1>

                <div>
                    <x-input-label for="name" :value="__('Naam')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="description" :value="__('Beschrijving vraag')" />
                    <textarea id="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm resize-none" rows="4" name="description" required>{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="mt-6 text-center">
                    <button type="submit" class="px-10 py-3 bg-gray-900 text-white rounded-md hover:bg-gray-600">
                        {{__('Verzenden')}}
                    </button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
