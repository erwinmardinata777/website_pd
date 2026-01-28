<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opds = [
            ['id' => 1, 'nama_opd' => 'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA', 'status' => 1],
            ['id' => 2, 'nama_opd' => 'BADAN KESATUAN BANGSA DAN POLITIK', 'status' => 1],
            ['id' => 3, 'nama_opd' => 'BADAN KEUANGAN DAN ASET DAERAH', 'status' => 1],
            ['id' => 4, 'nama_opd' => 'BADAN PENANGGULANGAN BENCANA DAERAH', 'status' => 1],
            ['id' => 5, 'nama_opd' => 'BADAN PENDAPATAN DAERAH', 'status' => 1],
            ['id' => 6, 'nama_opd' => 'BADAN PERENCANAAN, PENELITIAN DAN PENGEMBANGAN DAERAH', 'status' => 1],
            ['id' => 7, 'nama_opd' => 'DINAS KELAUTAN DAN PERIKANAN', 'status' => 1],
            ['id' => 8, 'nama_opd' => 'DINAS KEPEMUDAAN, OLAHRAGA DAN PARIWISATA', 'status' => 1],
            ['id' => 9, 'nama_opd' => 'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL', 'status' => 1],
            ['id' => 10, 'nama_opd' => 'DINAS KESEHATAN', 'status' => 1],
            ['id' => 11, 'nama_opd' => 'DINAS KETAHANAN PANGAN', 'status' => 1],
            ['id' => 12, 'nama_opd' => 'DINAS KOMUNIKASI, INFORMATIKA, STATISTIK DAN PERSANDIAN', 'status' => 1],
            ['id' => 13, 'nama_opd' => 'DINAS KOPERASI USAHA KECIL MENENGAH, PERINDUSTRIAN DAN PERDAGANGAN', 'status' => 1],
            ['id' => 14, 'nama_opd' => 'DINAS LINGKUNGAN HIDUP', 'status' => 1],
            ['id' => 15, 'nama_opd' => 'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG', 'status' => 1],
            ['id' => 16, 'nama_opd' => 'DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN', 'status' => 1],
            ['id' => 17, 'nama_opd' => 'DINAS PEMBERDAYAAN MASYARAKAT DAN DESA', 'status' => 1],
            ['id' => 18, 'nama_opd' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU', 'status' => 1],
            ['id' => 19, 'nama_opd' => 'DINAS PENDIDIKAN DAN KEBUDAYAAN', 'status' => 1],
            ['id' => 20, 'nama_opd' => 'DINAS PENGENDALIAN PENDUDUK, KELUARGA BERENCANA PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK', 'status' => 1],
            ['id' => 21, 'nama_opd' => 'DINAS PERHUBUNGAN', 'status' => 1],
            ['id' => 22, 'nama_opd' => 'DINAS PERPUSTAKAAN DAN KEARSIPAN', 'status' => 1],
            ['id' => 23, 'nama_opd' => 'DINAS PERTANIAN', 'status' => 1],
            ['id' => 24, 'nama_opd' => 'DINAS PERUMAHAN RAKYAT DAN KAWASAN PERMUKIMAN', 'status' => 1],
            ['id' => 25, 'nama_opd' => 'DINAS PETERNAKAN DAN KESEHATAN HEWAN', 'status' => 1],
            ['id' => 26, 'nama_opd' => 'DINAS SOSIAL', 'status' => 1],
            ['id' => 27, 'nama_opd' => 'DINAS TENAGA KERJA DAN TRANSMIGRASI', 'status' => 1],
            ['id' => 28, 'nama_opd' => 'INSPEKTORAT', 'status' => 1],
            ['id' => 29, 'nama_opd' => 'RUMAH SAKIT UMUM DAERAH', 'status' => 1],
            ['id' => 30, 'nama_opd' => 'SATUAN POLISI PAMONG PRAJA', 'status' => 1],
            ['id' => 31, 'nama_opd' => 'SEKRETARIAT DAERAH', 'status' => 1],
            ['id' => 32, 'nama_opd' => 'SEKRETARIAT DEWAN PERWAKILAN RAKYAT DAERAH', 'status' => 1],
            ['id' => 33, 'nama_opd' => 'KECAMATAN ALAS', 'status' => 2],
            ['id' => 34, 'nama_opd' => 'KECAMATAN ALAS BARAT', 'status' => 2],
            ['id' => 35, 'nama_opd' => 'KECAMATAN BATULANTEH', 'status' => 2],
            ['id' => 36, 'nama_opd' => 'KECAMATAN BUER', 'status' => 2],
            ['id' => 37, 'nama_opd' => 'KECAMATAN EMPANG', 'status' => 2],
            ['id' => 38, 'nama_opd' => 'KECAMATAN LABANGKA', 'status' => 2],
            ['id' => 39, 'nama_opd' => 'KECAMATAN LABUHAN BADAS', 'status' => 2],
            ['id' => 40, 'nama_opd' => 'KECAMATAN LANTUNG', 'status' => 2],
            ['id' => 41, 'nama_opd' => 'KECAMATAN LAPE', 'status' => 2],
            ['id' => 42, 'nama_opd' => 'KECAMATAN LENANGGUAR', 'status' => 2],
            ['id' => 43, 'nama_opd' => 'KECAMATAN LOPOK', 'status' => 2],
            ['id' => 44, 'nama_opd' => 'KECAMATAN LUNYUK', 'status' => 2],
            ['id' => 45, 'nama_opd' => 'KECAMATAN MARONGE', 'status' => 2],
            ['id' => 46, 'nama_opd' => 'KECAMATAN MOYO HILIR', 'status' => 2],
            ['id' => 47, 'nama_opd' => 'KECAMATAN MOYO HULU', 'status' => 2],
            ['id' => 48, 'nama_opd' => 'KECAMATAN MOYO UTARA', 'status' => 2],
            ['id' => 49, 'nama_opd' => 'KECAMATAN ORONG TELU', 'status' => 2],
            ['id' => 50, 'nama_opd' => 'KECAMATAN PLAMPANG', 'status' => 2],
            ['id' => 51, 'nama_opd' => 'KECAMATAN RHEE', 'status' => 2],
            ['id' => 52, 'nama_opd' => 'KECAMATAN ROPANG', 'status' => 2],
            ['id' => 53, 'nama_opd' => 'KECAMATAN SUMBAWA', 'status' => 2],
            ['id' => 54, 'nama_opd' => 'KECAMATAN TARANO', 'status' => 2],
            ['id' => 55, 'nama_opd' => 'KECAMATAN UNTER IWES', 'status' => 2],
            ['id' => 56, 'nama_opd' => 'KECAMATAN UTAN', 'status' => 2],
            // ['id' => 57, 'nama_opd' => 'KELURAHAN BRANG BARA', 'status' => 1],
            // ['id' => 58, 'nama_opd' => 'KELURAHAN BRANG BIJI', 'status' => 1],
            // ['id' => 59, 'nama_opd' => 'KELURAHAN BUGIS', 'status' => 1],
            // ['id' => 60, 'nama_opd' => 'KELURAHAN LEMPEH', 'status' => 1],
            // ['id' => 61, 'nama_opd' => 'KELURAHAN PEKAT', 'status' => 1],
            // ['id' => 62, 'nama_opd' => 'KELURAHAN SAMAPUIN', 'status' => 1],
            // ['id' => 63, 'nama_opd' => 'KELURAHAN SEKETENG', 'status' => 1],
            // ['id' => 64, 'nama_opd' => 'KELURAHAN UMA SIMA', 'status' => 1],
        ];

        $data = [];
        $now = now();

        foreach ($opds as $opd) {
            $data[] = [
                'id' => $opd['id'],
                'nama_opd' => $opd['nama_opd'],
                'slug' => Str::slug($opd['nama_opd']),
                'status' => $opd['status'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('opds')->insert($data);
    }
}
