<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'bio',
        'avatar',
        'location',
        'phone',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // relasi
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Accessors
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=06b6d4&color=fff';
    }

    public function getUsernameAttribute()
    {
        return strtolower(str_replace(' ', '', $this->name));
    }

    // Stats Methods
    public function getPostsCountAttribute()
    {
        return $this->posts()->count();
    }

    public function getDonationsCountAttribute()
    {
        return $this->donations()->where('payment_status', 'success')->count();
    }

    public function getTotalDonatedAttribute()
    {
        return $this->donations()
            ->where('payment_status', 'success')
            ->sum('amount');
    }

    public function getTotalReceivedAttribute()
    {
        return $this->posts()
            ->sum('collected_amount');
    }

    public function getUnreadNotificationsCountAttribute()
    {
        return $this->notifications()->unread()->count();
    }
}
