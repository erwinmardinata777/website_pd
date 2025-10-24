<?php

namespace App\Livewire\TentangKami;

use Livewire\Component;
use App\Models\ProfilWeb;

class Index extends Component
{
    public $profil;

    public function mount()
    {
        // Get only first data (karena hanya 1 data)
        $this->profil = ProfilWeb::first();
    }

    public function render()
    {
        return view('livewire.tentang-kami.index');
    }
}
