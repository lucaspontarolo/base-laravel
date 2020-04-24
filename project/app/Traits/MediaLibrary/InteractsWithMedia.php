<?php

namespace App\Traits\MediaLibrary;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\InteractsWithMedia as BaseInteractsWithMedia;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait InteractsWithMedia
{
    use BaseInteractsWithMedia;

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
