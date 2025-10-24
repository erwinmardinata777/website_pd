<?php

namespace App\Livewire\StrukturOrganisasi;

use Livewire\Component;
use App\Models\Pegawai;
use App\Models\Bidang;

class Index extends Component
{
    public $search = '';
    public $filterBidang = '';
    public $viewMode = 'grid'; // Default ke grid

    protected $queryString = [
        'search' => ['except' => ''],
        'filterBidang' => ['except' => ''],
        'viewMode' => ['except' => 'grid'],
    ];

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    public function render()
    {
        // Get top-level pegawai (yang tidak punya parent/atasan)
        $query = Pegawai::with(['bawahan.bawahan', 'bidang'])
            ->whereNull('parent');

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('jabatan', 'like', '%' . $this->search . '%')
                  ->orWhere('nip', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by bidang
        if ($this->filterBidang) {
            $query->where('bidangs_id', $this->filterBidang);
        }

        $pegawais = $query->orderBy('jabatan', 'asc')->get();

        // Get all pegawai for grid view
        $allPegawais = Pegawai::with('bidang')
            ->when($this->search, function($q) {
                $q->where(function($query) {
                    $query->where('nama', 'like', '%' . $this->search . '%')
                          ->orWhere('jabatan', 'like', '%' . $this->search . '%')
                          ->orWhere('nip', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterBidang, function($q) {
                $q->where('bidangs_id', $this->filterBidang);
            })
            ->orderBy('jabatan', 'asc')
            ->get();

        // Get bidangs for filter
        $bidangs = Bidang::withCount('pegawais')->get();

        // Statistics
        $totalPegawai = Pegawai::count();
        $totalBidang = Bidang::count();
        $pejabatStruktural = Pegawai::whereNull('parent')->count();

        return view('livewire.struktur-organisasi.index', [
            'pegawais' => $pegawais,
            'allPegawais' => $allPegawais,
            'bidangs' => $bidangs,
            'totalPegawai' => $totalPegawai,
            'totalBidang' => $totalBidang,
            'pejabatStruktural' => $pejabatStruktural,
        ]);
    }
}
