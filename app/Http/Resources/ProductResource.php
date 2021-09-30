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
            'image_1' => $this->imageItem_1(),
            'image_2' => $this->imageItem_2(),
            'image_3' => $this->imageItem_3(),
            'image_4' => $this->imageItem_4(),
            'image_5' => $this->imageItem_5(),
            'image_6' => $this->imageItem_6(),
            'image_7' => $this->imageItem_7(),
            'image_8' => $this->imageItem_8(),
            'uri' => $this->uri(),
            'show' => (bool)$this->show,
        ];
    }
}
