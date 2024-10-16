<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Zelftoets;

class DashboardComp extends Component
{
    public $zelftoets;
    public $deelthemaId;

    public function mount()
    {
        $this->zelftoets = Zelftoets::with(['hoofdthema', 'deelthema', 'uitdaging'])
            ->where('user_id', Auth::id())
            ->get();
    }

    public function toDeelthema($id)
    {
        $this->deelthemaId = $id;
        return redirect()->route('deelthema', ['id' => $id]);
    }

    public function render()
    {
        if ($this->deelthemaId) {
            // Render the deelthema view with the passed ID
            return view('livewire.deelthema', ['id' => $this->deelthemaId]);
        }
        return view('livewire.dashboard')->layout('layouts.app');

    }
}
