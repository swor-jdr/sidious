<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Bouncer;

class UpdateAbilities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acl:abilities:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update available abilities';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $entities = config("acl.entities");
        $abilities = config("acl.actions");

        foreach ($entities as $keyEntity => $valueEntity) {
            foreach ($abilities as $key => $value) {
                Bouncer::ability()->firstOrCreate([
                    'name' => $key.$valueEntity,
                    'title' => $value.' '.$valueEntity,
                ]);
            }
        }

        $this->info("Création des permissions OK");
    }
}
