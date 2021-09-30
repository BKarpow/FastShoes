<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, DateTrait;

    /**
     * Section table relation
     * 
     */
    public function section()
    {
        return $this->hasOne('App\Models\ProductSection', 'id', 'section_id');
    }
}
