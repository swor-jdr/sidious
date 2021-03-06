<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class PersonnageTableSeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
        $this->faker->addProvider(new HydrefLab\JediFaker\Provider\Character($this->faker));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(App\User::class)->create([
            "email" => "vador@sith.gal"
        ]);

        factory(\Modules\Personnages\Models\Personnage::class)->create([
            "owner_id" => $user->id,
            "name" => $this->faker->darkSide,
        ]);

        factory(\Modules\Personnages\Models\Personnage::class)->create([
            "owner_id" => $user->id,
            "name" => $this->faker->lightSide,
        ]);
    }
}
