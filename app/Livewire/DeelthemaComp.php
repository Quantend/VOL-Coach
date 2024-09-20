<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deelthema;

class DeelthemaComp extends Component
{
    public $deelthema;
    public $videoId;

    public function mount($deelthema)
    {
        $this->deelthema = Deelthema::where('naam', $deelthema)->firstOrFail();
        $this->extractVideoId($this->deelthema->media);
    }

    public function extractVideoId($url)
    {
        // Parse the URL and extract the query parameters
        $parsedUrl = parse_url($url);
        parse_str($parsedUrl['query'], $queryParams);

        // Set the videoId property if it exists
        if (isset($queryParams['v'])) {
            $this->videoId = $queryParams['v'];
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
