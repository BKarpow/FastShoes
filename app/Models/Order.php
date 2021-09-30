<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, DateTrait;

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
