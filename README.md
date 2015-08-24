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

How can i add a middleware?
--------------------------

```php

$collector->get('/', ['_middleware' => ['name' => 'middlewarename', 'role' => 'aaa', 'next' => function(){}]]);

```

How can i add a middleware in a controller?
----------------------------------------

```php

public function __construct(){
  $this->middleware('middlewarename');
}

```

How can i create a Controller
--------------------------

add it to composer.json
```php

"Anonym\Controllers": "path"

```

and create controller in the "path"

```php

use Anonym\Components\Route\Controller;

class Test extends Controller{

   // do nothing

}

```


---------------

```php

$collector->get('/{test}', 'Controller:method'); // {test} is required
$collector->get('/{test!}', 'Controller:method'); // {test!} is required
$collector->get('/{test?}', 'Controller:method'); // {test?} is optional

```
