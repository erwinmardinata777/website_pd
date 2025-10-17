<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Home\Index::class)->name('home');
