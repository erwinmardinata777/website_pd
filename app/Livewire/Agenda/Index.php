<?php

namespace App\Livewire\Agenda;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Agenda;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterMonth = '';
    public $filterStatus = '';
    public $viewMode = 'upcoming'; // upcoming, all, past

    protected $queryString = [
        'search' => ['except' => ''],
        'filterMonth' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'viewMode' => ['except' => 'upcoming'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterMonth()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
        $this->resetPage();
    }

    public function render()
    {
        $query = Agenda::query();

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('agenda', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                  ->orWhere('tempat', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by month
        if ($this->filterMonth) {
            $query->whereMonth('tanggal', $this->filterMonth)
                  ->whereYear('tanggal', date('Y'));
        }

        // Filter by status
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        // View mode filter
        switch ($this->viewMode) {
            case 'upcoming':
                $query->where('tanggal', '>=', now()->toDateString())
                      ->orderBy('tanggal', 'asc');
                break;
            case 'past':
                $query->where('tanggal', '<', now()->toDateString())
                      ->orderBy('tanggal', 'desc');
                break;
            case 'all':
                $query->orderBy('tanggal', 'desc');
                break;
        }

        $agendas = $query->paginate(12);

        // Statistics
        $totalAgenda = Agenda::count();
        $upcomingCount = Agenda::where('tanggal', '>=', now()->toDateString())->count();
        $todayCount = Agenda::whereDate('tanggal', now()->toDateString())->count();
        $thisMonthCount = Agenda::whereMonth('tanggal', now()->month)
                                 ->whereYear('tanggal', now()->year)
                                 ->count();

        return view('livewire.agenda.index', [
            'agendas' => $agendas,
            'totalAgenda' => $totalAgenda,
            'upcomingCount' => $upcomingCount,
            'todayCount' => $todayCount,
            'thisMonthCount' => $thisMonthCount,
        ]);
    }
}
