<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        ['name' => 'Elio', 'email' => 'elio.mstp@gmail.com' , 'password' => bcrypt('123123')],
      ]);
    }
}
