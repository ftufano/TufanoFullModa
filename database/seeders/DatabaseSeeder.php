<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DefaultUserSeeder::class);
        $this->call(UnassignedCategorySeeder::class);
        $this->call(DefaultStatussesSeeder::class);
        $this->call(DefaultStatesSeeder::class);
        $this->call(DefaultZonesSeeder::class);
        $this->call(DefaultZonesHasStatesSeeder::class);
        $this->call(DefaultCustomersSeeder::class);
    }
}
