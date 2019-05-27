<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'person_id' => 1,
        	'username' => 'roddwy',
            'name' => 'roddwy',
            'email' => 'roddwy@gmail.com',
            'password' => bcrypt('admin'),
        ]);
    }
}
