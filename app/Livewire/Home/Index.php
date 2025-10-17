<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Slider;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Layanan;
use App\Models\LinkTerkait;

class Index extends Component
{
    public $sliders;
    public $agendas;
    public $beritas;
    public $layanans;
    public $links;

    public function mount()
    {
        // Ambil data untuk ditampilkan di halaman beranda
        $this->sliders = Slider::latest()->get();
        $this->agendas = Agenda::latest()->take(6)->get(); // contoh hanya 5 agenda terakhir
        $this->beritas = Berita::latest()->take(5)->get(); // contoh hanya 5 berita terakhir
        $this->layanans = Layanan::orderBy('id', 'asc')->get();
        $this->links = LinkTerkait::orderBy('id', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.home.index');
    }
}
