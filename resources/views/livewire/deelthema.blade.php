<div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-8">
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg relative">
        @if($hideUitdagingen)
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-3xl">{{ $deelthema->naam }}</h1>
                    <button wire:click="backToHoofdthema({{ $deelthema->hoofdthema_id }})"
                        class="flex items-center cursor-pointer group">
                        <div class="fill-pink-400 w-5 transition-all duration-200 ease-in-out group-hover:mr-1 mt-11">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
                            </svg>
                        </div>
                        <div class="pl-2 text-pink-400 font-semibold mt-11">
                            Terug naar Hoofdthema's
                        </div>
                    </button>
                </div>
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
                    <button wire:click="resetVoltooid" class="cursor-pointer theme-button">Reset validatie?</button>
                @elseif($uitdaging)
                    @if($hideUitdagingen)
                        <div class="flex justify-center">
                            <button wire:click="toggleUitdagingen" class="mt-6 cursor-pointer theme-button">Toon
                                Uitdagingen
                            </button>
                                                      </div>
                    @else
                        @if(!empty($opdrachten))
                            <div class="">
                                <h2 class="text-2xl font-bold">Opdracht</h2>
                                <p class="text-md font-semibold">Niveau: {{ $uitdaging->niveau }}</p>
                                <ul class="list-disc pl-5">
                                    @foreach($opdrachten as $opdracht)
                                        <li>{{ $opdracht['opdracht'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mt-6">
                            @if($uitdaging->validatie)
                                <h2 class="text-2xl font-bold">Validatie link</h2>
                                @if($hasValidatie && $token !== "completed")
                                    <p id="copyText">https://vol-coach.gildedevops.it/validatie/{{ auth()->id() }}/{{ $token }}</p>
                                    <button wire:click="generateAndSaveToken" class="cursor-pointer theme-button mr-4 group">
                                        <div class="flex items-center">
                                            <div>
                                                Genereer een nieuwe link
                                            </div>
                                            <div class="fill-white w-4 ml-2 transition-all duration-200 ease-in-out group-hover:fill-pink-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M142.9 142.9c-17.5 17.5-30.1 38-37.8 59.8c-5.9 16.7-24.2 25.4-40.8 19.5s-25.4-24.2-19.5-40.8C55.6 150.7 73.2 122 97.6 97.6c87.2-87.2 228.3-87.5 315.8-1L455 55c6.9-6.9 17.2-8.9 26.2-5.2s14.8 12.5 14.8 22.2l0 128c0 13.3-10.7 24-24 24l-8.4 0c0 0 0 0 0 0L344 224c-9.7 0-18.5-5.8-22.2-14.8s-1.7-19.3 5.2-26.2l41.1-41.1c-62.6-61.5-163.1-61.2-225.3 1zM16 312c0-13.3 10.7-24 24-24l7.6 0 .7 0L168 288c9.7 0 18.5 5.8 22.2 14.8s1.7 19.3-5.2 26.2l-41.1 41.1c62.6 61.5 163.1 61.2 225.3-1c17.5-17.5 30.1-38 37.8-59.8c5.9-16.7 24.2-25.4 40.8-19.5s25.4 24.2 19.5 40.8c-10.8 30.6-28.4 59.3-52.9 83.8c-87.2 87.2-228.3 87.5-315.8 1L57 457c-6.9 6.9-17.2 8.9-26.2 5.2S16 449.7 16 440l0-119.6 0-.7 0-7.6z"/></svg>
                                            </div>
                                        </div>
                                    </button>
                                    <button wire:click="deleteToken" class="cursor-pointer theme-button mr-4 group">
                                        <div class="flex items-center">
                                            <div>
                                                Verwijder link
                                            </div>
                                            <div class="fill-white w-4 ml-2 transition-all duration-200 ease-in-out group-hover:fill-pink-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                            </div>
                                        </div>
                                    </button>
                                    <button onclick="copyToClipboard()" class="cursor-pointer theme-button group">
                                        <div class="flex items-center">
                                            <div>
                                                Kopieer link
                                            </div>
                                            <div class="fill-white w-4 ml-2 transition-all duration-200 ease-in-out group-hover:fill-pink-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M384 336l-192 0c-8.8 0-16-7.2-16-16l0-256c0-8.8 7.2-16 16-16l140.1 0L400 115.9 400 320c0 8.8-7.2 16-16 16zM192 384l192 0c35.3 0 64-28.7 64-64l0-204.1c0-12.7-5.1-24.9-14.1-33.9L366.1 14.1c-9-9-21.2-14.1-33.9-14.1L192 0c-35.3 0-64 28.7-64 64l0 256c0 35.3 28.7 64 64 64zM64 128c-35.3 0-64 28.7-64 64L0 448c0 35.3 28.7 64 64 64l192 0c35.3 0 64-28.7 64-64l0-32-48 0 0 32c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16l0-256c0-8.8 7.2-16 16-16l32 0 0-48-32 0z"/></svg>
                                            </div>
                                        </div>
                                    </button>
                                @else
                                    <div>
                                            <div>
                                                <button wire:click="generateAndSaveToken" type="submit" class="mt-6 cursor-pointer theme-button group">
                                                   <div class="flex items-center">
                                                        <div>
                                                            Genereer link
                                                        </div>
                                                        <div class="fill-white w-4 ml-2 transition-all duration-200 ease-in-out group-hover:fill-pink-400">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z"/></svg>
                                                        </div>
                                                    </div>
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
                        <div class="flex justify-center">
                            <button wire:click="toggleUitdagingen" class="mt-6 cursor-pointer theme-button">Terug naar Theorie</button>
                            <a href="{{ route('hoofdthema') }}">
                                <button class="mt-6 cursor-pointer theme-button">
                                  Terug naar Hoofdthema
                                </button>
                              </a>
                        </div>
                    @endif
                    <button class="theme-button hover:bg-white absolute top-4 right-4">
                        <a href="{{ route('help') }}" class="no-underline text-white">Vraag een VOL-coach</a>
                    </button>
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
            alert("De link is gekopieerd naar het klembord!");
        }).catch(function(err) {
            console.error('Fout bij het kopiëren van de tekst: ', err);
        });
    }
</script>
