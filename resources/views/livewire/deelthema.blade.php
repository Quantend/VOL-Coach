<div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-8">
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div>
            <h1 class="text-3xl">{{ $deelthema->naam }}</h1>
            <button wire:click="backToHoofdthema({{ $deelthema->hoofdthema_id }})" class="mt-4 text-blue-500 underline">
                Terug naar Hoofdthema's
            </button>
            <div class="flex justify-center my-2">
                @if(!empty($videoId))
                <iframe height="400" width="600" controls src="https://www.youtube.com/embed/{{ $videoId }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @endif
            </div>
            <div>
            {!! $deelthema->content !!}
            </div>

            @if($uitdaging)
                <div class="mt-6">
                    <h2 class="text-2xl font-bold">Uitdaging</h2>
                    <p class="text-md font-semibold">Niveau: {{ $uitdaging->niveau }}</p>
                    @if($uitdaging->validatie)
                        <p>
                            <a href="{{ Storage::disk('public')->url($uitdaging->validatie) }}"
                               download class="text-blue-500 underline">
                                Download Validatie pdf
                            </a>
                        </p>
                    @endif
                </div>
                @if(!empty($opdrachten))
                    <div class="mt-6">
                        <h2 class="text-2xl font-bold">Opdrachten</h2>
                        <ul class="list-disc pl-5">
                            @foreach($opdrachten as $opdracht)
                                <li>{{ $opdracht['opdracht'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
