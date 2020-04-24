<?php

namespace App\Generators;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator;

class CustomPathGenerator extends DefaultPathGenerator
{
    public function getBasePath(Media $media): string
    {
        $modelBaseName = mb_strtolower(class_basename($media->model_type));
        return $modelBaseName . '/' .  $media->collection_name . '/' . $media->model_id . '/' . $media->getKey();
    }
}
