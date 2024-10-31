<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Validatie;

class ValidatieComp extends Component
{
    public Validatie $validatie;

    public function mount(Validatie $validatie)
    {
        $this->validatie = $validatie;
    }

    public function render()
    {
        return view('livewire.validatie', ['validatie' => $this->validatie]);
    }
}
