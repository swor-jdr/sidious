<?php

namespace Modules\Transition\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Personnages\Models\Personnage;
use Modules\Transition\Mail\RecoverPersonnage;
use Modules\Transition\Models\FollowUp;
use Modules\Transition\Models\TransitionUser;
use Ramsey\Uuid\Uuid;

class TransitionPersonnage extends Command
{
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
     * @throws \Exception
     */
    public function handle()
    {
        $this->config = FollowUp::find(1);
        $this->config = ($this->config) ?: new FollowUp();

        /**
         * Get last recovered personnage from v4 save
         */
        $this->info("Dernier personnage récupéré : ".$this->config->personnage);

        /**
         * Check max personnage count
         */
        $this->checkMaxPersonnages();

        $limit = $this->ask("Nombre à récupérer cette fois ?");

        $nb = ($this->config) ? $this->config->personnage : 0;
        $limit = $nb + $limit;

        while($nb <= $limit) {
            $nb++;
            try {
                $perso = TransitionUser::find($nb);
                $pj = $this->makeTransitionForPJ($perso);

                // @todo repair email
                // if($pj->v4_email) Mail::to($pj->v4_email)->send(new RecoverPersonnage($pj));

                $this->info($pj->name." Recovered !");

                // maj du dernier personnage recovered
            } catch (\Exception $exception) {
                $this->config->personnage = $nb--;
                $this->config->save();
                $this->error("Echec ! ID: ".$nb++);
                throw $exception;
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
        $nb = TransitionUser::all()->count();
        $this->config->max_personnage = $nb;
        $this->config->save();
        $this->info("Max Personnage Checked : ".$nb);
    }

    private function makeTransitionForPJ(TransitionUser $oldUser): Personnage
    {
        $pj = Personnage::firstOrCreate(['v4_id' => $oldUser->user_id, 'name' => 'tmp']);
        foreach (TransitionUser::TRANSITION as $key => $value) {
            $pj->{$value} = $oldUser->{$key};
        }

        $pj->recover_key = Uuid::uuid4();
        $pj->save();
        return $pj;
    }
}
