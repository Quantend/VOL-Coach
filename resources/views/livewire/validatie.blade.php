<div>
    @if($token === "completed")
        <div class="text-center">
            <h1 class="text-3xl font-bold text-green-600 mb-4">Bedankt voor je feedback!</h1>
            <p class="text-lg text-gray-700 mb-2">Je validatie is succesvol ingediend.</p>
        </div>
    @else
        <div class="mb-6">
            @if($validatiePdf)
                <div class="text-center">
                    <a href="{{ asset('storage/' . $validatiePdf) }}" download class="text-blue-500 hover:text-blue-700 font-semibold">
                        <span class="border-b border-blue-500 hover:border-blue-700">Download Validatie PDF</span>
                    </a>
                </div>
            @else
                <div class="text-center text-gray-500">
                    Er is geen validatie beschikbaar
                </div>
            @endif
        </div>

        <div class="text-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Validatiepagina</h1>
            <h2 class="text-xl text-gray-600 mt-2">Upload een validatie-PDF of Word-document en geef feedback</h2>
        </div>

        <!-- Successbericht weergeven -->
        @if (session()->has('message'))
            <div class="alert alert-success bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif
        <form wire:submit.prevent="submitFeedback" enctype="multipart/form-data" class="space-y-4">
            <!-- Bestanden slepen en invoer -->
            <div>
                <label for="fileInput" >
                    <div 
                        id="dropzone" 
                        class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center cursor-pointer mb-4"
                        @dragover.prevent="dragOver" 
                        @dragleave.prevent="dragLeave" 
                        @drop.prevent="handleDrop"
                    >
                        <p class="text-gray-700 mb-2">Sleep je bestand hierheen of klik om te uploaden</p>
                        <input 
                            type="file" 
                            wire:model="pdfFile" 
                            accept=".pdf,.docx" 
                            class="hidden" 
                            id="fileInput" 
                            @change="handleFileChange"
                        >
                        <div 
                            class="cursor-pointer text-blue-500 font-semibold"
                        >
                            Kies een bestand
                        </label>
                        <div class="flex justify-center my-1">
                            <div wire:loading wire:target="pdfFile" class="loader-bee text-sm text-blue-500 mb-2"></div>
                        </div>
                        @if($pdfFile)
                            <p class="mt-2 text-gray-700">Bestand geselecteerd: <strong>{{ $pdfFile->getClientOriginalName() }}</strong></p>
                        @endif
                        <p class="text-sm text-gray-500 mt-2">Bestanden die geüpload kunnen worden: PDF, Word (.docx)</p>
                        @error('pdfFile')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </label>
            </div>

            <!-- Feedback invoer -->
            <div class="mb-6">
                <textarea 
                    wire:model="feedback" 
                    placeholder="Geef extra feedback... (optioneel)" 
                    rows="4" 
                    class="w-full p-3 border border-gray-300 rounded-lg"
                ></textarea>
                @error('feedback')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="theme-button">
                    Upload bestand en sla feedback op
                </button>
            </div>
        </form>
    @endif
</div>

<!-- Voeg FontAwesome toe voor iconen -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<!-- JavaScript voor Drag-and-Drop -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Functie om te detecteren of er een bestand wordt gesleept
        const dropzone = document.getElementById('dropzone');

        dropzone.addEventListener('dragover', function (event) {
            event.preventDefault();
            dropzone.classList.add('border-pink-400');
            dropzone.classList.remove('border-gray-300');
        });

        dropzone.addEventListener('dragleave', function () {
            dropzone.classList.remove('border-pink-400');
            dropzone.classList.add('border-gray-300');
        });

        dropzone.addEventListener('drop', function (event) {
            event.preventDefault();
            dropzone.classList.remove('border-pink-400');
            dropzone.classList.add('border-gray-300');

            const files = event.dataTransfer.files;
            if (files.length) {
                // Update de bestand in de Livewire component
                let inputFile = document.getElementById('fileInput');
                inputFile.files = files;
                // Trigger de onchange event zodat Livewire weet dat het bestand is geselecteerd
                inputFile.dispatchEvent(new Event('change'));
            }
        });
    });
</script>