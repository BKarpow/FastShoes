<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Meta;

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
}
