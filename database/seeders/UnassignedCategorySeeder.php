<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnassignedCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('categories')->insert([
            ['name'=> 'Unnasigned',
            'users_id'=>1]
            ,
            ['name'=> 'Sandals',
            'users_id'=>1]
            ,
            ['name'=> 'Heels',
            'users_id'=>1]
        ]);

    }
}
