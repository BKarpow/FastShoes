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
        return ($this->image_1) ? url( $this->image_1 ) : url( env('NO_IMAGE_PRODUCT_DEFAULT','') );
    }

    /**
     * Method return object File model for image or null
     * 
     * @param string $column - Column of image uri
     * @param bool $fullInfo - default false
     * @return App\Models\File |string (json) | null
     */
    private function relationImage(string $column, bool $fulIInfo = false)
    {
        $file = $this->hasMany(File::class, 'uri', $column);
        if (!$fulIInfo) {
            $file ->select('id', 'name', 'uri');
            return $file->first();
        }
        return json_encode( $file->first());
    }

    /**
     * Getting info from files images
     */
    public function imageItem_1(bool $fulIInfo = false)
    {
        if (!empty($this->image_1)) {
            return $this->relationImage('image_1', $fulIInfo);
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_2(bool $fulIInfo = false)
    {
        if (!empty($this->image_2)) {
            return $this->relationImage('image_2', $fulIInfo);
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_3(bool $fulIInfo = false)
    {
        if (!empty($this->image_3)) {
            return $this->relationImage('image_3', $fulIInfo);
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_4(bool $fulIInfo = false)
    {
        if (!empty($this->image_4)) {
            return $this->relationImage('image_4', $fulIInfo);
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_5(bool $fulIInfo = false)
    {
        if (!empty($this->image_5)) {
            return $this->relationImage('image_5', $fulIInfo);
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_6(bool $fulIInfo = false)
    {
        if (!empty($this->image_6)) {
            return $this->relationImage('image_6', $fulIInfo);
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_7(bool $fulIInfo = false)
    {
        if (!empty($this->image_7)) {
            return $this->relationImage('image_7', $fulIInfo);
        } 
    }

    /**
     * Getting info from files images
     */
    public function imageItem_8(bool $fulIInfo = false)
    {
        if (!empty($this->image_8)) {
            return $this->relationImage('image_8', $fulIInfo);
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

    /**
     * Method computed rating for product
     * 
     */
    public function rating()
    {
       $rating = Review::where('product_id', $this->id)->avg('rating');
       if ($rating) {
            $rating = (float)$rating;
            $rating = round($rating, 2);
       } else {
           $rating = 0;
       }
       return $rating;
    }

    /**
     * Relation from LikeProducts
     */
    public function likes()
    {
        return $this->hasMany(LikeProduct::class, 'product_id', 'id');
    }
}