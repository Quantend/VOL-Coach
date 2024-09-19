<div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-8">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="">
            @if($showHoofdthemaList)
                <h1 class="text-3xl">Hoofdthema's</h1>
                <ul>
                    @foreach($hoofdthemas as $hoofdthema)
                        <div class="p-4" wire:click="selectHoofdthema({{ $hoofdthema->id }})">
                            <p class="text-blue-500 underline text-xl hover:cursor-pointer">{{ $hoofdthema->naam }}</p>
                            <p class="text-gray-800">{{ $hoofdthema->beschrijving }}</p>
                        </div>
                    @endforeach
                </ul>
            @endif

            @if($selectedHoofdthema)
                <h2 class="text-3xl">Deelthema's van {{ $selectedHoofdthema->naam }}</h2>
                <button class="text-red-500 hover:cursor-pointer" wire:click="backToHoofdthemaList">Terug naar hoofdthema's</button>
                <ul>
                    @foreach($selectedHoofdthema->deelthemas as $deelthema)
                        <div class="p-4">
                            <a href="{{ route('deelthema', ['deelthema' => $deelthema->naam]) }}" class="text-blue-500 underline text-xl hover:cursor-pointer">
                                {{ $deelthema->naam }}
                            </a>
                            <p class="text-gray-800">{{ $deelthema->beschrijving }}</p>
                        </div>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
