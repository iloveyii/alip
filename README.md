Alip Framework
=======
This a light PHP framework based on MVC pattern. The model has the business logic like validation. The view has the presentation (html) logic. The controller handles the different types of HTTP request. But before controller we need a router to route the request to designated controller based on the request URI.
We have implemented a very light Router class that handles GET, POST, UPDATE and DELETE methods.

This framework does not use any built in libraries or packages. All code is custom written. It only uses composer for autoloading.

This framework is useful for a light PHP web application or RESTFull API application. This has been used on site [Simple Blog](http://alip.softhem.se).


## Setup and first run

  * First clone the repository.
  * Then run composer command `composer dump-autoload`.
  * You need to enable mode rewrite and use the file `.htaccess` in the root directory.
  * Create a database (manually for now) and import the `alip.sql` file at the root directory.
  * Adjust the database credentials in the `config/db.php` file as per your environment.

For more information about using Composer please see its [documentation](http://getcomposer.org/doc/).

## How to use the framework

This framework is very easy to be used. You can create an object of the router by passing a request object to it as shown below.

```
// index.php
require_once 'vendor/autoload.php';
require_once 'config/db.php';

use App\Models\Router;
use App\Models\Request;

/**
 * First create router object with params Request object and default route
 */
$router = new Router(new Request, '/posts/index');

/**
 * Next declare the http methods
 */
$router->get('/posts/index', function ($request) {
    $controller = new \App\Controllers\PostController($request);
    $controller->index();
});
```

DEMO is here [DEMO](http://alip.softhem.se).

## Overall Structure

Bellow the directory structure used:

```
   |-assets
   |---css
   |---js
   |-config
   |---db.php
   |-controllers
   |-models
   |---Request.php
   |---Router.php
   |-views
   |-index.php
   
  
 ```

   
<i>Web development has never been so fun.</i>  
[Hazrat Ali](http://blog.softhem.se/) 
