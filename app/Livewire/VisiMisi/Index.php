<?php

namespace App\Livewire\VisiMisi;

use Livewire\Component;
use App\Models\Visi;
use App\Models\Misi;

class Index extends Component
{
    public $visi;
    public $misis;

    public function mount()
    {
        // Get visi (hanya 1 data)
        $this->visi = Visi::first();
        
        // Get all misi (lebih dari 1)
        $this->misis = Misi::orderBy('id', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.visi-misi.index');
    }
}
