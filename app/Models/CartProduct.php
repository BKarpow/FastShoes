<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\DateTrait;

class CartProduct extends Model
{
    use HasFactory, DateTrait;

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
