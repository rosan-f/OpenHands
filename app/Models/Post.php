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
        'target_amount',
        'collected_amount',
        'images',
        'deadline',
        'status'
    ];

    protected $casts = [
    'target_amount' => 'decimal:2',
    'current_amount' => 'decimal:2',
    'deadline' => 'datetime',
    'images' => 'array',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'deleted_at' => 'datetime',
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

    public function proof()
    {
        return $this->hasOne(Proof::class);
    }
}
