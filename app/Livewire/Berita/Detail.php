<?php

namespace App\Livewire\Berita;

use Livewire\Component;
use App\Models\Berita;

class Detail extends Component
{
    public $slug;
    public $berita;
    public $beritaTerkait;
    public $beritaPopuler;

    // Lifecycle mount untuk ambil data berdasarkan slug
    public function mount($slug)
    {
        $this->berita = Berita::where('slug', $slug)->firstOrFail();

        // Tambahkan hit view setiap kali halaman dibuka
        $this->berita->increment('hits');

        // Ambil berita terkait (3 berita terbaru selain berita ini)
        $this->beritaTerkait = Berita::where('id', '!=', $this->berita->id)
            ->latest('tanggal')
            ->take(3)
            ->get();

        // Ambil berita populer (berdasarkan hits)
        $this->beritaPopuler = Berita::orderBy('hits', 'desc')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.berita.detail', [
            'berita' => $this->berita,
            'beritaTerkait' => $this->beritaTerkait,
            'beritaPopuler' => $this->beritaPopuler,
        ])->title($this->berita->judul . ' - Diskominfo Kabupaten Sumbawa');
    }
}
