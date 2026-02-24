<?php

namespace App\Livewire\DaftarOpd;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Opd;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Ambil semua user yang punya subdomain dan OPD
        $opdList = User::with('opd')
            ->whereNotNull('subdomain')
            ->whereNotNull('opds_id')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('subdomain', 'like', '%' . $this->search . '%')
                      ->orWhereHas('opd', function ($opdQuery) {
                          $opdQuery->where('nama_opd', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->whereHas('opd', function ($opdQuery) {
                    $opdQuery->where('status', $this->filterStatus);
                });
            })
            ->orderBy('name')
            ->paginate(12);

        return view('livewire.daftar-opd.index', [
            'opdList' => $opdList,
        ]);
    }
}
