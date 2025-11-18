<?php

namespace App\Livewire\LowonganKerja;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LowonganKerja;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Properties
    public $search = '';
    public $perPage = 9;
    public $sortBy = 'latest'; // latest, oldest

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Reset pagination when sort changes
    public function updatingSortBy()
    {
        $this->resetPage();
    }

    // Clear search
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    // Change per page
    public function changePerPage($value)
    {
        $this->perPage = $value;
        $this->resetPage();
    }

    public function render()
    {
        // Query builder
        $query = LowonganKerja::with('fotoLowongans');

        // Search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('nama_perusahaan', 'like', '%' . $this->search . '%')
                  ->orWhere('alamat', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            });
        }

        // Sort
        if ($this->sortBy === 'latest') {
            $query->latest('tanggal');
        } elseif ($this->sortBy === 'oldest') {
            $query->oldest('tanggal');
        }

        // Paginate
        $lowonganKerjas = $query->paginate($this->perPage);

        // Statistics
        $totalLowongan = LowonganKerja::count();
        $lowonganBulanIni = LowonganKerja::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        return view('livewire.lowongan-kerja.index', [
            'lowonganKerjas' => $lowonganKerjas,
            'totalLowongan' => $totalLowongan,
            'lowonganBulanIni' => $lowonganBulanIni,
        ]);
    }
}