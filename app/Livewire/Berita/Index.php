<?php

namespace App\Livewire\Berita;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Berita;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sort = 'terbaru';

    protected $paginationTheme = 'bootstrap'; // agar pagination pakai bootstrap

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Berita::query();

        // Fitur pencarian
        if ($this->search) {
            $query->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
        }

        // Fitur pengurutan
        if ($this->sort === 'terpopuler') {
            $query->orderBy('hits', 'desc');
        } elseif ($this->sort === 'terlama') {
            $query->orderBy('tanggal', 'asc');
        } else {
            $query->orderBy('tanggal', 'desc');
        }

        $beritas = $query->paginate(9);

        return view('livewire.berita.index', [
            'beritas' => $beritas
        ]);
    }
}
