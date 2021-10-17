<?php

namespace App\Models;

use App\Models\Traits\DateTrait;
use App\Models\Traits\Meta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSection extends Model
{
    use HasFactory, DateTrait, Meta;

    /**
     * Return full href for section.
     * @return string
     */
    public function fullHref()
    {
        return route('spa.section', [
            'id' => $this->id,
            'alias' => $this->alias,
        ]);
    }
    /**
     * Relation for category
     *
     */
    public function categories()
    {
        return $this->hasMany(Category::class, 'section_id', 'id');
    }
}
