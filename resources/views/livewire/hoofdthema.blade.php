<div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-8">
    <div class="p-4 sm:p-8 sm:rounded-lg">
        <div class="">
            @if($showHoofdthemaList)
                <h1 class="text-3xl">Hoofdthema's</h1>
                <ul class="grid grid-cols-3 gap-4 p-0">
                    @foreach($hoofdthemas as $hoofdthema)
                        <div class="group/card p-4 hover:cursor-pointer shadow bg-white rounded-xl flex flex-col justify-between" wire:click="selectHoofdthema({{ $hoofdthema->id }})">
                            <p class="text-pink-400 text-xl font-maaxBold">{{ $hoofdthema->naam }}</p>
                            <p class="text-gray-700">{{ $hoofdthema->beschrijving }}</p>
                            <div>
                                <div class="inline-flex items-center px-3 py-1.5 bg-blue-700 border rounded-full text-white transition-all duration-300 ease-in-out">
                                    <div class="mr-3">
                                        Naar hoofdthema
                                    </div>
                                    <div class="group-hover/card:ml-3 transition-all duration-300 ease-in-out">
                                        <svg class="w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="#ffffff" d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </ul>
            @endif

            @if($selectedHoofdthema)
                <div class="bg-white p-4 sm:p-8 border rounded-xl">
                    <h2 class="text-4xl">{{ $selectedHoofdthema->naam }}</h2>
                    <div class="text-pink-500 font-medium mt-4 cursor-pointer hover:text-pink-700 transition-colors" wire:click="backToHoofdthemaList">Terug naar hoofdthema's</div>
                    <div class="">
                        {!! $selectedHoofdthema->content !!}
                    </div>
                    @if(!empty($videoId))
                        <div class="flex justify-center my-10">
                            <iframe height="400" width="100%" class="rounded-lg shadow-md" src="https://www.youtube.com/embed/{{ $videoId }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
                <div class="mt-6 cursor-pointer theme-button" wire:click="startZelfscoreToets">
                    Start zelfscore
                </div>
            @endif
        </div>
    </div>
</div>
