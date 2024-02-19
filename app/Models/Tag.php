<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;
    
    protected $table = 'tags';
    
    const TITLE = 'title';
    const SLUG = 'slug';
    
    protected $fillable = [
        self::TITLE,
        self::SLUG
    ];
    
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }
}
