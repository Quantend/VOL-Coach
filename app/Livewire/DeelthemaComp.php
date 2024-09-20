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
        // Check if the URL is empty or invalid
        if (empty($url)) {
            $this->videoId = null;  // Set videoId to null or handle the error as needed
            return;  // Exit the function early
        }

        // Parse the URL and extract the query parameters
        $parsedUrl = parse_url($url);

        // Ensure that the 'query' part exists in the parsed URL
        if (!isset($parsedUrl['query'])) {
            $this->videoId = null;  // Handle case where the URL does not contain a query string
            return;  // Exit the function early
        }

        // Parse the query string into an array of parameters
        parse_str($parsedUrl['query'], $queryParams);

        // Check if the 'v' parameter exists (the video ID)
        if (isset($queryParams['v'])) {
            $this->videoId = $queryParams['v'];  // Set videoId to the extracted video ID
        } else {
            $this->videoId = null;  // If no 'v' parameter, handle as needed
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
