<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'body' => 'array'
    ];

    // public function getTitleUpperCaseAttribute()
    // {
    //     return strtoupper($this->title);
    // }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtolower($value);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_user', 'post_id', 'user_id');
    }
}
