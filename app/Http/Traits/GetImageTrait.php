<?php

namespace App\Http\Traits;

trait GetImageTrait
{

   /**
     * Get the file before delete picture
     *
     * @param getImage $image
     * @return string
     */
    public function getImage($image){
        $images = explode("/",$image);
        return $images[5];
    }
}