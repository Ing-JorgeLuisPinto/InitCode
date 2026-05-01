<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    protected $signature = 'make:admin {email}';
    protected $description = 'Promote a user to administrator';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Usuario no encontrado: {$email}");
            return 1;
        }

        $user->update(['is_admin' => true]);
        $this->info("¡Éxito! {$user->name} ({$email}) ahora es administrador. 👑");
        return 0;
    }
}
