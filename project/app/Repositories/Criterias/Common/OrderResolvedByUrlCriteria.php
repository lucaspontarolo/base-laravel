<?php

namespace App\Repositories\Criterias\Common;

use Illuminate\Support\Facades\Request;
use App\Repositories\Criterias\Criteria;
use App\Repositories\Repository;

class OrderResolvedByUrlCriteria extends Criteria
{
    private $defaultOrderBy;

    public function __construct($defaultOrderBy)
    {
        $this->defaultOrderBy = $defaultOrderBy;
    }

    public function apply($queryBuilder, Repository $repository)
    {
        $field = Request::get('field') ?? $this->defaultOrderBy['field'] ?? 'updated_at';
        $order = Request::get('order') ?? $this->defaultOrderBy['order'] ?? 'desc';

        $queryBuilder = $queryBuilder->orderBy($field, $order);

        return $queryBuilder;
    }
}
