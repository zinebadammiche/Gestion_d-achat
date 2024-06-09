<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appel du seeder des rôles et permissions
        $this->call(RolesAndPermissionsSeeder::class);

        // Création de 10 utilisateurs
       // User::factory(10)->create();

        // Création d'un utilisateur admin
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
        ]);

        // Optionnel : Assigner un rôle à l'utilisateur admin
        $adminUser = User::where('email', 'admin@gmail.com')->first();
        $adminUser->assignRole('Admin');
        // Création d'un utilisateur directeur
        User::factory()->create([
            'name' => 'directeur',
            'email' => 'directeur@gmail.com',
            'password' => Hash::make('123456789'),
        ]);

        // Optionnel : Assigner un rôle à l'utilisateur admin
        $adminUser = User::where('email', 'directeur@gmail.com')->first();
        $adminUser->assignRole('Directeur');
        
        // Création d'un utilisateur chefd
        User::factory()->create([
            'name' => 'chefd',
            'email' => 'chefd@gmail.com',
            'password' => Hash::make('123456789'),
        ]);

        // Optionnel : Assigner un rôle à l'utilisateur admin
        $adminUser = User::where('email', 'chefd@gmail.com')->first();
        $adminUser->assignRole('Chef Division');
        
        // Création d'un utilisateur chefs
        User::factory()->create([
            'name' => 'chefs',
            'email' => 'chefs@gmail.com',
            'password' => Hash::make('123456789'),
        ]);

        // Optionnel : Assigner un rôle à l'utilisateur admin
        $adminUser = User::where('email', 'chefs@gmail.com')->first();
        $adminUser->assignRole('Chef Service');
    }
}
