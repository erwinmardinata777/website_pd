<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Home\Index::class)->name('home');
Route::get('/berita', App\Livewire\Berita\Index::class)->name('berita');
Route::get('/berita/{slug}', App\Livewire\Berita\Detail::class)->name('berita.detail');
