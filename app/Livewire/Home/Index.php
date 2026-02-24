<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Slider;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Bidang;
use App\Models\LinkTerkait;
use App\Models\Pegawai;
use App\Models\ProfilWeb;
use App\Models\Pengaduan;
use App\Models\KategoriFoto;
use App\Models\Foto;
use App\Models\Video;
use App\Models\LowonganKerja;

class Index extends Component
{
    public $sliders;
    public $agendas;
    public $beritas;
    public $bidangs;
    public $links;
    public $pegawais;
    public $profil;
    public $lowonganKerjas;

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

    // Tenant info
    public $currentTenant;
    public $isMainDomain;

    public function mount()
    {
        // Get tenant info from config
        $this->currentTenant = config('app.current_tenant');
        $this->isMainDomain = config('app.is_main_domain', false);

        // ✅ Jika main domain tanpa tenant, redirect ke daftar OPD
        if ($this->isMainDomain && !$this->currentTenant) {
            return redirect()->route('daftar-opd');
        }

        // ✅ Jika tidak ada tenant sama sekali (seharusnya sudah di-handle middleware)
        if (!$this->currentTenant) {
            return redirect()->away('https://web-pd.sumbawakab.go.id/daftar-opd');
        }

        // Data akan otomatis ter-filter oleh TenantScope
        $this->sliders = Slider::latest()->get();
        $this->agendas = Agenda::latest()->take(6)->get();
        $this->beritas = Berita::latest()->take(5)->get();
        
        $this->bidangs = Bidang::withCount('pegawais')
            ->orderBy('nama_bidang', 'asc')
            ->take(6)
            ->get();
        
        $this->links = LinkTerkait::orderBy('id', 'asc')->get();
        $this->pegawais = Pegawai::orderBy('id', 'asc')->get();
        $this->profil = ProfilWeb::first();

        // Statistik pengaduan
        $this->totalPengaduan = Pengaduan::count();
        $this->pengaduanSelesai = Pengaduan::where('status', 2)->count();
        $this->pengaduanProses = Pengaduan::where('status', 1)->count();
        $this->pengaduanBaru = Pengaduan::where('status', 0)->count();
        $this->pengaduanTerbaru = Pengaduan::latest('tanggal_pengaduan')->take(5)->get();
        $this->lowonganKerjas = LowonganKerja::with('fotoLowongans')->latest('tanggal')->take(3)->get();
        
        // Galeri
        $this->kategoriFotos = KategoriFoto::with(['fotos' => function($query) {
            $query->oldest()->take(1);
        }])
        ->latest('tanggal')
        ->take(9)
        ->get();

        $this->featuredKategori = KategoriFoto::with(['fotos' => function($query) {
            $query->oldest()->take(1);
        }])
        ->orderBy('hits', 'desc')
        ->first();

        $this->videos = Video::latest('tanggal')->take(6)->get();
    }

    public function render()
    {
        return view('livewire.home.index');
    }
}
