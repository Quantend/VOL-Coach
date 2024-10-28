<div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-8">
    <div class="p-4 sm:p-8 sm:rounded-lg">
        <div class="">
            @if($showHoofdthemaList)
                <h1 class="text-3xl">Hoofdthema's</h1>
                <ul class="grid grid-cols-3 gap-4 p-0">
                    @foreach($hoofdthemas as $hoofdthema)
                        <div class="p-4 hover:cursor-pointer hover:scale-105 transition-all shadow bg-white rounded-br-md rounded-tl-md" wire:click="selectHoofdthema({{ $hoofdthema->id }})">
                            <p class="text-pink-400">{{ $hoofdthema->naam }}</p>
                            <p class="text-gray-700">{{ $hoofdthema->beschrijving }}</p>
                        </div>
                    @endforeach
                </ul>
            @endif

            @if($selectedHoofdthema)
                <h2 class="text-3xl">{{ $selectedHoofdthema->naam }}</h2>
                <div class="text-red-500 hover:cursor-pointer theme-button" wire:click="backToHoofdthemaList">Terug naar hoofdthema's</div>
                    @if(!empty($videoId))
                        <div class="flex justify-center my-2 my-10">
                            <iframe height="400" width="600" controls src="https://www.youtube.com/embed/{{ $videoId }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    @endif
                    <div>
                        {!! $selectedHoofdthema->content !!}
                    </div>
                <div class="text-blue-500 hover:cursor-pointer theme-button" wire:click="startZelfscoreToets">Zelfscore toets</div>
            @endif
        </div>
    </div>
</div>
