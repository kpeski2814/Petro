<?php

use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('areas')->insert([
        ['name' => 'Area 1', 'description' => 'descripcion area 1', 'status'=>'1', 'abbrev'=>'A1'],
        ['name' => 'Area 2', 'description' => 'descripcion area 2', 'status'=>'1', 'abbrev'=>'A2'],
        ['name' => 'Area 3', 'description' => 'descripcion area 3', 'status'=>'1', 'abbrev'=>'A3'],
        ['name' => 'Area 4', 'description' => 'descripcion area 4', 'status'=>'1', 'abbrev'=>'A4'],
      ]);
    }
}
