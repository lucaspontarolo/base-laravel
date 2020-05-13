<?php

namespace App\Repositories\Criterias\Common;

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
        $field = request()->input('field') ?? data_get($this->defaultOrderBy, 'field');
        $order = request()->input('order') ?? $this->defaultOrderBy['order'] ?? 'desc';

        if ($field) {
            $queryBuilder->reorder($field, $order);
        }

        return $queryBuilder;
    }
}
