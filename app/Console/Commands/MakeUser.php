<?php
// phpcs:ignoreFile

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->ask('What is user name?');
        $document = $this->ask('What is user document?');
        $password = $this->secret('What is the user password?');


        $user = new User();
        $user->name = $name;
        $user->document = $document;
        $user->password = bcrypt($password);
        $user->save();

        $this->info('User created successfully!');
    }
}
