<?php

namespace App\Livewire\Kontak;

use Livewire\Component;
use App\Models\ProfilWeb;
use App\Models\Pesan;

class Index extends Component
{
    public $nama;
    public $email;
    public $telp;
    public $subjek;
    public $pesan;
    public $profil;

    protected $rules = [
        'nama' => 'required|string|max:100',
        'email' => 'required|email|max:100',
        'telp' => 'nullable|string|max:20',
        'subjek' => 'required|string|max:200',
        'pesan' => 'required|string|min:10',
    ];

    protected $messages = [
        'nama.required' => 'Nama wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'subjek.required' => 'Subjek wajib diisi',
        'pesan.required' => 'Pesan wajib diisi',
        'pesan.min' => 'Pesan minimal 10 karakter',
    ];

    public function mount()
    {
        $this->profil = ProfilWeb::first();
    }

    public function submit()
    {
        $this->validate();

        try {
            Pesan::create([
                'nama' => $this->nama,
                'email' => $this->email,
                'telp' => $this->telp,
                'subjek' => $this->subjek,
                'pesan' => $this->pesan,
                'status' => 0,
            ]);

            // Reset form
            $this->reset(['nama', 'email', 'telp', 'subjek', 'pesan']);
            $this->resetValidation();

            // Dispatch success event
            $this->dispatch('pesanBerhasil');

        } catch (\Exception $e) {
            $this->dispatch('pesanGagal', message: 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.kontak.index');
    }
}
