<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait Meta 
{

    
    /**
     * Return to plain text of description. Max length 200
     * @return string
     */
    public function metaDescription():string
    {
        $desc = '';
        if (!$this->description) {
            return $desc;
        }
        $desc = strip_tags($this->description);
        $desc = preg_replace('#\s+#si', ' ', $desc);
        $desc = preg_replace('#\&nbsp\;#si', "", $desc);
        $desc = preg_replace('#[^a-zA-Z\d\-\.\,а-яА-ЯШшЁёіІїЇєЄ\s]#siu', "", $desc);
        if (Str::length($desc) > 199) {
            $desc = Str::limit($desc, 197, '...');
        }
        return $desc;
    }
}