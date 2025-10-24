<?php

namespace App\Livewire\Bidang;

use Livewire\Component;
use App\Models\Bidang;

class Index extends Component
{
    public $search = '';

    public function render()
    {
        $bidangs = Bidang::withCount('pegawais')
            ->when($this->search, function($query) {
                $query->where('nama_bidang', 'like', '%' . $this->search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nama_bidang', 'asc')
            ->get();

        $totalBidang = Bidang::count();
        $totalPegawai = \App\Models\Pegawai::whereNotNull('bidangs_id')->count();

        return view('livewire.bidang.index', [
            'bidangs' => $bidangs,
            'totalBidang' => $totalBidang,
            'totalPegawai' => $totalPegawai,
        ]);
    }
}
