<div>
    <h2 class="text-3xl">Zelfscore Toets</h2>

    <form wire:submit.prevent="saveAntwoorden">
        @foreach($vragen as $index => $vraag)
            <label class="block text-center">{{ $vraag['vraag'] }}</label>
            <div class="mb-4 flex justify-center">
                <div class="items-center flex">
                    <span class="">Oneens</span>
                    <input type="range"
                           min="1" max="5"
                           step="1"
                           wire:model="antwoorden.{{ $index }}"
                           class="mx-4">
                    <span>Eens</span>
                </div>
                @error("antwoorden.$index") <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        @endforeach

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Opslaan</button>
    </form>

</div>
