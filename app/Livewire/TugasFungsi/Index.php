<?php

namespace App\Livewire\TugasFungsi;

use Livewire\Component;
use App\Models\TugasFungsi;

class Index extends Component
{
    public $tugasFungsi;

    public function mount()
    {
        // Get only first data (karena hanya 1 data)
        $this->tugasFungsi = TugasFungsi::first();
    }

    public function render()
    {
        return view('livewire.tugas-fungsi.index');
    }
}
