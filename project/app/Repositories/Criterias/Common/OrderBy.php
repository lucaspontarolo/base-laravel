<?php

namespace App\Repositories\Criterias\Common;

use App\Repositories\Criterias\Criteria;
use App\Repositories\Repository;

class OrderBy extends Criteria
{
    private $order;
    private $column;

    public function __construct($column, $order = 'asc')
    {
        $this->order = $order;
        $this->column = $column;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        return $queryBuilder->orderBy($this->column, $this->order);
    }
}
