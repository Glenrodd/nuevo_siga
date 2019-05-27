<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('people')->insert([
        	'first_name' 	=> 'roddwy',
        	'last_name' 	=> 'limachi',
        	'ci'			=> 6120541
        ]);
    }
}
