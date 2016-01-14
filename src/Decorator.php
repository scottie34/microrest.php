<?php

namespace Marmelab\Microrest;

use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

abstract class Decorator
{
    public abstract function beforeGetList(QueryBuilder $queryBuilder, Request $request);
}