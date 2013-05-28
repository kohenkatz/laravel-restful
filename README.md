Restful Controller for Laravel
==============================

A base controller for laravel that handles formatting.

Installation
------------

### Composer

``` composer require "rob-mccann/laravel-restful" ```

Once you've grabbed the code, you'll need to add the RoutingServiceProvider to the list of providers in app/config/app.php as follows

```
'providers' => array(
    ...
  'RobMcCann\Restful\RoutingServiceProvider',
),
```


Usage
-----

The concept uses the same principles as laravel's [resource routing](http://four.laravel.com/docs/controllers#resource-controllers).
Your controller should extend the one in this package.
Each action should return an array which will automatically be formatted.

Add the route to app/routes.php:

```
Route::resource('posts', 'PostsController');
```

Then add the controller as follows

```
use RobMcCann\Restful\RestfulController as Controller;

class PostController extends Controller {
    public function index() {
        return array(
            array(
                'id' => 1,
                'title' => 'Released a RESTful controller',
            ),
        );
    }
}
```


Notes
-----

I plan on changing some of the internals and class struture within this package but the implmentation *shouldn't* be affected.

Todo
----
1. Split the controller down so that the encoding happens elsewhere to allow for easier extending
2. Add other encoders (php array, csv etc)
3. Add more documentation
4. Investigate if traits would be better suited for parts
5. Investigate making this framework agnostic (unlikely, but worth thinking about at least)

