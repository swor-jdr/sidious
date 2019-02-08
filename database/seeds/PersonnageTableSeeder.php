<?php

use Illuminate\Database\Seeder;

class PersonnageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Nicolasey\Personnage\Models\Personnage::class)->create([
            "owner" => factory(App\User::class)->create(['name' => "Vador", "email" => "vador@sith.dev"])->id,
            "name" => "Anakin"
        ]);
    }
}
