<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

     public function savedPosts() {
        return $this->hasMany(SavedPost::class);
    }


    public function isSavedBy($userId){
        return $this->savedPosts()->where('user_id', $userId)->exists();
    }

}
