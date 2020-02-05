<?php

namespace App\Helpers;

class CacheManager
{
    /**
     * Resolve o resultado de uma chave de cache e retorna seu valor.
     * @param  string $key Chave de cache
     * @param  string $ttl Tempo de duração do cache. Ver guia de formatos
     * relativos em http://php.net/manual/pt_BR/datetime.formats.relative.php
     * @param  callable $value Valor a ser criado cache
     * @param  array $tags Marcações para a chave de cache
     * @return mixed
     */
    public function remember(
        string $key,
        string $ttl,
        callable $value,
        array $tags = []
    ) {
        $applicationCacheIsEnabled = config('cache.enable_application_cache');
        if (!$applicationCacheIsEnabled) {
            return value($value);
        }
        $ttl = \DateInterval::createFromDateString($ttl);

        if (!empty($tags)) {
            return cache()->tags($tags)->remember($key, $ttl, $value);
        }
        return cache()->remember($key, $ttl, $value);
    }

    /**
     *  Faz cache de um resultado apenas durante a sessão atual.
     * @param  string $key Chave de cache
     * @param  \App\Helpers\Closure|callable $value Valor a ser criado cache
     * @return mixed
     */
    public function sessionCache(string $key, Closure $value)
    {
        $sessionCacheIsEnabled = config('cache.enable_application_session_cache');
        if (!$sessionCacheIsEnabled) {
            return value($value);
        }
        $ttl = \DateInterval::createFromDateString('1 minute');
        return cache()
            ->driver('array')
            ->remember($key, $ttl, $value);
    }
}
