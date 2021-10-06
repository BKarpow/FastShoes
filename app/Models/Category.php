<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Meta;

class Category extends Model
{
    use HasFactory, DateTrait, Meta;

    /**
     * Section table relation
     * 
     */
    public function section()
    {
        return $this->hasOne('App\Models\ProductSection', 'id', 'section_id');
    }

    /**
     * Return full href for category.
     * @return string
     */
    public function fullHref()
    {
        return route('spa.category', [
            'id' => $this->id,
            'alias' => $this->alias,
        ]);
    }
}
