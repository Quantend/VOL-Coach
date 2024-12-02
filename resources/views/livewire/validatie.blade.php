<div>
    @if($token === "completed")
        <h1>Thank you for your feedback!</h1>
        <p>Your validation has been successfully submitted.</p>
        <p>We appreciate your input.</p>
    @else
        @if($pdfFile)
            <p>
                <a href="{{ asset('storage/' . $pdfFile) }}" download
                   class="cursor-pointer theme-button">
                    Download Validatie pdf
                </a>
            </p>
            @else
            <p>
                geen validatie beschikbaar
            </p>
        @endif
    <h1>Validation Page</h1>

    <h1>Upload Validation PDF of word bestand en geef Feedback</h1>

    <!-- Show success message -->
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submitFeedback" enctype="multipart/form-data">
        <!-- PDF file input -->
        <input type="file" wire:model="pdfFile" accept=".pdf,.docx">

        @error('pdfFile')
        <span class="text-red-500">{{ $message }}</span>
        @enderror

        <!-- Feedback input -->
        <textarea wire:model="feedback" placeholder="Geef additional feedback... (optioneel)" rows="4"></textarea>

        @error('feedback')
        <span class="text-red-500">{{ $message }}</span>
        @enderror

        <button type="submit" class="btn btn-primary">Upload PDF and Save Feedback</button>
    </form>
    @endif
</div>
