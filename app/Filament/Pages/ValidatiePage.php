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
    public $confirmingVoltooiUitdaging = false;
    public $upgradingValidatieId;
    public $showVoltooid = false;
    public $feedbackText = '';
    public $givingFeedback = false;
    public $feedbackValidatieId;

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
        if ($validatie->validatie_antwoord != null) {
            $filePath = public_path('storage/' . $validatie->validatie_antwoord);
            if (file_exists($filePath)) {
                unlink($filePath); // Delete the file from the storage
            }
        }

        // Null the validatie record
        $validatie->validatie_antwoord = null;
        $validatie->save();

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

    public function voltooiUitdaging($validatieId)
    {
        // Find the validatie by ID
        $validatie = Validatie::findOrFail($validatieId);
        $validatie->voltooid = true;
        $validatie->save();  // Mark the current validatie as 'voltooid'

        $this->giveFeedback($validatieId);
        // Optionally, display a message if the niveau is already at the maximum
        Notification::make()
            ->title('Uitdaging voltooid')
            ->body('De uitdaging is voltooid')
            ->success()
            ->send();

        $this->confirmingVoltooiUitdaging = false;
        $this->upgradingValidatieId = null;

        // Refresh the validaties list to reflect the changes
        $this->validaties = Validatie::with(['deelthema.hoofdthema', 'user', 'uitdaging'])->get();
    }

    public function giveFeedback($validatieId)
    {
        $this->feedbackValidatieId = $validatieId;
        $this->givingFeedback = true;
    }

    public function submitFeedback()
    {
        // Save the feedback to the validatie record
        $validatie = Validatie::findOrFail($this->feedbackValidatieId);
        $validatie->feedback = $this->feedbackText;
        $validatie->save();

        // Clear and close the feedback modal
        $this->feedbackText = '';
        $this->givingFeedback = false;

        // Optional: Display a success message
        Notification::make()
            ->title('Feedback opgeslagen')
            ->body('Uw feedback is succesvol opgeslagen.')
            ->success()
            ->send();

        // Refresh the list of validaties
        $this->validaties = Validatie::with(['deelthema.hoofdthema', 'user', 'uitdaging'])->get();
    }

    public function cancelFeedback()
    {
        $this->feedbackText = '';
        $this->givingFeedback = false;
    }


    public function confirmVoltooiUitdaging($validatieId)
    {
        $this->upgradingValidatieId = $validatieId; // Store validatie ID for upgrade
        $this->confirmingVoltooiUitdaging = true; // Show the confirmation modal
    }

    public function cancelVoltooiUitdaging()
    {
        $this->confirmingVoltooiUitdaging = false; // Hide the confirmation modal
        $this->upgradingValidatieId = null; // Resetting the ID
    }

    public function toggleVoltooid()
    {
        $this->showVoltooid = !$this->showVoltooid;
    }
}
