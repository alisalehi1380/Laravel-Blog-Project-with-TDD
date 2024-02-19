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
            User::col_email    => 'admin@a.b',
            User::col_password => Hash::make('1234')
        ]);
    }
    
    private function createWriter(): void
    {
        User::factory()->writer()->create([
            User::col_email    => 'writer@a.b',
            User::col_password => Hash::make('1234')
        ]);
    }
    
    private function createNormallUser(): void
    {
        User::factory()->user()->create([
            User::col_email    => 'user@a.b',
            User::col_password => Hash::make('1234')
        ]);
        
    }
}
