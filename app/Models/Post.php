<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Post extends Model
{

        protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'image',
        'target_amount',
        'collected_amount',
        'status',
        'deadline',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function donations() {
        return $this->hasMany(Donation::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function shares() {
        return $this->hasMany(Share::class);
    }

   public function bookmarks() {
        return $this->hasMany(Bookmark::class);
    }


    // accessor

    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }

        return asset('images/default.jpg');
    }


}
