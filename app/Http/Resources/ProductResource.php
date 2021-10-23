<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'title' => $this->title,
            'price' => $this->price,
            'categoryName' => $this->category->title,
            'sectionName' => $this->category->section->title,
            'sectionId' => $this->category->section->id,
            'sectionAlias' => $this->category->section->alias,
            'image_1' => $this->imageItem_1(),
            'image_2' => $this->imageItem_2(),
            'image_3' => $this->imageItem_3(),
            'rating' => $this->rating(),
            'uri' => $this->uri(),
            'show' => (bool) $this->show
        ];
    }
}
