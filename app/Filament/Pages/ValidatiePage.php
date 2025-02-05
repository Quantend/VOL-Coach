<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use App\Models\Validatie;

class ValidatiePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.validatie';
    protected static ?string $navigationLabel = 'Validatie Pagina';

    public $validaties;
    public $confirmingDeletion = false;
    public $deletingValidatieId;
    public $confirmingVoltooiUitdaging = false;
    public $upgradingValidatieId;
    public $showVoltooid = true;
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
            abort(404, 'File not found.');
        }

        // Get file extension
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        // Creates a custom filename
        $filename = sprintf(
            '%s.%s.%s.%s.%s',
            $validatie->user->name,                      // User's name
            $validatie->deelthema->hoofdthema->naam,    //Hoofdthema naam
            $validatie->deelthema->naam,                 // Deelthema naam
            $validatie->uitdaging->niveau,                 // Uitdaging niveau
            $extension                                     // path extension
        );

        return response()->download($filePath, $filename);
    }

    public function toggleVoltooid()
    {
        $this->showVoltooid = !$this->showVoltooid;
    }
}
