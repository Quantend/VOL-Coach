<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deelthema;
use App\Models\Uitdaging;
use App\Models\Zelftoets;

class DeelthemaComp extends Component
{
    public $deelthema;
    public $uitdaging;
    public $videoId;
    public $opdrachten = [];

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

    public function render()
    {
        return view('livewire.deelthema', [
            'deelthema' => $this->deelthema,
            'videoId' => $this->videoId,
            'uitdaging' => $this->uitdaging,
            'opdrachten' => $this->opdrachten,
        ])->layout('layouts.app');
    }
}
