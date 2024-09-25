<div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-8">
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="">
            @if($showHoofdthemaList)
                <h1 class="text-3xl">Hoofdthema's</h1>
                <ul>
                    @foreach($hoofdthemas as $hoofdthema)
                        <div class="p-4" wire:click="selectHoofdthema({{ $hoofdthema->id }})">
                            <p class="text-blue-500 underline text-xl hover:cursor-pointer">{{ $hoofdthema->naam }}</p>
                            <p class="text-gray-700">{{ $hoofdthema->beschrijving }}</p>
                        </div>
                    @endforeach
                </ul>
            @endif

            @if($selectedHoofdthema)
                <h2 class="text-3xl">{{ $selectedHoofdthema->naam }}</h2>
                <button class="text-red-500 hover:cursor-pointer" wire:click="backToHoofdthemaList">Terug naar hoofdthema's</button>
                    <div class="flex justify-center my-2">
                        @if(!empty($videoId))
                            <iframe height="400" width="600" controls src="https://www.youtube.com/embed/{{ $videoId }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @endif
                    </div>
                    <div>
                        {!! $selectedHoofdthema->content !!}
                    </div>
                <button class="text-blue-500 hover:cursor-pointer" wire:click="startZelfscoreToets">Zelfscore toets</button>
            @endif
        </div>
    </div>
</div>
