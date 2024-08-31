<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;


trait FileUploadTrait
{

    public function movedAsset($folder)
    {
        return 'uploads/' . $folder . '/';
    }
    public function assetUrl($folder, $asset_link)
    {
        return 'uploads/' . $folder . '/' . $asset_link;
    }

    public function uploadFile($file, $folder)
    {
        $fileName = "";
        if ($file) {
            $uploadedFile = Storage::put($this->movedAsset($folder), $file);
            $fileName = basename($uploadedFile);
            $fileName = $this->assetUrl($folder,$fileName);
            return $fileName;
        }
    }

    public function deleteFile($path)
    {
        if($path!=null)
        {
            Storage::delete($path);
        }
    }
}
