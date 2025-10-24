<?php

namespace App\Livewire\Galeri;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KategoriFoto;
use App\Models\Video;

class Index extends Component
{
    use WithPagination;

    public $activeTab = 'foto';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function render()
    {
        $kategoriFotos = KategoriFoto::with(['fotos' => function($query) {
            $query->oldest()->take(1);
        }])
        ->latest('tanggal')
        ->paginate(12);

        $videos = Video::latest('tanggal')->paginate(12);

        return view('livewire.galeri.index', [
            'kategoriFotos' => $kategoriFotos,
            'videos' => $videos,
        ]);
    }
}
