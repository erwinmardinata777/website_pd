<?php

namespace App\Livewire\Dokumen;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Dokumen;
use App\Models\KategoriDokumen;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterKategori = '';
    public $filterType = '';
    public $sortBy = 'terbaru';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterKategori' => ['except' => ''],
        'filterType' => ['except' => ''],
        'sortBy' => ['except' => 'terbaru'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterKategori()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function downloadDokumen($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        
        // Increment download counter
        $dokumen->increment('download');
        $dokumen->increment('hits');

        // Redirect to file
        if ($dokumen->file) {
            return redirect()->to(Storage::url($dokumen->file));
        } elseif ($dokumen->url) {
            return redirect()->to($dokumen->url);
        }
    }

    public function render()
    {
        // Get kategoris with filtered dokumens
        $query = KategoriDokumen::with(['dokumens' => function($q) {
            $q->where('status', 1);

            // Search
            if ($this->search) {
                $q->where(function($query) {
                    $query->where('judul', 'like', '%' . $this->search . '%')
                          ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
                });
            }

            // Filter by type
            if ($this->filterType) {
                $q->where('type_file', $this->filterType);
            }

            // Sort
            switch ($this->sortBy) {
                case 'terbaru':
                    $q->orderBy('tanggal', 'desc');
                    break;
                case 'terlama':
                    $q->orderBy('tanggal', 'asc');
                    break;
                case 'populer':
                    $q->orderBy('download', 'desc');
                    break;
                case 'nama':
                    $q->orderBy('judul', 'asc');
                    break;
            }
        }]);

        // Filter by kategori if selected
        if ($this->filterKategori) {
            $query->where('id', $this->filterKategori);
        }

        // Only get kategoris that have dokumens
        $query->has('dokumens');

        $kategoris = $query->get();

        // Get all kategoris for filter
        $allKategoris = KategoriDokumen::withCount(['dokumens' => function($q) {
            $q->where('status', 1);
        }])->get();

        // Statistics
        $totalDokumen = Dokumen::where('status', 1)->count();
        $totalDownload = Dokumen::sum('download');
        $totalKategori = KategoriDokumen::has('dokumens')->count();

        return view('livewire.dokumen.index', [
            'kategoris' => $kategoris,
            'allKategoris' => $allKategoris,
            'totalDokumen' => $totalDokumen,
            'totalDownload' => $totalDownload,
            'totalKategori' => $totalKategori,
        ]);
    }
}
