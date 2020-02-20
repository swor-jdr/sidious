<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Personnages\Models\Personnage;
use Modules\Transition\Mail\RecoverPersonnage;
use Ramsey\Uuid\Uuid;

class TransitionPersonnage extends Command
{
    /**
     * Transition table from v4 field to v5 model field
     *
     * @var array
     */
    protected $translation_table = array(
        "id" => "v4_id",
        "username" => "name",
        "user_email" => "v4_email",
        "user_lastvisit" => "",
        "user_birthday" => "",
    );

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transition:personnage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transition all personnages from V4';

    protected $config;

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
        $this->config = DB::table("followup")->first();

        /**
         * Get last recovered personnage from v4 save
         */
        $this->info("Dernier personnage récupéré : ".$this->config->personnage);

        /**
         * Check max personnage count
         */
        $this->checkMaxPersonnages();

        $limit = $this->ask("Nombre à récupérer cette fois ?");

        $nb = $this->config->personnage;
        $limit = $this->config->personnage + $limit;
        while($nb <= $limit) {
            $nb++;
            try {
                $perso = DB::connection("v4")->table("phpbb_users")->find($nb);
                $pj = $this->makeTransitionForPJ($perso);

                // Create and save recover key
                $pj->recover_key = Uuid::uuid4();
                $pj->save();

                Mail::to($pj->v4_email)->send(new RecoverPersonnage($pj));

                $this->info($perso->name." Recovered !");

                // maj du dernier personnage recovered
            } catch (\Exception $exception) {
                $this->config->personnage = $nb--;
                $this->config->save();
                $this->error("Echec ! ID: ".$nb);
                break;
            }
        }
    }

    /**
     * Set max available users to convert
     *
     * @return void
     */
    private function checkMaxPersonnages()
    {
        $nb = DB::connection("v4")->table("phpbb_users")->count();
        $this->config->max_personnage = $nb;
        $this->config->save();
        $this->info("Max Personnage Checked : ".$nb);
    }

    private function makeTransitionForPJ($perso): Personnage
    {

    }
}
