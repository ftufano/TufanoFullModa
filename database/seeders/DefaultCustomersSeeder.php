<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultCustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            [
                'identification'=> 'J-98265489-5',
                'name'=> 'Customer 1 LLC',
                'address'=> '29548, Valencia',
                'phone'=> '+582411456895',
                'users_id'=> 1,
                'states_id'=> 2,
                'zones_id'=> 1,
                'categories_id'=> 3,
                'status_id'=> 1
            ]
            ,
            [
                'identification'=> 'J-86297452-3',
                'name'=> 'Customer 2 CA',
                'address'=> 'Avenida Principal, Caracas',
                'phone'=> '+582123455667',
                'users_id'=> 1,
                'states_id'=> 3,
                'zones_id'=> 3,
                'categories_id'=> 2,
                'status_id'=> 2
            ]
            ,
            [
                'identification'=> 'V-91541892-0',
                'name'=> 'Customer 3 SRL',
                'address'=> 'Calle 92, Maracaibo',
                'phone'=> '+582719863222',
                'users_id'=> 1,
                'states_id'=> 5,
                'zones_id'=> 6,
                'categories_id'=> 3,
                'status_id'=> 3
            ]
        ]);
    }
}
