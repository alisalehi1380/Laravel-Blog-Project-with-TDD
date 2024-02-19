<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Like extends Model
{
    use HasFactory;
    
    const USER_ID = 'user_id';
    const LIKEABLE_TYPE = 'likeable_type';
    const LIKEABLE_ID = 'likeable_id';
    
    protected $fillable = [
        self::USER_ID,
        self::LIKEABLE_TYPE,
        self::LIKEABLE_ID
    ];
    
    public function likeable() : MorphTo
    {
        return $this->morphTo();
    }
}
