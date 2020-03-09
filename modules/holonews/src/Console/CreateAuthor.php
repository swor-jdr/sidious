<?php
namespace Modules\Holonews\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Modules\Holonews\Models\Author;

class CreateAuthor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:author';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Holonews author';

    public function handle()
    {
        $name = $this->ask("Nom :");
        $email = $this->ask("Email :");
        $pass = $this->ask("Mot de passe :");

        Author::create([
            'name' => $name,
            'bio' => 'This is me.',
            'email' => $email,
            'password' => Hash::make($password = $pass),
        ]);

        $this->info("Auteur créé !");
    }
}
