<?php

namespace App\Livewire\Pengaduan;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pengaduan;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Support\Facades\Storage;

class Form extends Component
{
    use WithFileUploads;

    // Form fields
    public $nama;
    public $telp;
    public $alamat;
    public $kode_kecamatan;
    public $kode_desa;
    public $pengaduan; // judul
    public $isi_pengaduan;
    public $bukti;

    // Data untuk dropdown
    public $kecamatans = [];
    public $desas = [];

    // Success message
    public $showSuccess = false;
    public $ticketNumber = '';

    protected $rules = [
        'nama' => 'required|string|max:100',
        'telp' => 'required|string|max:20',
        'alamat' => 'required|string',
        'kode_kecamatan' => 'required|exists:kecamatans,kode_kecamatan', // Fix: table name
        'kode_desa' => 'required|exists:desas,kode_desa', // Fix: table name
        'pengaduan' => 'required|string|max:200',
        'isi_pengaduan' => 'required|string|min:50|max:2000',
        'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
    ];

    protected $messages = [
        'nama.required' => 'Nama lengkap wajib diisi',
        'telp.required' => 'Nomor telepon wajib diisi',
        'alamat.required' => 'Alamat lengkap wajib diisi',
        'kode_kecamatan.required' => 'Pilih kecamatan',
        'kode_kecamatan.exists' => 'Kecamatan yang dipilih tidak valid',
        'kode_desa.required' => 'Pilih kelurahan/desa',
        'kode_desa.exists' => 'Kelurahan/desa yang dipilih tidak valid',
        'pengaduan.required' => 'Judul pengaduan wajib diisi',
        'isi_pengaduan.required' => 'Detail pengaduan wajib diisi',
        'isi_pengaduan.min' => 'Detail pengaduan minimal 50 karakter',
        'bukti.mimes' => 'Format file harus JPG, PNG, PDF, DOC, atau DOCX',
        'bukti.max' => 'Ukuran file maksimal 2MB',
    ];

    public function mount()
    {
        // Load semua kecamatan
        $this->kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
    }

    public function updatedKodeKecamatan($value)
    {
        // Reset desa ketika kecamatan berubah
        $this->kode_desa = '';
        
        // Load desa berdasarkan kecamatan yang dipilih
        if ($value) {
            $this->desas = Desa::where('kode_kecamatan', $value)
                               ->orderBy('nama_desa')
                               ->get();
        } else {
            $this->desas = [];
        }
    }

    public function submit()
    {
        // Validate
        $validated = $this->validate();

        try {
            // Upload file bukti jika ada
            $buktiPath = null;
            if ($this->bukti) {
                $buktiPath = $this->bukti->store('pengaduan', 'public');
            }

            // Simpan pengaduan
            $pengaduan = Pengaduan::create([
                'nama' => $this->nama,
                'telp' => $this->telp,
                'alamat' => $this->alamat,
                'kode_kecamatan' => $this->kode_kecamatan,
                'kode_desa' => $this->kode_desa,
                'pengaduan' => $this->pengaduan,
                'isi_pengaduan' => $this->isi_pengaduan,
                'bukti' => $buktiPath,
                'status' => 'baru',
                'tanggal_pengaduan' => now(),
            ]);

            // Generate nomor tiket
            $this->ticketNumber = 'PGD' . str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT);

            // Get data untuk sweet alert
            $kecamatanNama = $pengaduan->kecamatan ? $pengaduan->kecamatan->nama_kecamatan : '-';
            $desaNama = $pengaduan->desa ? $pengaduan->desa->nama_desa : '-';

            // Reset form
            $this->reset([
                'nama', 'telp', 'alamat', 'kode_kecamatan', 
                'kode_desa', 'pengaduan', 'isi_pengaduan', 'bukti'
            ]);
            $this->desas = [];
            $this->resetValidation();

            // Dispatch browser event untuk sweet alert
            $this->dispatch('pengaduanBerhasil', 
                ticketNumber: $this->ticketNumber,
                nama: $pengaduan->nama,
                kecamatan: $kecamatanNama,
                desa: $desaNama
            );

        } catch (\Exception $e) {
            \Log::error('Error submitting pengaduan: ' . $e->getMessage());
            
            $this->dispatch('pengaduanGagal', 
                message: 'Terjadi kesalahan: ' . $e->getMessage()
            );
        }
    }

    public function resetForm()
    {
        $this->reset([
            'nama', 'telp', 'alamat', 'kode_kecamatan', 
            'kode_desa', 'pengaduan', 'isi_pengaduan', 'bukti'
        ]);
        $this->desas = [];
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.pengaduan.form');
    }
}
