<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\DateTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, DateTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const ROLE_ADMIN = 777;
    const ROLE_USER = 1;

    /**
     * Check role Administrator
     */
    public function isAdmin():bool
    {
        return (int)$this->role === self::ROLE_ADMIN;
    }


    /**
     * Relation of Review
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    /**
     * Getting correct path for avatar
     * @return string
     */
    public function getPathAvatar():string
    {
        if (!empty($this->avatar)) {
            return (string) $this->avatar;
        } else {
            return env('NO_IMAGE_DEFAULT', '/images/noavatar.webp');
        }
    }

    /**
     * Relation from orders list
     */
    public function orders()
    {
        return $this->hasMany(UserOrder::class, 'user_id', 'id');
    }
}
