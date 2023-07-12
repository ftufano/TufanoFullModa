<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultZonesHasStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('zones_has_states')->insert([
            ['zones_id'=> 1,
            'states_id'=>1]
            ,
            ['zones_id'=> 2,
            'states_id'=>4]
            ,
            ['zones_id'=> 3,
            'states_id'=>3]
            ,
            ['zones_id'=> 4,
            'states_id'=>5]
            ,
            ['zones_id'=> 1,
            'states_id'=>2]
            ,
            ['zones_id'=> 1,
            'states_id'=>3]
            ,
            ['zones_id'=> 6,
            'states_id'=>5]
            ,
            ['zones_id'=> 7,
            'states_id'=>2]
        ]);
    }
}
