<?php

namespace Marmelab\Microrest;

use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class Decorator
{
    public abstract function beforeGetList(QueryBuilder $queryBuilder, Request $request);

    public abstract function afterGetList($result);

    public abstract function afterGetObject($result);

    public abstract function format($results);

}