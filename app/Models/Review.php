<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\DateTrait;

class Review extends Model
{
    use HasFactory, DateTrait;

    /**
     * Relation from user
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
