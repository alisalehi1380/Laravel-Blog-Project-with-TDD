<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Requests\LoginRequest;
use App\Http\Controllers\Auth\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthenticateController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            
            switch (Auth::user()->type) {
                case User::ADMIN:
                    return redirect(route('dashboard.admin'));
                
                case User::WRITER:
                    
                    return redirect(route('dashboard.writer'));
                
                case User::USER:
                    //TODO درست کن وقتی نوبت یوزر عادی شد
                    return redirect(route("index.guest"));
                
                default:
                    abort(403);
                    break;
            }
        }
        
        return redirect(route('login'))->with('email', 'User Name | Password Is Incorrect!');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerate();
        $request->session()->regenerateToken();
        return redirect(route('index.guest'));
    }
    
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::query()->create([
                User::NAME     => $request->name,
                User::EMAIL    => $request->email,
                User::PASSWORD => Hash::make($request->password),
                User::TYPE     => User::USER
            ]);
            Auth::login($user);
            return redirect(route('index.guest'));
        } catch (\Exception $e) {
            Log::error($e);
            abort(500);
        }
    }
}
