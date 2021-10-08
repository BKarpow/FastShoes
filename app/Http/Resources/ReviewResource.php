<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'id' => (int) $this->id,
            'userId' => (int) $this->user_id,
            'create' => $this->createdDate(),
            'comment' => $this->comment,
            'avatar' => $this->user->avatar,
            'name' => $this->user->name,
            'rating' => (int) $this->rating,
        ];
    }
}
