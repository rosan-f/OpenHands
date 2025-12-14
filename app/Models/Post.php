<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'target_amount',
        'collected_amount',
        'status'
    ];

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
}
