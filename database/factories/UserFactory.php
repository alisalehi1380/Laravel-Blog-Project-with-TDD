<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'remember_token'    => Str::random(10),
            'type'              => User::types[rand(0, 2)]
        ];
    }
    
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
    
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => User::ADMIN,
            ];
        });
    }
    
    public function writer()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => User::WRITER,
            ];
        });
    }
    
    public function user()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => User::USER,
            ];
        });
    }
}
