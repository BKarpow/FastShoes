<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id' => $this->id,
            'sectionId' => $this->section_id,
            'sectionName' => $this->section->title,
            'title' => $this->title,
            'alias' => $this->alias,
            'description' => $this->description,
            'show' => (bool)$this->show,
            'createdAt' => $this->createdDate(),
            'updatedAt' => $this->updatedDate(),
        ];;
    }
}
