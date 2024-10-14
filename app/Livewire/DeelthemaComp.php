<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deelthema;
use App\Models\Uitdaging;
use App\Models\Zelftoets;
use App\Models\Validatie;
use Livewire\WithFileUploads;

class DeelthemaComp extends Component
{
    use WithFileUploads;

    public $deelthema;
    public $uitdaging;
    public $videoId;
    public $opdrachten = [];
    public $hideUitdagingen = true;
    public $pdfFile;
    public $hasValidatie;

    protected $rules = [
        'pdfFile' => 'required|mimes:pdf|max:2048', // max 2MB
    ];

    public function mount($id)
    {
        $this->deelthema = Deelthema::findOrFail($id);
        $this->extractVideoId($this->deelthema->media);
        $zelftoets = Zelftoets::where('deelthema_id', $id)
            ->where('user_id', auth()->id()) // Zorg ervoor dat de juiste user wordt opgehaald
            ->first();

        if ($zelftoets && $zelftoets->uitdaging_id) {
            // Haal de uitdaging op als de uitdaging_id bestaat
            $this->uitdaging = Uitdaging::find($zelftoets->uitdaging_id);
            $this->opdrachten = $this->uitdaging->opdrachten;
        }

        $this->hasValidatie = Validatie::where('deelthema_id', $this->deelthema->id)
            ->where('user_id', auth()->id())
            ->whereNotNull('validatie_antwoord')  // Check if there is a PDF file
            ->exists();
    }

    public function extractVideoId($url)
    {
        if (empty($url)) {
            $this->videoId = null;
            return;
        }

        $parsedUrl = parse_url($url);

        if (!isset($parsedUrl['query'])) {
            $this->videoId = null;
            return;
        }

        parse_str($parsedUrl['query'], $queryParams);

        if (isset($queryParams['v'])) {
            $this->videoId = $queryParams['v'];
        } else {
            $this->videoId = null;
        }
    }


    public function backToHoofdthema()
    {
        return redirect()->route('hoofdthema');
    }

    public function uploadPdf()
    {
        // Validate the PDF file
        $this->validate();

        // Save the PDF file with a unique name
        $pdfName = time() . '_' . $this->pdfFile->getClientOriginalName();
        $path = $this->pdfFile->storeAs('pdfs', $pdfName, 'public'); // Save the PDF in the 'pdfs' folder within public storage

        // Find or create a Validatie record for the current user and deelthema
        $validatie = Validatie::firstOrCreate(
            [
                'deelthema_id' => $this->deelthema->id,  // Matching deelthema_id
                'user_id' => auth()->id(),               // Matching user_id
            ],
            [
                'uitdaging_id' => $this->uitdaging ? $this->uitdaging->id : null,  // Optionally save uitdaging_id if exists
                'validatie_antwoord' => $path,           // Save the uploaded PDF path in validatie_antwoord
            ]
        );

        // If validation already exists, update the PDF file
        if (!$validatie->wasRecentlyCreated) {
            $validatie->validatie_antwoord = $path;
            $validatie->save();
        }

        // Set hasValidatie to true because the user has uploaded a file
        $this->hasValidatie = true;

        // Show a success message to the user
        session()->flash('message', 'PDF successfully uploaded!');

        // Reset the file input
        $this->reset('pdfFile');
    }

    public function render()
    {
        return view('livewire.deelthema', [
            'deelthema' => $this->deelthema,
            'videoId' => $this->videoId,
            'uitdaging' => $this->uitdaging,
            'opdrachten' => $this->opdrachten,
        ])->layout('layouts.app');
    }

    public function toggleUitdagingen()
    {
        $this->hideUitdagingen = !$this->hideUitdagingen;
    }

    public function toggleHasValidatie()
    {
        $this->hasValidatie = !$this->hasValidatie;
    }
}
