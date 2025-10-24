<?php

namespace App\Livewire\Pegawai;

use Livewire\Component;
use App\Models\Pegawai;

class Detail extends Component
{
    public $id;
    public $pegawai;

    public function mount($id)
    {
        $this->pegawai = Pegawai::with(['bidang', 'atasan', 'bawahan'])
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.pegawai.detail');
    }
}
