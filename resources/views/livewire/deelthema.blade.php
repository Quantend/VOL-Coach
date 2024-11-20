<div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-8">
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        @if($hideUitdagingen)
            <div>
                <h1 class="text-3xl">{{ $deelthema->naam }}</h1>
                <button wire:click="backToHoofdthema({{ $deelthema->hoofdthema_id }})"
                        class="text-pink-500 font-medium mt-4 cursor-pointer hover:text-pink-700 transition-colors">
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
                @endif
                @if ($uitdagingVoltooid === true)
                    <p class="flex justify-center mt-10 text-green-500">Uitdaging voltooid</p>
                    <button wire:click="resetVoltooid">Reset validatie?</button>
                @elseif($uitdaging)
                    @if($hideUitdagingen)
                        <div class="flex justify-center">
                            <button wire:click="toggleUitdagingen" class="mt-6 cursor-pointer theme-button">Toon
                                Uitdagingen
                            </button>
                        </div>
                    @else
                        <div class="mt-6">
                            <h2 class="text-2xl font-bold">Uitdaging</h2>
                            <p class="text-md font-semibold">Niveau: {{ $uitdaging->niveau }}</p>

                            @if($uitdaging->validatie)
                                <p>
                                    <a href="{{ asset('storage/' . $uitdaging->validatie) }}" download
                                       class="cursor-pointer theme-button">
                                        Download Validatie pdf
                                    </a>
                                </p>

                                @if($hasValidatie && $token !== "completed")
                                    <h2 class="text-2xl font-bold">Validatie link</h2>
                                    <button onclick="copyToClipboard()" class="cursor-pointer theme-button">Copy Link</button>
                                    <p id="copyText">https://vol-coach.test/validatie/{{ auth()->id() }}/{{ $token }}</p>
                                    <button wire:click="toggleHasValidatie"
                                            class="cursor-pointer theme-button">
                                        Genereer een nieuwe link
                                    </button>
                                @else
                                    <div>
                                            <div>
                                                <button wire:click="generateAndSaveToken" type="submit" class="mt-6 cursor-pointer theme-button">Generate token
                                                </button>
                                            </div>



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
                        <div class="flex justify-center">
                            <button wire:click="toggleUitdagingen" class="mt-6 cursor-pointer theme-button">Toon
                                Deelthema
                            </button>
                        </div>
                    @endif
                @else
                    <p class="flex justify-center mt-10">Geen uitdagingen beschikbaar</p>
                @endif
            </div>
    </div>
    <div class="h-5">

    </div>
</div>

<script>
    function copyToClipboard() {
        // Get the text from the <p> tag with the id 'copyText'
        var text = document.getElementById('copyText').innerText;

        // Use the Clipboard API to copy the text
        navigator.clipboard.writeText(text).then(function() {
            // Optionally, alert the user or show a success message
            alert("Link copied to clipboard!");
        }).catch(function(err) {
            console.error('Error copying text: ', err);
        });
    }
</script>
