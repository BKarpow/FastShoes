<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductSection;

class ProductSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

     private function formatApi($data):array
     {
         $a = [];
         if ($data) {
             foreach($data as $item) {
                 $a[] = [
                     'id' => $item->id,
                     'title' => $item->title,
                     'description' => $item->description,
                     'created_at' => $item->createdDate(),
                     'updated_at' => $item->updatedDate(),
                     'show' => (bool)$item->show,
                 ];
             }
         }
         return $a;
     }

    public function toArray($request)
    {
        // $data = ProductSection::all();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'alias' => $this->alias,
            'description' => $this->description,
            'show' => (bool)$this->show,
            'createdAt' => $this->createdDate(),
            'updatedAt' => $this->updatedDate(),
        ];
    }
}
