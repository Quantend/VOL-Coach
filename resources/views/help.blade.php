<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-14">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-xl">
            <div class="max-w-xl mx-auto">

                <h1 class="text-3xl text-center mb-2">{{__('Help')}}</h1>

                <!-- Formulier start -->
                <form action="{{ route('help.submit') }}" method="POST">
                    @csrf

                    <div class="mt-8">
                        <textarea id="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm resize-none" rows="7" name="description" placeholder="Vraag/Beschrijving" required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mt-6 text-center">
                        <button type="submit" class="px-10 py-3 bg-gray-900 text-white rounded-md hover:bg-gray-600">
                            {{__('Verzenden')}}
                        </button>
                    </div>
                </form>
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif            
            </div>          
        </div>
    </div>
</x-app-layout>
