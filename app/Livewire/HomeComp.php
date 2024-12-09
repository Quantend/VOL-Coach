<?php

namespace App\Livewire;

use App\Models\Home;
use Livewire\Component;

class HomeComp extends Component
{
    public $home;
    public $videoId;

    public function mount()
    {
        $this->home = Home::first();

        if ($this->home && !empty($this->home->media)) {
            // Roep de extractVideoId-methode aan om het ID te extraheren
            $this->extractVideoId($this->home->media);
        } else {
            $this->videoId = null; // Geen media gevonden
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

    public function render()
    {
        return view('livewire.home')->layout('layouts.app');
    }
}
