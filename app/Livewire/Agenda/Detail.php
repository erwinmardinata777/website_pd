<?php

namespace App\Livewire\Agenda;

use Livewire\Component;
use App\Models\Agenda;
use Carbon\Carbon;

class Detail extends Component
{
    public $slug;
    public $agenda;
    public $agendaTerkait;

    public function mount($slug)
    {
        $this->agenda = Agenda::where('slug', $slug)->firstOrFail();
        
        // Get related agendas (same month, exclude current)
        $this->agendaTerkait = Agenda::where('id', '!=', $this->agenda->id)
            ->whereMonth('tanggal', Carbon::parse($this->agenda->tanggal)->month)
            ->whereYear('tanggal', Carbon::parse($this->agenda->tanggal)->year)
            ->latest('tanggal')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.agenda.detail');
    }
}
