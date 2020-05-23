<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Personnages\Models\Personnage;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    private $personnage;
    private $group;

    protected function setUp(): void {
        parent::setUp();

        $this->personnage = factory(Personnage::class)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function creating_economic_actor_should_create_account()
    {
        $prior = $this->get('/api/personnages/' . $this->personnage->id);
        dd($prior->json());
        $response = $this->get('/api/accounts/');

        $response->assertStatus(200);
    }

    public function it_shows_account_with_transactions()
    {
        $response = $this->get('/api/accounts/');
    }
}
