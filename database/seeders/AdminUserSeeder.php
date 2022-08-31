<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     *
     * @return void
     * @throws BindingResolutionException
     * @throws MassAssignmentException
     */
    public function run(): void
    {
        User::create(['name' => 'Jean-Marc Strauven', 'email' => 'jean-marc.strauven@otmgroup.be', 'email_verified_at' => now(), 'password' => Hash::make('password')]);
    }
}
