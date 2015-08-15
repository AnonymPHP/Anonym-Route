#Anonym-Route

This is a route component for AnoynmFramework.

Launch the component
------------------

```php

include 'vendor/autoload.php';
use Anonym\Components\Route\RouteCollector;
use Anonym\Components\Route\Router;
use Anonym\Components\HttpClient\Request;
$collector = new RouteCollector();

```

How can i add a new route?
--------------

```php

$collector->get('uri', ['_controller' => 'Controller:method',
                        'access' => [
                         'role' => '',
                         'next' => null,
                         'name' => 'name',
                         ]]);


```

Which types are supported?
------------------

`GET`, `POST`, `HEAD`, `PUT`, `OPTIONS`, `DELETE`, `PATCH`

How to run?
-----------

```php

use Anonym\Components\Route\Router;

$router = new Router( new Request());
$router->run();

```

