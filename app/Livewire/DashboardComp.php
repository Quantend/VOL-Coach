<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Zelftoets;
use App\Models\Validatie;

class DashboardComp extends Component
{
    public $zelftoets;
    public $deelthemaId;
    public $validatie;
    public $showVoltooid = false;
    public $showFeedback = false;
    public $filterStatus = 'all';

    public function mount()
    {
        $this->zelftoets = Zelftoets::with(['hoofdthema', 'deelthema', 'uitdaging'])
            ->where('user_id', Auth::id())
            ->get();

        if ($this->zelftoets->isNotEmpty()) {
            $uitdagingIds = $this->zelftoets->pluck('uitdaging_id')->unique();

            // Fetch Validatie records that match the user and the eerste uitdaging_id
            $this->validatie = Validatie::where('user_id', Auth::id())
                ->whereIn('uitdaging_id', $uitdagingIds)
                ->get();
        }
    }

    public function toDeelthema($id)
    {
        $this->deelthemaId = $id;
        return redirect()->route('deelthema', ['id' => $id]);
    }

    public function getFilteredData()
    {
        return match ($this->filterStatus) {
            'all' => $this->zelftoets,
            'completed' => $this->zelftoets->filter(function ($toets) {
                return $this->validatie
                    ->where('uitdaging_id', $toets->uitdaging_id)
                    ->where('voltooid', true)
                    ->isNotEmpty();
            }),
            'incomplete' => $this->zelftoets->filter(function ($toets) {
                return $this->validatie
                    ->where('uitdaging_id', $toets->uitdaging_id)
                    ->where('voltooid', false)
                    ->isNotEmpty();
            }),
        };
    }

    public function render()
    {
        if ($this->deelthemaId) {
            // Render the deelthema view with the passed ID
            return view('livewire.deelthema', ['id' => $this->deelthemaId]);
        }

        return view('livewire.inzichten', [
            'filteredZelftoets' => $this->getFilteredData(),
        ])->layout('layouts.app');
    }

    public function toggleFeedback()
    {
        $this->showFeedback = !$this->showFeedback;
    }
}
