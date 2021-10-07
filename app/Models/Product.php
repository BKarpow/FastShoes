<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Traits\Meta;
use App\Models\Traits\DateTrait;

class Product extends Model
{
    use HasFactory, DateTrait, Meta;

    /**
     * Get the category associated with the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * paturn uri main image
     * 
     * @return string $imageUri|''
     */
    public function mainImage():string
    {
        return ($this->image_1) ? $this->image_1 : '';
    }

    /**
     * Getting info from files images
     */
    public function imageItem_1()
    {
        if (!empty($this->image_1)) {
            return $this->hasMany(File::class, 'uri', 'image_1')->first();
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_2()
    {
        if (!empty($this->image_2)) {
            return $this->hasMany(File::class, 'uri', 'image_2')->first();
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_3()
    {
        if (!empty($this->image_3)) {
            return $this->hasMany(File::class, 'uri', 'image_3')->first();
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_4()
    {
        if (!empty($this->image_4)) {
            return $this->hasMany(File::class, 'uri', 'image_4')->first();
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_5()
    {
        if (!empty($this->image_5)) {
            return $this->hasMany(File::class, 'uri', 'image_5')->first();
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_6()
    {
        if (!empty($this->image_6)) {
            return $this->hasMany(File::class, 'uri', 'image_6')->first();
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_7()
    {
        if (!empty($this->image_7)) {
            return $this->hasMany(File::class, 'uri', 'image_7')->first();
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_8()
    {
        if (!empty($this->image_8)) {
            return $this->hasMany(File::class, 'uri', 'image_8')->first();
        } 
    }

    /**
     * Uri for show product
     * 
     */
    public function uri()
    {
        return route('product.show', [
            'product' => $this->id,
            'alias' => $this->alias,
        ]);
    }

    /**
     * Return array sizes of json format
     * @return array
     */
    public function sizesArray():array
    {
        $sizes = [];
        if (!empty($this->sizes)) {
            $sizes = json_decode($this->sizes, true);
        }
        return $sizes;
    }

    /**
     * Return array colors of json format
     * @return array
     */
    public function colorsArray():array
    {
        $colors = [];
        if (!empty($this->colors)) {
            $colors = json_decode($this->colors, true);
        }
        return $colors;
    }


    


    
}