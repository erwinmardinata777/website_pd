<?php

namespace App\Livewire\Galeri;

use Livewire\Component;
use App\Models\KategoriFoto;

class FotoDetail extends Component
{
    public $slug;
    public $kategori;

    public function mount($slug)
    {
        $this->kategori = KategoriFoto::with('fotos')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment hits
        $this->kategori->increment('hits');
    }

    public function render()
    {
        return view('livewire.galeri.foto-detail');
    }
}
