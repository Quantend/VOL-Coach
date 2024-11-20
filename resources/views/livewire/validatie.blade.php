<div>
    @if($token === "completed")
        <h1>Thank you for your feedback!</h1>
        <p>Your validation has been successfully submitted.</p>
        <p>We appreciate your input.</p>
    @else
    <h1>Validation Page</h1>
    <p>User ID: {{ $user_id }}</p>
    <p>Token: {{ $token }}</p>

    <h1>Upload Validation PDF and Provide Feedback</h1>

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
        <textarea wire:model="feedback" placeholder="Provide your feedback..." rows="4"></textarea>

        @error('feedback')
        <span class="text-red-500">{{ $message }}</span>
        @enderror

        <button type="submit" class="btn btn-primary">Upload PDF and Save Feedback</button>
    </form>
    @endif
</div>
