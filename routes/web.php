<?php

use Illuminate\Support\Facades\Route;

// ✅ Routes dengan IdentifyTenant middleware (untuk frontend)
Route::middleware(['web', \App\Http\Middleware\IdentifyTenant::class])->group(function () {
    Route::get('/daftar-opd', App\Livewire\DaftarOpd\Index::class)->name('daftar-opd');
    Route::get('/', App\Livewire\Home\Index::class)->name('home');
    Route::get('/berita', App\Livewire\Berita\Index::class)->name('berita');
    Route::get('/berita/{slug}', App\Livewire\Berita\Detail::class)->name('berita.detail');
    Route::get('/struktur-organisasi', App\Livewire\StrukturOrganisasi\Index::class)->name('struktur-organisasi.index');
    Route::get('/pegawai/{id}', App\Livewire\Pegawai\Detail::class)->name('pegawai.detail');
    Route::get('/visi-misi', App\Livewire\VisiMisi\Index::class)->name('visi-misi.index');
    Route::get('/tugas-fungsi', App\Livewire\TugasFungsi\Index::class)->name('tugas-fungsi.index');
    Route::get('/tentang-kami', App\Livewire\TentangKami\Index::class)->name('tentang-kami.index');
    Route::get('/bidang', App\Livewire\Bidang\Index::class)->name('bidang.index');
    Route::get('/bidang/{id}', App\Livewire\Bidang\Detail::class)->name('bidang.detail');
    Route::get('/lowongan-kerja', App\Livewire\LowonganKerja\Index::class)->name('lowongan-kerja.index');
    Route::get('/lowongan-kerja/{id}', App\Livewire\LowonganKerja\Detail::class)->name('lowongan-kerja.detail');
    Route::get('/pengaduan', App\Livewire\Pengaduan\ListPengaduan::class)->name('pengaduan.list');
    Route::get('/pengaduan/{id}', App\Livewire\Pengaduan\Detail::class)->name('pengaduan.detail');
    Route::get('/pengaduan-baru', App\Livewire\Pengaduan\Form::class)->name('pengaduan.form');
    Route::get('/galeri', App\Livewire\Galeri\Index::class)->name('galeri.index');
    Route::get('/galeri/foto/{slug}', App\Livewire\Galeri\FotoDetail::class)->name('galeri.foto.detail');
    Route::get('/dokumen', App\Livewire\Dokumen\Index::class)->name('dokumen.index');
    Route::get('/dokumen/download/{id}', [App\Livewire\Dokumen\Index::class, 'downloadDokumen'])->name('dokumen.download');
    Route::get('/layanan', App\Livewire\Layanan\Index::class)->name('layanan.index');
    Route::get('/layanan/{slug}', App\Livewire\Layanan\Detail::class)->name('layanan.detail');
    Route::get('/agenda', App\Livewire\Agenda\Index::class)->name('agenda.index');
    Route::get('/agenda/{slug}', App\Livewire\Agenda\Detail::class)->name('agenda.detail');
    Route::get('/kontak', App\Livewire\Kontak\Index::class)->name('kontak.index');
});
