<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultStatussesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            ['name'=> 'Blocked',
            'users_id'=>1]
            ,
            ['name'=> 'Defaulter',
            'users_id'=>1]
            ,
            ['name'=> 'Active',
            'users_id'=>1]
        ]);

    }
}
