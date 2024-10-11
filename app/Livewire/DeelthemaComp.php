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
        // Valideer het PDF-bestand
        $this->validate();

        // Sla het bestand op met een unieke naam
        $pdfName = time() . '_' . $this->pdfFile->getClientOriginalName();
        $path = $this->pdfFile->storeAs('pdfs', $pdfName, 'public'); // Sla de PDF op in de 'pdfs' map binnen de publieke opslag

        // Vind of maak een Validatie-record voor de huidige gebruiker en het huidige deelthema
        $validatie = Validatie::firstOrCreate(
            [
                'deelthema_id' => $this->deelthema->id,  // De `deelthema_id` moet overeenkomen met het huidige deelthema
                'user_id' => auth()->id(),               // De `user_id` moet overeenkomen met de ingelogde gebruiker
            ],
            [
                'uitdaging_id' => $this->uitdaging ? $this->uitdaging->id : null,  // Optioneel: als er een uitdaging is, sla het op
                'validatie_antwoord' => $path,           // Het PDF-pad wordt opgeslagen in het veld `validatie_antwoord`
            ]
        );

        // Als de validatie al bestaat, werk dan het antwoord bij
        if (!$validatie->wasRecentlyCreated) {
            $validatie->validatie_antwoord = $path;
            $validatie->save();
        }

        // Toon een succesmelding aan de gebruiker
        session()->flash('message', 'PDF succesvol geüpload!');

        // Reset de file input
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
}
