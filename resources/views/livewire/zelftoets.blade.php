<div>
    <div class="max-w-3xl mx-auto p-6 bg-gray-100 rounded-lg mt-10 shadow-md">
        <h2 class="text-3xl font-semibold text-center mb-6" style="color: #00365e;">Zelfscore Toets</h2>

        <form wire:submit.prevent="saveAntwoorden" class="space-y-6">
            @foreach($vragen as $index => $vraag)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <label class="block text-lg font-medium text-center mb-4"
                           style="color: #00365e;">{{ $vraag['vraag'] }}</label>
                    <div class="flex flex-col items-center space-y-2">
                        <div class="flex items-center justify-center w-full">
                            <span class="text-gray-500">Oneens</span>
                            <input type="range"
                                   min="1" max="5"
                                   step="1"
                                   wire:model="antwoorden.{{ $index }}"
                                   class="mx-4 w-2/3 h-2 rounded-lg"
                                   style="background-color: #00365e; accent-color: #dd0069;">
                            <span class="text-gray-500">Eens</span>
                        </div>
                        @error("antwoorden.$index")
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endforeach

            <button type="submit"
                    class="w-full py-3 px-6 rounded-lg text-lg font-semibold transition-colors duration-300"
                    style="background-color: #dd0069; color: white;"
                    onmouseover="this.style.backgroundColor='#00365e'"
                    onmouseout="this.style.backgroundColor='#dd0069'">
                Opslaan
            </button>
        </form>
    </div>
    <div class="h-10">

    </div>
</div>
