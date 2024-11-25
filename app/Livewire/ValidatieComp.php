<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Validatie;
use Livewire\WithFileUploads;

class ValidatieComp extends Component
{
    use WithFileUploads;

    public $user_id;
    public $token;
    public $validatie;
    public $pdfFile;
    public $feedback; // The feedback input property

    public function mount($user_id, $token)
    {
        $this->user_id = $user_id;
        $this->token = $token;

        $this->validatie = Validatie::where('user_id', $user_id)->where('token', $token)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.validatie')->layout('layouts.guest');
    }

    public function submitFeedback()
    {
        // Validate the file upload
        $this->validate([
            'pdfFile' => 'required|file|mimes:pdf,docx|max:51200', // Max 50MB
            'feedback' => 'nullable|string|max:255',
        ]);

        // Generate a unique name for the PDF file
        $pdfName = time() . '_' . $this->pdfFile->getClientOriginalName();

        // Store the PDF file in the public 'pdfs' folder
        $path = $this->pdfFile->storeAs('pdfs', $pdfName, 'public');

        // Determine the uitdaging_id (it seems like this logic is still relevant)
        $uitdagingId = $this->validatie->uitdaging_id; // Assuming `uitdaging_id` is part of `validatie` model

        // Find or create a Validatie record for the current user and token
        $validatie = Validatie::firstOrCreate(
            [
                'user_id' => $this->user_id,        // Ensure we're matching the correct user
                'token' => $this->token,            // Make sure token is part of the query as well
            ],
            [
                'validatie_antwoord' => $path,       // Save the uploaded PDF file path
                'uitdaging_id' => $uitdagingId,      // Save the relevant uitdaging_id
                'feedback' => $this->feedback,
                'voltooid' => 1,
            ]
        );

        // If the validatie record already exists, update the PDF file
        if (!$validatie->wasRecentlyCreated) {
            $validatie->validatie_antwoord = $path; // Update the validatie_antwoord with new file path
            $validatie->feedback = $this->feedback;  // Update the feedback
            $validatie->voltooid = 1;                // Ensure voltooid is set to 1
            $validatie->token = 'completed';
            $validatie->save();                      // Save the updated record
        }

        // Set a success message
        session()->flash('message', 'PDF successfully uploaded!');

        // Redirect to the new token (completed)
        return redirect()->route('validatie', [
            'user_id' => $this->user_id,
            'token' => 'completed'  // Redirect to the updated 'completed' token
        ]);
    }
}
