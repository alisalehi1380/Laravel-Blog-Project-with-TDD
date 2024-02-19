<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    use RefreshDatabase;
    
    public function run()
    {
        $this->createAdmin();
        $this->createWriter();
        $this->createNormallUser();
    }
    
    private function createAdmin(): void
    {
        User::factory()->admin()->create([
            User::EMAIL    => 'admin@a.b',
            User::PASSWORD => Hash::make('1234')
        ]);
    }
    
    private function createWriter(): void
    {
        User::factory()->writer()->create([
            User::EMAIL    => 'writer@a.b',
            User::PASSWORD => Hash::make('1234')
        ]);
    }
    
    private function createNormallUser(): void
    {
        User::factory()->user()->create([
            User::EMAIL    => 'user@a.b',
            User::PASSWORD => Hash::make('1234')
        ]);
        
    }
}
