# Query Param Quick Win
Fork of [Microrest](https://github.com/marmelab/microrest.php) which allows to manage GET request params and format/wrap results.

# How To
## Implements a Decorator
```php
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
```

## Register your Decorator into the RestController
RestController::registerDecorator
```php
public function registerDecorator($objectType, Decorator $decorator)
```

## Example
A basic example can be found in [silex-fwk project](https://github.com/scottie34/silex-fwk)
* Controller/PostController.php
* in app/app.php 
```php
// creates the decorated restController
$app['microrest.restController'] = $app->share(function() use ($app) {
      $restController = new  Marmelab\Microrest\RestController($app['db']);
      $restController->registerDecorator('posts', new \SilexFwk\Decorator\PostDecorator());
      return $restController;
});
// THEN, register the microrestServiceProvider
$app->register(new Marmelab\Microrest\MicrorestServiceProvider(), array(
    'microrest.config_file' => __DIR__ . '/api.raml'
));
```

---------------------------------

# Marmelab Microrest

Microrest is a Silex provider to setting up a REST API on top of a relational database, based on a YAML (RAML) configuration file.

Check out the [launch post](http://marmelab.com/blog/2015/01/05/introducing-microrest-raml-api-in-silex.html).

## What is RAML ?

[RESTful API Modeling Language (RAML)](http://raml.org/) is a simple and succinct way of describing practically-RESTful APIs. It encourages reuse, enables discovery and pattern-sharing, and aims for merit-based emergence of best practices.   

You can easily set up a RAML file from [API Designer](http://api-portal.anypoint.mulesoft.com/raml/api-designer).     

## Installation

To install microrest.php library, run the command below and you will get the latest version:

```bash
composer require marmelab/microrest "~1.0@dev"
```

Enable `ServiceController`, `Doctrine` and `Microrest` service providers in your application:

```php
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/app.db',
    ),
));
$app->register(new Marmelab\Microrest\MicrorestServiceProvider(), array(
    'microrest.config_file' => __DIR__ . '/api.raml',
));
```
  
You need to give the path to the `RAML` file describing your API. You can find an example into the `tests/fixtures` directory.

Then, browse your new API REST on the url defined in the `baseUrl` configuration of your `RAML` api file.

## Tests

Run the tests suite with the following commands:

```bash
make install
make test
```

## Demo

You can find a complete demo application in `examples/ng-admin`. You just need 2 commands to install and run it:

```bash
make install-demo
make run-demo
```

Play with the Silex demo API at the url: `http://localhost:8888/api`

Explore the API using [ng-admin](https://github.com/marmelab/ng-admin) backend administration at the url: `http://localhost:8888/admin`

## License

microrest.php is licensed under the [MIT License](LICENSE), courtesy of [marmelab](http://marmelab.com).
