<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Hoofdthema;

class HoofdthemaComp extends Component
{
    public $hoofdthemas;
    public $selectedHoofdthema;
    public $showHoofdthemaList = true;

    public function mount()
    {
        $this->hoofdthemas = Hoofdthema::with('deelthemas')->get();
    }

    public function selectHoofdthema($hoofdthemaId)
    {
        $this->selectedHoofdthema = Hoofdthema::with('deelthemas')->find($hoofdthemaId);
        $this->showHoofdthemaList = false;
    }

    public function backToHoofdthemaList()
    {
        $this->showHoofdthemaList = true;
        $this->selectedHoofdthema = false;
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
