<div>
    <div class="max-w-3xl mx-auto p-6 bg-gray-100 rounded-lg mt-10 shadow-md relative">
        <h2 class="text-3xl font-semibold text-center mb-6" style="color: #00365e;">Zelfscore</h2>

        <form wire:submit.prevent="saveAntwoorden" class="space-y-6">
            @foreach($vragen as $index => $vraag)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <label class="block text-lg font-medium text-center mb-4"
                           style="color: #00365e;">{{ $vraag['vraag'] }}</label>
                    <div class="flex flex-col items-center space-y-2">
                        <div class="flex items-center justify-center w-full">
                            <input type="range"
                                   min="1" max="5"
                                   step="1"
                                   wire:model="antwoorden.{{ $index }}"
                                   class="mx-4 w-full h-4 rounded-lg hover:cursor-pointer"
                                   style="background-color: #00365e; accent-color: #dd0069;">
                        </div>
                        @error("antwoorden.$index")
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-between">
                        <span class="text-center text-gray-500">Nooit</span>
                        <span class="text-center text-gray-500">Zelden</span>
                        <span class="text-center text-gray-500">Soms</span>
                        <span class="text-center text-gray-500">Meestal</span>
                        <span class="text-center text-gray-500">Altijd</span>
                    </div>
                </div>
            @endforeach

            <button type="submit"
                    class="w-full py-3 px-6 rounded-full text-lg font-semibold transition-colors duration-300"
                    style="background-color: #dd0069; color: white;"
                    onmouseover="this.style.backgroundColor='#00365e'"
                    onmouseout="this.style.backgroundColor='#dd0069'">
                Opslaan
            </button>
        </form>
        <button class="theme-button hover:bg-white absolute top-4 right-4">
            <a href="{{ route('help') }}" class="no-underline text-white">Vraag een VOL-coach</a>
        </button>
    </div>
    <div class="h-10"></div>
    @if($showValidatieDelete)
        <div class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-40">
            <div class="fixed inset-0 flex items-center justify-center z-50">
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <p>De antwoorden komen overeen met een eerder gemaakte validatie. <br>
                        Het maken van dezelfde validatie verwijdert de oude, wilt u doorgaan?</p>
                    <div class="flex justify-between">
                        <button wire:click="toggleValidatie" class="theme-button">
                            Annuleren
                        </button>
                        <button
                            wire:click="confirmDeleteValidatie({{ $laagsteDeelthemaId }}, {{ $uitdaging ? $uitdaging->id : 'null' }})"
                            class="theme-button">
                            Maak Nieuwe Validatie
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
