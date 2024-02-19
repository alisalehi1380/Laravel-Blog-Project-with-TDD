<?php

namespace Tests\Feature\Auth;


use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    
    public function test_redirect_admin_after_logedIn()
    {
        $admin = User::factory()
            ->admin()
            ->state([
                'email' => 'admin@a.b', 'password' => Hash::make('1234')
            ])
            ->create();
        $data = ['email' => 'admin@a.b', 'password' => '1234'];
        
        $response = $this->post(route('login'), $data);
        
        $response->assertRedirect(route('dashboard.admin'));
        
    }
    
    public function test_redirect_if_userName_or_passowrd_was_incorrect()
    {
        $data = ['email' => 'admin@a.bc', 'password' => '1234'];
        
        $response = $this->post(route('login'), $data);
        
        $response->assertSessionHas('email', 'User Name | Password Is Incorrect!');
        $response->assertRedirect(route('login'));
        
    }
    
    public function test_writer_logged_in_redirection()
    {
        $this->withoutExceptionHandling();
        
        User::factory()
            ->writer()
            ->state([
                'email' => 'writer@a.b', 'password' => Hash::make('1234')
            ])
            ->create();
        
        
        $writer = [
            User::EMAIL    => 'writer@a.b',
            User::PASSWORD => '1234'
        ];
        
        $resp = $this->post(route('login'), $writer);
        
        $resp->assertRedirect(route('dashboard.writer'));
        
        
    }
    
    public function test_show_register_form()
    {
        $this->get(route('register'))
            ->assertViewIs('auth.register');
    }
    
    public function test_regsiter_new_normall_user()
    {
        $data = [
            'name'                  => 'alireza',
            'email'                 => 'alireza@a.b',
            'password'              => '1234',
            'password_confirmation' => '1234'
        ];
        
        $res = $this->post(route('register.normall.user'), $data);
        
        $this->assertDatabaseHas('users', ['name' => 'alireza', 'email' => 'alireza@a.b']);
        $res->assertRedirect(route('index.guest'));
    }
}
