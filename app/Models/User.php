<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    const NAME = 'name';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const TYPE = 'type';
    const ADMIN = 'admin';
    const WRITER = 'writer';
    const USER = 'user';
    const REMEMBER_TOKEN = 'remember_token';
    const EMAIL_VERIFIED_AT = 'email_verified_at';
    
    protected $fillable = [
        self::NAME,
        self::EMAIL,
        self::PASSWORD,
        self::TYPE
    ];
    protected $hidden = [
        self::PASSWORD,
        self::REMEMBER_TOKEN,
    ];
    protected $casts = [
        self::EMAIL_VERIFIED_AT => 'datetime',
    ];
    const TYPES = [
        self::ADMIN,
        self::WRITER,
        self::USER
    ];
    
    public function isAdmin(): bool
    {
        return $this->type === User::ADMIN;
    }
    
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, Post::WRITER_ID);
    }
    
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}


