<div class="max-w-3xl mx-auto p-6 mt-10 bg-gray-100 rounded-lg shadow-md">
    <h2 class="text-3xl font-semibold text-center mb-6 text-blue-600">Zelfscore Toets</h2>

    <form wire:submit.prevent="saveAntwoorden" class="space-y-6">
        @foreach($vragen as $index => $vraag)
            <div class="bg-white p-6 rounded-lg shadow-md">
                <label class="block text-lg font-medium text-center text-gray-800 mb-4">{{ $vraag['vraag'] }}</label>
                <div class="flex flex-col items-center space-y-2">
                    <div class="flex items-center justify-center w-full">
                        <span class="text-gray-500">Oneens</span>
                        <input type="range"
                               min="1" max="5"
                               step="1"
                               wire:model="antwoorden.{{ $index }}"
                               class="mx-4 w-2/3 h-2 bg-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-500">Eens</span>
                    </div>
                    @error("antwoorden.$index")
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach

        <button type="submit" class="w-full bg-blue-500 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-blue-600 transition-colors duration-300">
            Opslaan
        </button>
    </form>
</div>