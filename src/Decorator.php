<?php

namespace Marmelab\Microrest;

use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Decorator
 * @package Marmelab\Microrest
 */
abstract class Decorator
{
    /**
     * This method is called before the QueryBuilder is executed on GET /apiObjects <br>
     * It allows to add where clause to the QueryBuilder based on Request parameters.
     * @param QueryBuilder $queryBuilder
     * @param Request $request
     * @return QueryBuilder
     */
    public abstract function beforeGetList(QueryBuilder $queryBuilder, Request $request);

    /**
     * This method is called after the query has been executed on GET /apiObjects <br>
     * It allows to transform the result retrieved from the executed query.
     * @param $result array
     * @return array
     */
    public abstract function afterGetList($result);

    /**
     * This method is called after the query has been executed on GET /apiObject/ <br>
     * It allows to transform the result retrieved from the executed query.
     * @param $result array
     * @return array
     */
    public abstract function afterGetObject($result);

    /**
     * This method is called after a query has been executed with transformed result (see afterGetObject and afterGetList methods).<br>
     * It allows to wrap and format the result in a JsonResponse.
     * @param $results array
     * @return JsonResponse
     */
    public abstract function format($results);

}