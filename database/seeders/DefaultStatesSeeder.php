<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert([
            ['name'=> 'Aragua',
            'users_id'=>1]
            ,
            ['name'=> 'Carabobo',
            'users_id'=>1]
            ,
            ['name'=> 'Distrito Capital',
            'users_id'=>1]
            ,
            ['name'=> 'Merida',
            'users_id'=>1]
            ,
            ['name'=> 'Zulia',
            'users_id'=>1]
        ]);
    }
}
