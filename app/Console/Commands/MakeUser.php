<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('What is user name?');
        $document = $this->ask('What is user document?');
        $email = $this->ask('What is user email?');
        $password = $this->secret('What is the user password?');
        $admin = $this->confirm('Is the user an administrator?');


        $user = new \App\Models\User();
        $user->name = $name;
        $user->document = $document;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->admin = $admin;
        $user->save();

        $this->info('User created successfully!');
    }
}
