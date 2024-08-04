<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@galajaya.com',
            'tempat_lahir' => 'Banjarmasin',
            'tgl_lahir' => Carbon::parse('2001-07-20'),
            'no_telp' => '089692875752',
            'alamat' => 'Jl. Saka Permai Gg. Amilin, Banjarmasin',
            'role' => 'admin',
        ]);
    }
}
