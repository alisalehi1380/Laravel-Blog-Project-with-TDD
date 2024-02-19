<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory;
    
    const TITLE = 'title';
    const SLUG = 'slug';
    const BODY = 'body';
    const WRITER_ID = 'writer_id';
    const COVER = 'cover';
    
    protected $fillable = [
        self::WRITER_ID,//user_id fk
        self::TITLE,
        self::SLUG,
        self::BODY,
        self::COVER
    ];
    
    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, self::WRITER_ID);
    }
    
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
    
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
    
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
    
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'post_category');
    }
}
