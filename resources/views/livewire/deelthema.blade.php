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
        </div>
    </div>
</div>
