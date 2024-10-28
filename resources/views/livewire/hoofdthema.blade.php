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
                <div class="mt-8">
                    <h2 class="text-4xl">{{ $selectedHoofdthema->naam }}</h2>
                    <div class="text-pink-500 font-medium mt-4 cursor-pointer hover:text-pink-700 transition-colors" wire:click="backToHoofdthemaList">Terug naar hoofdthema's</div>
                    @if(!empty($videoId))
                        <div class="flex justify-center my-10">
                            <iframe height="400" width="100%" class="rounded-lg shadow-md" src="https://www.youtube.com/embed/{{ $videoId }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    @endif
                    <div class="">
                        {!! $selectedHoofdthema->content !!}
                    </div>
                </div>
                <div class="mt-6 cursor-pointer theme-button" wire:click="startZelfscoreToets">
                    Start Zelfscore Toets
                </div>
            @endif
        </div>
    </div>
</div>
