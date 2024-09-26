<?php

namespace App\Livewire;

use App\Models\Home;
use Livewire\Component;

class HomeComp extends Component
{
    public $home;

    public function mount()
    {
        $this->home = Home::first();
    }

    public function render()
    {
        return view('livewire.home')->layout('layouts.app');
    }
}
