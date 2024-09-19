<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deelthema;

class DeelthemaComp extends Component
{
    public $deelthema;

    public function mount($deelthema)
    {
        $this->deelthema = Deelthema::where('naam', $deelthema)->firstOrFail();
    }

    public function backToHoofdthema(){
        return redirect()->route('hoofdthema');
    }

    public function render()
    {
        return view('livewire.deelthema', [
            'deelthema' => $this->deelthema,
        ])->layout('layouts.app');
    }
}
