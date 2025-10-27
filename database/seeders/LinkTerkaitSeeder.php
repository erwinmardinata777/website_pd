<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinkTerkaitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('link_terkaits')->insert([
            'judul' => 'Kabupaten Sumbawa',
            'link' => 'https://sumbawakab.go.id',
            'thumb' => 'image/logo-sumbawa.png',
        ]);
    }
}
