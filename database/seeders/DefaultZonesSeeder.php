<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultZonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('zones')->insert([
            ['name'=> 'Center-1',
            'seller_users_id'=> 2,
            'users_id'=>1]
            ,
            ['name'=> 'West-1',
            'seller_users_id'=> 3,
            'users_id'=>1]
            ,
            ['name'=> 'Center-2',
            'seller_users_id'=> 2,
            'users_id'=>1]
            ,
            ['name'=> 'East-1',
            'seller_users_id'=> 2,
            'users_id'=>1]
            ,
            ['name'=> 'South-1',
            'seller_users_id'=> 3,
            'users_id'=>1]
            ,
            ['name'=> 'East-2',
            'seller_users_id'=> 3,
            'users_id'=>1]
            ,
            ['name'=> 'East-3',
            'seller_users_id'=> 3,
            'users_id'=>1]
        ]);
    }
}
