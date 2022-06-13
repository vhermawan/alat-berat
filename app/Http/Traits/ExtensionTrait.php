<?php

namespace App\Http\Traits;

use App\Http\Traits\Mime;

trait ExtensionTrait
{   
    use Mime;
    /**
     * @param $encoded
     * @return $extension
     */
    public function getExtension($encoded){
        $decoded_file = base64_decode($encoded); // decode the file
        $mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE); // extract mime type
        $extension = $this->mime2ext($mime_type); // extract extension from mime type
        return $extension;
    }
}