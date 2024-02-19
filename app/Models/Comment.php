<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends Model
{
    use HasFactory;
    
    const USER_ID = 'user_id';
    const POST_ID = 'post_id';
    const REPLY_ID = 'reply_id';
    const SHOW = 'show';
    const TEXT = 'text';
    
    protected $fillable = [
        self::USER_ID,
        self::POST_ID,
        self::REPLY_ID,
        self::SHOW,
        self::TEXT,
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    
    public function reply(): HasMany
    {
        return $this->hasMany(Comment::class, self::REPLY_ID);
    }
    
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
