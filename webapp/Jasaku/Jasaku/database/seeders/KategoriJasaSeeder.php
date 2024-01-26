<?php

namespace Database\Seeders;

use App\Models\KategoriJasa;
use Illuminate\Database\Seeder;

class KategoriJasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KategoriJasa::create([
            'nama' => 'Jasa Service Elektronik',
            'deskripsi' => 'Jasa Service Elektronik.',
        ]);

        KategoriJasa::create([
            'nama' => 'Jasa Print dan Fotocopy',
            'deskripsi' => 'Jasa Print dan Fotocopy.',
        ]);

        KategoriJasa::create([
            'nama' => 'Jasa Kecantikan',
            'deskripsi' => 'Jasa Kecantikan.',
        ]);
    }
}
