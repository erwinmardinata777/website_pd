<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kecamatans')->insert([
            ['id' => 1, 'kode_kecamatan' => '520402', 'nama_kecamatan' => 'Lunyuk'],
            ['id' => 2, 'kode_kecamatan' => '520405', 'nama_kecamatan' => 'Alas'],
            ['id' => 3, 'kode_kecamatan' => '520406', 'nama_kecamatan' => 'Utan'],
            ['id' => 4, 'kode_kecamatan' => '520407', 'nama_kecamatan' => 'Batu Lanteh'],
            ['id' => 5, 'kode_kecamatan' => '520408', 'nama_kecamatan' => 'Sumbawa'],
            ['id' => 6, 'kode_kecamatan' => '520409', 'nama_kecamatan' => 'Moyo Hilir'],
            ['id' => 7, 'kode_kecamatan' => '520410', 'nama_kecamatan' => 'Moyo Hulu'],
            ['id' => 8, 'kode_kecamatan' => '520411', 'nama_kecamatan' => 'Ropang'],
            ['id' => 9, 'kode_kecamatan' => '520412', 'nama_kecamatan' => 'Lape'],
            ['id' => 10, 'kode_kecamatan' => '520413', 'nama_kecamatan' => 'Plampang'],
            ['id' => 11, 'kode_kecamatan' => '520414', 'nama_kecamatan' => 'Empang'],
            ['id' => 12, 'kode_kecamatan' => '520417', 'nama_kecamatan' => 'Alas Barat'],
            ['id' => 13, 'kode_kecamatan' => '520418', 'nama_kecamatan' => 'Labuhan Badas'],
            ['id' => 14, 'kode_kecamatan' => '520419', 'nama_kecamatan' => 'Labangka'],
            ['id' => 15, 'kode_kecamatan' => '520420', 'nama_kecamatan' => 'Buer'],
            ['id' => 16, 'kode_kecamatan' => '520421', 'nama_kecamatan' => 'Rhee'],
            ['id' => 17, 'kode_kecamatan' => '520422', 'nama_kecamatan' => 'Unter Iwes'],
            ['id' => 18, 'kode_kecamatan' => '520423', 'nama_kecamatan' => 'Moyo Utara'],
            ['id' => 19, 'kode_kecamatan' => '520424', 'nama_kecamatan' => 'Maronge'],
            ['id' => 20, 'kode_kecamatan' => '520425', 'nama_kecamatan' => 'Tarano'],
            ['id' => 21, 'kode_kecamatan' => '520426', 'nama_kecamatan' => 'Lopok'],
            ['id' => 22, 'kode_kecamatan' => '520427', 'nama_kecamatan' => 'Lenangguar'],
            ['id' => 23, 'kode_kecamatan' => '520428', 'nama_kecamatan' => 'Orong Telu'],
            ['id' => 24, 'kode_kecamatan' => '520429', 'nama_kecamatan' => 'Lantung'],
        ]);        
    }
}
