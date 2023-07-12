<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'=> 'Tufano Test User',
                'email'=> 'test@mail.com',
                'phone'=> '12345678901',
                'user_type'=> 'Administrador',
                'password'=> Hash::make('4321')
            ]
            ,
            [
                'name'=> 'Brian Seller User',
                'email'=> 'briantest@mail.com',
                'phone'=> '12345612345',
                'user_type'=> 'Vendedor',
                'password'=> Hash::make('4321')
            ]
            ,
            [
                'name'=> 'James Seller User',
                'email'=> 'jamestest@mail.com',
                'phone'=> '18942112345',
                'user_type'=> 'Vendedor',
                'password'=> Hash::make('4321')
            ]
        ]);
    }
}
