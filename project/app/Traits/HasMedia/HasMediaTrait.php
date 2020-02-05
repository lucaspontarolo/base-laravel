<?php

namespace App\Traits\HasMedia;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait as MediaTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait HasMediaTrait
{
    use MediaTrait;

    public function addMediaWithHashedName($file)
    {
        return $this->addMedia($file)
            ->usingName($this->getBaseFileName($file))
            ->usingFileName($file->hashName());
    }

    private function getBaseFileName(UploadedFile $file)
    {
        $baseFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        return Str::slug($baseFileName);
    }
}
