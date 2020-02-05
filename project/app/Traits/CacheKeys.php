<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait CacheKeys
{
    public function cacheKeyUpgradeable($suffix = '')
    {
        if ($suffix != '') {
            $suffix = Str::start($suffix, ':');
        }

        return sprintf(
            "%s/%s-%s%s",
            $this->getTable(),
            $this->getKey(),
            $this->updated_at->timestamp,
            $suffix
        );
    }

    public function cacheKey($suffix = '')
    {
        if ($suffix != '') {
            $suffix = Str::start($suffix, ':');
        }

        return sprintf(
            "%s/%s%s",
            $this->getTable(),
            $this->getKey(),
            $suffix
        );
    }
}
