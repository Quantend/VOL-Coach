<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Hoofdthema;

class HoofdthemaComp extends Component
{
    public $hoofdthemas;
    public $selectedHoofdthema;
    public $showHoofdthemaList = true;
    public $videoId;

    public function mount()
    {
        $this->hoofdthemas = Hoofdthema::with('deelthemas')->get();
    }

    public function selectHoofdthema($hoofdthemaId)
    {
        $this->selectedHoofdthema = Hoofdthema::with('deelthemas')->find($hoofdthemaId);
        $this->extractVideoId($this->selectedHoofdthema->media);
        $this->showHoofdthemaList = false;
    }

    public function backToHoofdthemaList()
    {
        $this->showHoofdthemaList = true;
        $this->selectedHoofdthema = false;
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

    public function startZelfscoreToets()
    {
        return redirect()->route('zelftoets', ['hoofdthema' => $this->selectedHoofdthema->id]);
    }

    public function render()
    {
        return view('livewire.hoofdthema', [
            'hoofdthemas' => $this->hoofdthemas,
            'selectedHoofdthema' => $this->selectedHoofdthema,
            'showHoofdthemaList' => $this->showHoofdthemaList,
            ])->layout('layouts.app');
    }
}
