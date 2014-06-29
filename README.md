Restful Controller for Laravel
==============================

A base controller for laravel that handles formatting.

Installation
------------

### Composer

``` composer require "kohenkatz/laravel-restful" ```

Once you've grabbed the code, you'll need to add the RoutingServiceProvider to the list of providers in `app/config/app.php` as follows

```
'providers' => array(
    ...
  'Kohenkatz\Restful\RoutingServiceProvider',
),
```


Usage
-----

The concept uses the same principles as laravel's [resource routing](http://laravel.com/docs/controllers#resource-controllers).
Your controller should extend the one in this package.
Each action should return an array which will automatically be formatted.

Add the route to `app/routes.php`:

```
Route::resource('posts', 'PostsController');
```

Then add the controller as follows

```
use Kohenkatz\Restful\RestfulController;

class PostController extends RestfulController {
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

Todo
----
1. Split the controller down so that the encoding happens elsewhere to allow for easier extending
2. Add other encoders (php array, csv etc)
3. Add more documentation
4. Investigate if traits would be better suited for parts
