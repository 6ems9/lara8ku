<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($tag) { // before delete() method call this
            $tag->posts()->detach();
        });
    }
}
