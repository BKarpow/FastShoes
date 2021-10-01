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

    /**
     * This method return a clean number phone.
     * @return string
     */
    public function phoneClean():string
    {
        $phone = '';
        if (!empty($this->phone)) {
            $phone = preg_replace('#[^\d\+]#si', '', $this->phone);
        }
        return $phone;
    }

}
