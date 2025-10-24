<?php

namespace App\Livewire\Bidang;

use Livewire\Component;
use App\Models\Bidang;

class Detail extends Component
{
    public $id;
    public $bidang;

    public function mount($id)
    {
        $this->bidang = Bidang::with(['pegawais' => function($query) {
            $query->orderBy('jabatan', 'asc');
        }])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.bidang.detail');
    }
}
