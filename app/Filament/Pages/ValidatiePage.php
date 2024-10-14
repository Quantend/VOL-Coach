<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use App\Models\Validatie;

class ValidatiePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.validatie';

    public $validaties;
    public $confirmingDeletion = false;
    public $deletingValidatieId;

    public function mount()
    {
        $this->validaties = Validatie::with(['deelthema.hoofdthema', 'user', 'uitdaging'])->get();
    }

    public function downloadPDF($id)
    {
        // Find the specific validatie with relationships, including hoofdthema through deelthema
        $validatie = Validatie::with(['deelthema.hoofdthema', 'user', 'uitdaging'])->findOrFail($id);

        $filePath = public_path('storage/' . $validatie->validatie_antwoord);

        // Check if the file exists before attempting to download
        if (!file_exists($filePath)) {
            abort(404, 'PDF file not found.');
        }

        // Creates a custom filename
        $filename = sprintf(
            '%s.%s.%s.%s.pdf',
            $validatie->user->name,                      // User's name
            $validatie->deelthema->hoofdthema->naam,    //Hoofdthema naam
            $validatie->deelthema->naam,                 // Deelthema naam
            $validatie->uitdaging->niveau,                 // Uitdaging niveau
        );

        return response()->download($filePath, $filename);
    }

    public function deleteValidatie($id)
    {
        // Find the validatie record by ID
        $validatie = Validatie::findOrFail($id);

        // Optionally delete the associated PDF file if it exists
        $filePath = public_path('storage/' . $validatie->validatie_antwoord);
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file from the storage
        }

        // Delete the validatie record
        $validatie->delete();

        // Refresh the validaties list
        $this->validaties = Validatie::with(['deelthema.hoofdthema', 'user', 'uitdaging'])->get();

        // Optional: Display a success message
        Notification::make()
            ->title('Success')
            ->body('Validatie deleted successfully.')
            ->success()
            ->send();

        $this->confirmingDeletion = false;
    }

    public function confirmDelete($id)
    {
        $this->deletingValidatieId = $id; // Store validatie ID for deletion
        $this->confirmingDeletion = true;  // Show the modal
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->deletingValidatieId = null; // Resetting the ID
    }
}
