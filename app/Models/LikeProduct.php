<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\DateTrait;

class LikeProduct extends Model
{
    use HasFactory, DateTrait;

    protected $table = 'like_products';

    /**
     * Relation from product
     * 
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    /**
     * Relation from user
     * 
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
