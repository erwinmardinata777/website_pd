<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Slider;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Layanan;
use App\Models\LinkTerkait;
use App\Models\Pegawai;
use App\Models\ProfilWeb;
use App\Models\Pengaduan;
use App\Models\KategoriFoto;
use App\Models\Foto;
use App\Models\Video;

class Index extends Component
{
    public $sliders;
    public $agendas;
    public $beritas;
    public $layanans;
    public $links;
    public $pegawais;
    public $profil;

    // Statistik pengaduan
    public $totalPengaduan;
    public $pengaduanSelesai;
    public $pengaduanProses;
    public $pengaduanBaru;
    public $pengaduanTerbaru;

    // Galeri
    public $kategoriFotos;
    public $videos;
    public $featuredKategori;

    public function mount()
    {
        $this->sliders = Slider::latest()->get();
        $this->agendas = Agenda::latest()->take(6)->get();
        $this->beritas = Berita::latest()->take(5)->get();
        $this->layanans = Layanan::orderBy('id', 'asc')->get();
        $this->links = LinkTerkait::orderBy('id', 'asc')->get();
        $this->pegawais = Pegawai::orderBy('id', 'asc')->get();
        $this->profil = ProfilWeb::first();

        // Statistik pengaduan
        $this->totalPengaduan = Pengaduan::count();
        $this->pengaduanSelesai = Pengaduan::where('status', 'selesai')->count();
        $this->pengaduanProses = Pengaduan::where('status', 'proses')->count();
        $this->pengaduanBaru = Pengaduan::where('status', 'baru')->count();
        $this->pengaduanTerbaru = Pengaduan::latest('tanggal_pengaduan')->take(5)->get();

        // Galeri - Ambil kategori dengan foto pertama
        $this->kategoriFotos = KategoriFoto::with(['fotos' => function($query) {
            $query->oldest()->take(1); // Ambil foto pertama
        }])
        ->latest('tanggal')
        ->take(9) // Ambil 9 kategori
        ->get();

        // Featured kategori (yang terbaru dengan hits terbanyak)
        $this->featuredKategori = KategoriFoto::with(['fotos' => function($query) {
            $query->oldest()->take(1);
        }])
        ->orderBy('hits', 'desc')
        ->first();

        // Videos - Ambil 6 video terbaru
        $this->videos = Video::latest('tanggal')->take(6)->get();
    }

    public function render()
    {
        return view('livewire.home.index');
    }
}
