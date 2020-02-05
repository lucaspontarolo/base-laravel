<?php

namespace App\Generators;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\BasePathGenerator;

class CustomPathGenerator extends BasePathGenerator
{
    public function getBasePath(Media $media): string
    {
        $modelBaseName = mb_strtolower(class_basename($media->model_type));
        return $modelBaseName . '/' .  $media->collection_name . '/' . $media->model_id . '/' . $media->getKey();
    }
}
