<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\DateTrait;

class UserOrder extends Model
{
    use HasFactory, DateTrait;

    /**
     * Relation from product
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    /**
     * Relation from order
     */
    public function info()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }


    /**
     * Relation for User
     * 
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
