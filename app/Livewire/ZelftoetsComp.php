<?php

namespace App\Livewire;

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
            'antwoorden.*' => 'required|integer|min:1|max:5',
        ]);

        $uitslagArray = [];
        $deelthemaScores = [];

        foreach ($this->antwoorden as $index => $antwoord) {
            $vraag = $this->vragen[$index];

            // Opslaan van het antwoord per vraag
            $uitslagArray[] = [
                'vraag_id' => $index,
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

        // Zelftoets opslaan in de database
        Zelftoets::create([
            'hoofdthema_id' => $this->hoofdthemaId,
            'user_id' => auth()->id(),
            'uitslag' => $uitslagArray,
        ]);

        // Bereken de laagste gemiddelde score per deelthema
        $laagsteDeelthemaId = null;
        $laagsteGemiddelde = PHP_FLOAT_MAX; // Start met een zeer hoge waarde

        foreach ($deelthemaScores as $deelthemaId => $scoreData) {
            $gemiddeldeScore = $scoreData['total_score'] / $scoreData['question_count'];

            // Zoek de laagste gemiddelde score
            if ($gemiddeldeScore < $laagsteGemiddelde) {
                $laagsteGemiddelde = $gemiddeldeScore;
                $laagsteDeelthemaId = $deelthemaId;
            }
        }

        // Redirect naar het deelthema met de laagste score
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
