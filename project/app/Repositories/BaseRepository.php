<?php

namespace App\Repositories;

class BaseRepository extends Repository
{
    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
        parent::__construct();
    }

    protected function getClass()
    {
        return $this->className;
    }
}
