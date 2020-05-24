<?php
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
        $this->faker->addProvider(new HydrefLab\JediFaker\Provider\Character($this->faker));
    }

    public function run()
    {
        factory(\Modules\Factions\Models\Group::class)->create();
    }
}
