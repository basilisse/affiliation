<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Utils\Utils;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating admin access';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->ask('Admin username : ', 'admin');
        $email = $this->ask('Admin email : ', '');
        $password = $this->ask('Admin password : ', '');
        if($email == '' || $password == ''){
            $this->fail('Username or password can\'t be empty');
            return 0;
        }
        $admin = new User();
        $admin->username = $username;
        $admin->email = $email;
        $admin->password = Hash::make($password);
        $admin->role = 'admin';
        $admin->points = 500;
        $admin->enabled = true;
        $admin->niveau = 1;
        $admin->invitation_code = Utils::generateRandomString(6);
        $admin->save();
        $this->info('Admin generated');
        return 1;
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, string>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'username' => 'Admin username : ',
            'password' => 'Admin password : ',
        ];
    }
}
