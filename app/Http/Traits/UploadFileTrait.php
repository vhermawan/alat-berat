<?php

namespace App\Http\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\Http\Traits\ExtensionTrait;

trait UploadFileTrait
{
    use ExtensionTrait;
   /**
     * Upload the file with slugging to a given path
     *
     * @param UploadedFile $image
     * @param $path
     * @return string
     */
    public function uploadFile($image, $path){
        $ext = $this->getExtension($image);
        $data = base64_decode($image);
        \Storage::disk('public')->put($path."/".time().".".$ext, $data);
        $image_name = asset("/storage/".$path."/".time().".".$ext);
        return $image_name;
    }
}