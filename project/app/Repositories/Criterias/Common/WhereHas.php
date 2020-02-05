<?php

namespace App\Repositories\Criterias\Common;

use App\Repositories\Criterias\Criteria;
use App\Repositories\Repository;

class WhereHas extends Criteria
{
    private $role = null;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->whereHas("roles", function($q){ $q->where("name", $this->role); });
    }
}
