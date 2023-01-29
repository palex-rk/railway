<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            ['name' => 'Subotica'], ['name' => 'Beograd'], ['name' => 'Novi Sad'], ['name' => 'Kragujevac'], ['name' => 'Nis'], ['name' => 'Kraljevo'], ['name' => 'Valjevo'], ['name' => 'Jagodina'], ['name' => 'Sombor'], ['name' => 'Lapovo'], ['name' => 'Krusevac'], ['name' => 'Cacak'], ['name' => 'Uzice'], ['name' => 'Leskovac'], ['name' => 'Vranje'], ['name' => 'Vrsac'], ['name' => 'Trstenik'], ['name' => 'Aleksinac'], ['name' => 'Mladenovac']
        ]);
    }
}
