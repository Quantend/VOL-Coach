<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deelthema;
use App\Models\Uitdaging;
use App\Models\Zelftoets;
use App\Models\Validatie;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class DeelthemaComp extends Component
{
    use WithFileUploads;

    public $deelthema;
    public $uitdaging;
    public $videoId;
    public $opdrachten = [];
    public $hideUitdagingen = true;
    public $hasValidatie;
    public $uitdagingVoltooid = false;
    public $correctValidatie;
    public $token;

    protected $rules = [
        'pdfFile' => 'required|mimes:pdf|max:2048', // max 2MB
    ];

    public function mount($id)
    {
        $this->deelthema = Deelthema::findOrFail($id);
        $this->extractVideoId($this->deelthema->media);

        // Get the validatie record
        $validatie = Validatie::where('deelthema_id', $this->deelthema->id)
            ->where('user_id', auth()->id())
            ->first();

        // If a validatie exists, store its token
        if ($validatie) {
            $this->hasValidatie = true;
            $this->token = $validatie->token;
        } else {
            $this->hasValidatie = false;
            $this->token = null;
        }

        $zelftoets = Zelftoets::where('deelthema_id', $id)
            ->where('user_id', auth()->id()) // Zorg ervoor dat de juiste user wordt opgehaald
            ->first();

        // If a Zelftoets exists and has an uitdaging_id
        if ($zelftoets && $zelftoets->uitdaging_id) {
            // Check if there is an incomplete Validatie
            $this->correctValidatie = Validatie::where('deelthema_id', $id)
                ->where('user_id', auth()->id())
                ->where('uitdaging_id', $zelftoets->uitdaging_id)
                ->where('voltooid', false) // Check for incomplete challenges
                ->first();

            $completedValidatie = Validatie::where('deelthema_id', $id)
                ->where('user_id', auth()->id())
                ->where('uitdaging_id', $zelftoets->uitdaging_id)
                ->where('voltooid', true) // Check for completed challenges
                ->first();

            if ($this->correctValidatie) {
                // If an incomplete Validatie exists, fetch the challenge and tasks
                $this->uitdaging = Uitdaging::find($this->correctValidatie->uitdaging_id);
                $this->opdrachten = $this->uitdaging->opdrachten;
                $this->hasValidatie = Validatie::where('deelthema_id', $this->deelthema->id)
                    ->where('user_id', auth()->id())
                    ->where('uitdaging_id', $this->correctValidatie->uitdaging_id)
                    ->whereNotNull('token')  // Check if there is a token
                    ->exists();
            }
            elseif ($completedValidatie) {
                $this->uitdaging = null;
                $this->opdrachten = null;
                $this->uitdagingVoltooid = true;
            } else {
                // If no Validatie, fetch the challenge anyway
                $this->uitdaging = Uitdaging::find($zelftoets->uitdaging_id);
                $this->opdrachten = $this->uitdaging->opdrachten;
                $this->hasValidatie = Validatie::where('deelthema_id', $this->deelthema->id)
                    ->where('user_id', auth()->id())
                    ->where('uitdaging_id', $zelftoets->uitdaging_id)
                    ->whereNotNull('token')  // Check if there is a token
                    ->exists();
            }
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

    public function generateAndSaveToken()
    {
        if ($this->correctValidatie) {
            $uitdagingId = $this->correctValidatie->uitdaging_id;
        } else {
            $uitdagingId = $this->uitdaging ? $this->uitdaging->id : null;
        }

        if (!$uitdagingId) {
            session()->flash('error', 'No challenge found to associate the token with.');
            return;
        }

        // Generate a random string for the token
        $randomToken = Str::random(40);
        $test = "example string";

        // Find or create a Validatie record for the current user and deelthema
        $validatie = Validatie::firstOrCreate(
            [
                'deelthema_id' => $this->deelthema->id,
                'user_id' => auth()->id(),
                'uitdaging_id' => $uitdagingId,
            ],
            [
                'uitdaging_id' => $uitdagingId,
                'token' => $randomToken,
            ]
        );

        // Update the token if the Validatie already exists
        if (!$validatie->wasRecentlyCreated) {
            $validatie->token = $randomToken;
            $validatie->save();
        }
        $this->token = $randomToken;

        $this->hasValidatie = true;
    }

    public function deleteToken()
    {
        // Set the token property to null
        $this->token = null;

        // Find the Validatie record for the current user and deelthema
        $validatie = Validatie::where('deelthema_id', $this->deelthema->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($validatie) {
            // Clear the token in the database
            $validatie->token = null;
            $validatie->save();
        }

        $this->hasValidatie = false;
    }

    public function resetVoltooid()
    {
        // Find the Validatie record with voltooid set to true for the current user and deelthema
        $validatie = Validatie::where('deelthema_id', $this->deelthema->id)
            ->where('user_id', auth()->id())
            ->where('voltooid', true) // Filter for the voltooid true records
            ->first();

        if ($validatie) {
            $validatie->voltooid = 0;
            $validatie->validatie_antwoord = null;
            $validatie->feedback = null;
            $validatie->save();

            // Show a success message
            session()->flash('message', 'Validation status has been reset successfully.');

            return redirect()->route('deelthema', ['id' => $this->deelthema->id]);
        } else {
            // how an error message if no matching record is found
            session()->flash('error', 'No completed validation found to reset.');
        }
    }

    public function render()
    {
        return view('livewire.deelthema', [
            'deelthema' => $this->deelthema,
            'videoId' => $this->videoId,
            'uitdaging' => $this->uitdaging,
            'opdrachten' => $this->opdrachten,
            'hasValidatie' => $this->hasValidatie,
            'correctValidatie' => $this->correctValidatie,
            'uitdagingVoltooid' => $this->uitdagingVoltooid,
            'token' => $this->token,
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
