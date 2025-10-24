<?php

namespace App\Livewire\Layanan; // FIX: Hapus \Detail di namespace

use Livewire\Component;
use App\Models\Layanan;

class Detail extends Component
{
    public $slug;
    public $layanan;
    public $layananTerkait;

    public function mount($slug)
    {
        $this->layanan = Layanan::where('slug', $slug)->firstOrFail();
        
        // Get related services (exclude current)
        $this->layananTerkait = Layanan::where('id', '!=', $this->layanan->id)
            ->latest()
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.layanan.detail');
    }
}
