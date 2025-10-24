<?php

namespace App\Livewire\Layanan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Layanan;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Layanan::query();

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_layanan', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi_singkat', 'like', '%' . $this->search . '%');
            });
        }

        $layanans = $query->latest()->paginate(9);
        $totalLayanan = Layanan::count();

        return view('livewire.layanan.index', [
            'layanans' => $layanans,
            'totalLayanan' => $totalLayanan,
        ]);
    }
}
