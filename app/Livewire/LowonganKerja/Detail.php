<?php

namespace App\Livewire\LowonganKerja;

use Livewire\Component;
use App\Models\LowonganKerja;

class Detail extends Component
{
    public $id;
    public $lowongan;

    public function mount($id)
    {
        $this->lowongan = LowonganKerja::with('fotoLowongans')->findOrFail($id);
    }

    public function render()
    {
        // Lowongan terkait (random 3)
        $relatedLowongan = LowonganKerja::with('fotoLowongans')
            ->where('id', '!=', $this->lowongan->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('livewire.lowongan-kerja.detail', [
            'relatedLowongan' => $relatedLowongan,
        ]);
    }
}