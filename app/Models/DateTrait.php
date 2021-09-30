<?php

namespace App\Models;

trait DateTrait 
{
    public function createdDate()
    {
        if (!empty($this->created_at)) {
            return $this->created_at->format('d-m-Y H:i');
        } else {
            return 'None';
        }
    }

    public function updatedDate()
    {
        if (!empty($this->updated_at)) {
            return $this->updated_at->format('d-m-Y H:i');
        } else {
            return 'None';
        }
    }
}