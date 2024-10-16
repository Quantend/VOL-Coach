<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use App\Models\Validatie;
use App\Models\Uitdaging;
use App\Models\Zelftoets;

class ValidatiePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.validatie';

    public $validaties;
    public $confirmingDeletion = false;
    public $deletingValidatieId;
    public $confirmingUpgrade = false;
    public $upgradingValidatieId;
    public $showVoltooid = false;

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

    public function upgradeNiveau($validatieId)
    {
        // Find the validatie by ID
        $validatie = Validatie::findOrFail($validatieId);

        // Retrieve the current uitdaging
        $currentUitdaging = $validatie->uitdaging;

        // Get the deelthema_id from the current uitdaging
        $deelthemaId = $currentUitdaging->deelthema_id;

        // Define the order of the levels
        $niveaus = ['experimenteren', 'toepassen', 'verdiepen'];

        // Find the current index of the uitdaging's niveau in the array
        $currentNiveauIndex = array_search($currentUitdaging->niveau, $niveaus);

        // If the current niveau is not the last one, find the next niveau
        if ($currentNiveauIndex !== false && $currentNiveauIndex < count($niveaus) - 1) {
            // Get the next niveau
            $nextNiveau = $niveaus[$currentNiveauIndex + 1];

            // Find the next uitdaging with the same deelthema_id and next niveau
            $nextUitdaging = Uitdaging::where('deelthema_id', $deelthemaId)
                ->where('niveau', $nextNiveau)
                ->first();

            // Check if the next uitdaging exists
            if ($nextUitdaging) {
                // Mark the current validatie as 'voltooid'
                $validatie->voltooid = true;  // Set voltooid to true for the current validatie
                $validatie->save();  // Save the current validatie

                // Create a new validatie for the next uitdaging
                $newValidatie = new Validatie();
                $newValidatie->user_id = $validatie->user_id;
                $newValidatie->uitdaging_id = $nextUitdaging->id;
                $newValidatie->deelthema_id = $deelthemaId;
                $newValidatie->validatie_antwoord = null; // Reset the answer
                $newValidatie->voltooid = false;  // New validatie is not yet completed
                $newValidatie->save();  // Save the new validatie

                // Optionally, update the zelftoets records for the same user and deelthema_id
                Zelftoets::where('user_id', $validatie->user_id)
                    ->where('deelthema_id', $deelthemaId)
                    ->update(['uitdaging_id' => $nextUitdaging->id]);

                // Optionally, display a success message
                Notification::make()
                    ->title('Niveau Upgraded')
                    ->body('De uitdaging is upgraded van: **' . $currentUitdaging->niveau . '** naar: **' . $nextNiveau . '**.')
                    ->success()
                    ->send();
            } else {
                // Optionally, display a message if the next niveau is not available
                Notification::make()
                    ->title('Next Niveau Not Found')
                    ->body('Er is geen volgende uitdaging beschikbaar voor het geselecteerde niveau: **' . $currentUitdaging->niveau . '**.')
                    ->warning()
                    ->send();
            }
        } else {
            $validatie->voltooid = true;
            $validatie->save();  // Mark the current validatie as 'voltooid'
            // Optionally, display a message if the niveau is already at the maximum
            Notification::make()
                ->title('Uitdaging voltooid')
                ->body('De uitdaging is voltooid')
                ->success()
                ->send();
        }

        $this->confirmingUpgrade = false;
        $this->upgradingValidatieId = null;

        // Refresh the validaties list to reflect the changes
        $this->validaties = Validatie::with(['deelthema.hoofdthema', 'user', 'uitdaging'])->get();
    }


    public function confirmUpgrade($validatieId)
    {
        $this->upgradingValidatieId = $validatieId; // Store validatie ID for upgrade
        $this->confirmingUpgrade = true; // Show the confirmation modal
    }

    public function cancelUpgrade()
    {
        $this->confirmingUpgrade = false; // Hide the confirmation modal
        $this->upgradingValidatieId = null; // Resetting the ID
    }

    public function toggleVoltooid()
    {
        $this->showVoltooid = !$this->showVoltooid;
    }
}
