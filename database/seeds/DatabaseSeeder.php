<?php

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
        $this->call(PersonnageTableSeeder::class);
        $this->call(HolonewsSeeder::class);
        $this->call(GroupSeeder::class);
    }
}
