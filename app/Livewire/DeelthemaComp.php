<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deelthema;

class DeelthemaComp extends Component
{
    public $deelthema;
    public $videoId;

    public function mount($id)
    {
        $this->deelthema = Deelthema::findOrFail($id);
        $this->extractVideoId($this->deelthema->media);
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


    public function backToHoofdthema(){
        return redirect()->route('hoofdthema');
    }

    public function render()
    {
        return view('livewire.deelthema', [
            'deelthema' => $this->deelthema,
            'videoId' => $this->videoId,
        ])->layout('layouts.app');
    }
}
