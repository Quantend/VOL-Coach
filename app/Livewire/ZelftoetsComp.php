<?php

namespace App\Livewire;

use App\Models\Uitdaging;
use App\Models\Validatie;
use Livewire\Component;
use App\Models\Deelthema;
use App\Models\Zelftoets;

class ZelftoetsComp extends Component
{
    public $deelthemas;
    public $vragen = [];
    public $antwoorden = [];
    public $hoofdthemaId;

    public function mount($hoofdthema)
    {
        $this->hoofdthemaId = $hoofdthema;
        $this->deelthemas = Deelthema::where('hoofdthema_id', $hoofdthema)->get();

        foreach ($this->deelthemas as $deelthema) {
            $vragen = is_array($deelthema->vragen) ? $deelthema->vragen : json_decode($deelthema->vragen, true);

            if (is_array($vragen)) {
                foreach ($vragen as $vraag) {
                    if (isset($vraag['vraag'])) {
                        $this->vragen[] = [
                            'vraag' => $vraag['vraag'],
                            'deelthema_id' => $deelthema->id,
                        ];
                    }
                }
            }
        }
    }

    public function saveAntwoorden()
    {
        $this->validate([
            'antwoorden' => 'required|array',
            'antwoorden.*' => 'nullable|integer|min:1|max:5', // Antwoorden kunnen 'nullable' zijn om ze later op 3 te zetten
        ]);

        $uitslagArray = [];
        $deelthemaScores = [];

        foreach ($this->vragen as $index => $vraag) {
            // Als het antwoord niet is ingevuld, zet het op 3
            $antwoord = $this->antwoorden[$index] ?? 3;

            // Opslaan van het antwoord per vraag
            $uitslagArray[] = [
                'vraag' => $vraag['vraag'],
                'deelthema_id' => $vraag['deelthema_id'],
                'antwoord' => $antwoord,
            ];

            // Bereken het gemiddelde per deelthema
            if (!isset($deelthemaScores[$vraag['deelthema_id']])) {
                $deelthemaScores[$vraag['deelthema_id']] = [
                    'total_score' => 0,
                    'question_count' => 0,
                ];
            }

            // Tel het antwoord op bij het deelthema
            $deelthemaScores[$vraag['deelthema_id']]['total_score'] += $antwoord;
            $deelthemaScores[$vraag['deelthema_id']]['question_count'] += 1;
        }

        // Bereken de laagste gemiddelde score per deelthema
        $laagsteDeelthemaId = null;
        $laagsteGemiddelde = PHP_FLOAT_MAX;

        foreach ($deelthemaScores as $deelthemaId => $scoreData) {
            $gemiddeldeScore = $scoreData['total_score'] / $scoreData['question_count'];

            if ($gemiddeldeScore < $laagsteGemiddelde) {
                $laagsteGemiddelde = $gemiddeldeScore;
                $laagsteDeelthemaId = $deelthemaId;
            }
        }

        // Zoek de juiste uitdaging op basis van deelthema_id en niveau
        $uitdaging = null;
        if ($laagsteDeelthemaId !== null) {
            $niveau = '';

            if ($laagsteGemiddelde <= 3) {
                $niveau = 'experimenteren';
            } elseif ($laagsteGemiddelde > 3 && $laagsteGemiddelde <= 4) {
                $niveau = 'toepassen';
            } else {
                $niveau = 'verdiepen';
            }

            $uitdaging = Uitdaging::where('deelthema_id', $laagsteDeelthemaId)
                ->where('niveau', $niveau)
                ->first();
        }

        // Verwijder de oude zelftoets als deze bestaat
        $existingZelftoets = Zelftoets::where('hoofdthema_id', $this->hoofdthemaId)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingZelftoets) {
            $existingZelftoets->delete();
        }

        // Maak de zelftoets aan met de juiste uitdaging_id
        $zelftoets = Zelftoets::create([
            'hoofdthema_id' => $this->hoofdthemaId,
            'deelthema_id' => $laagsteDeelthemaId,
            'user_id' => auth()->id(),
            'uitslag' => $uitslagArray,
            'uitdaging_id' => $uitdaging ? $uitdaging->id : null,
        ]);

        $existingValidatie = Validatie::where('deelthema_id', $this->hoofdthemaId)
            ->where('user_id', auth()->id())
            ->first();
        if ($existingValidatie) {
            $existingValidatie->delete();
        }

        $validatie = Validatie::create([
            'deelthema_id' => $laagsteDeelthemaId,
            'user_id' => auth()->id(),
            'uitdaging_id' => $uitdaging ? $uitdaging->id : null,
            'voltooid' => 0,
        ]);

        return redirect()->route('deelthema', ['id' => $laagsteDeelthemaId]);
    }


    public function render()
    {
        return view('livewire.zelftoets', [
            'deelthemas' => $this->deelthemas,
            'vragen' => $this->vragen,
        ])->layout('layouts.app');
    }
}
