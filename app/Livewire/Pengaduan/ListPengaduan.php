<?php

namespace App\Livewire\Pengaduan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\DB;

class ListPengaduan extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'semua';
    public $sortBy = 'terbaru';
    public $filterMonth = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => 'semua'],
        'sortBy' => ['except' => 'terbaru'],
        'filterMonth' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function updatingFilterMonth()
    {
        $this->resetPage();
    }

    public function setFilterStatus($status)
    {
        $this->filterStatus = $status;
        $this->resetPage();
    }

    public function getStatisticsProperty()
    {
        return [
            'total' => Pengaduan::count(),
            'baru' => Pengaduan::where('status', 'baru')->count(),
            'proses' => Pengaduan::where('status', 'proses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
        ];
    }

    public function render()
    {
        $query = Pengaduan::with(['kecamatan', 'desa']);

        // Filter by search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('pengaduan', 'like', '%' . $this->search . '%')
                  ->orWhere('isi_pengaduan', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by status
        if ($this->filterStatus !== 'semua') {
            $query->where('status', $this->filterStatus);
        }

        // Filter by month
        if ($this->filterMonth) {
            $query->whereMonth('tanggal_pengaduan', $this->filterMonth)
                  ->whereYear('tanggal_pengaduan', date('Y'));
        }

        // Sort
        switch ($this->sortBy) {
            case 'terbaru':
                $query->orderBy('tanggal_pengaduan', 'desc');
                break;
            case 'terlama':
                $query->orderBy('tanggal_pengaduan', 'asc');
                break;
            case 'populer':
                // Assuming you add a 'views' column later
                $query->orderBy('id', 'desc'); // temporary
                break;
        }

        $pengaduans = $query->paginate(10);

        return view('livewire.pengaduan.list-pengaduan', [
            'pengaduans' => $pengaduans,
            'statistics' => $this->statistics,
        ]);
    }
}
