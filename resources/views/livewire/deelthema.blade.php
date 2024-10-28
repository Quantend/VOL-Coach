<div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-8">
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div>
            <h1 class="text-3xl">{{ $deelthema->naam }}</h1>
            <button wire:click="backToHoofdthema({{ $deelthema->hoofdthema_id }})" class="mt-4 text-blue-500 underline">
                Terug naar Hoofdthema's
            </button>
            <div class="flex justify-center my-2">
                @if(!empty($videoId))
                    <iframe height="400" width="600" controls src="https://www.youtube.com/embed/{{ $videoId }}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                @endif
            </div>
            <div>
                {!! $deelthema->content !!}
            </div>

            @if ($uitdagingVoltooid === true)
                <p class="flex justify-center mt-10 text-green-500">Uitdaging voltooid</p>
            @elseif($uitdaging)
                @if($hideUitdagingen)
                    <div class="flex justify-center">
                        <button wire:click="toggleUitdagingen" class="text-blue-500 underline">Toon Uitdagingen</button>
                    </div>
                @else
                    <div class="flex justify-center">
                        <button wire:click="toggleUitdagingen" class="text-blue-500 underline">Verberg Uitdagingen</button>
                    </div>
                    <div class="mt-6">
                        <h2 class="text-2xl font-bold">Uitdaging</h2>
                        <p class="text-md font-semibold">Niveau: {{ $uitdaging->niveau }}</p>

                        @if($uitdaging->validatie)
                            <p>
                                <a href="{{ asset('storage/' . $uitdaging->validatie) }}" download class="text-blue-500 underline">
                                    Download Validatie pdf
                                </a>
                            </p>

                            @if($hasValidatie)
                                <p class="text-green-500">Validatie is verstuurd.</p>
                                <button wire:click="toggleHasValidatie" class="text-blue-500 underline cursor-pointer">
                                    Verstuur nieuwe validatie.
                                </button>
                                <p class="text-red-500 text-xs">*Oude validatie wordt verwijdert*</p>
                            @else
                                <div>
                                    <form wire:submit.prevent="uploadPdf">
                                        <div>
                                            <label for="pdfFile">Upload PDF</label>
                                            <input type="file" wire:model="pdfFile" accept="application/pdf">

                                            @error('pdfFile') <span class="error">{{ $message }}</span> @enderror
                                        </div>

                                        <button type="submit" class="underline text-blue-500">Submit</button>
                                    </form>

                                    <!-- Display success message -->
                                    @if (session()->has('message'))
                                        <div style="color: green;">
                                            {{ session('message') }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @else
                            <p class="text-md font-semibold">Nog geen validatie beschikbaar voor dit deelthema.</p>
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
            @else
                <p class="flex justify-center mt-10">Geen uitdagingen beschikbaar</p>
            @endif
        </div>
    </div>
</div>
