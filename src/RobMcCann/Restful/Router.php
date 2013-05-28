<?php

namespace RobMcCann\Restful;

use Illuminate\Routing\Router as LaravelRouter;

class Router extends LaravelRouter {
    /**
     * Add the index method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @return void
     */
    protected function addResourceIndex($name, $base, $controller)
    {
        $action = $this->getResourceAction($name, $controller, 'index');

        return $this->get($this->getResourceUri($name).'.{format?}', $action);
    }

    /**
     * Add the create method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @return void
     */
    protected function addResourceCreate($name, $base, $controller)
    {
        $action = $this->getResourceAction($name, $controller, 'create');

        return $this->get($this->getResourceUri($name).'/create.{format?}', $action);
    }

    /**
     * Add the store method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @return void
     */
    protected function addResourceStore($name, $base, $controller)
    {
        $action = $this->getResourceAction($name, $controller, 'store');

        return $this->post($this->getResourceUri($name).'.{format?}', $action);
    }

    /**
     * Add the show method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @return void
     */
    protected function addResourceShow($name, $base, $controller)
    {
        $uri = $this->getResourceUri($name).'/{'.$base.'}.{format?}';

        return $this->get($uri, $this->getResourceAction($name, $controller, 'show'));
    }

    /**
     * Add the edit method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @return void
     */
    protected function addResourceEdit($name, $base, $controller)
    {
        $uri = $this->getResourceUri($name).'/{'.$base.'}/edit.{format?}';

        return $this->get($uri, $this->getResourceAction($name, $controller, 'edit'));
    }

    /**
     * Add the update method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @return void
     */
    protected function addResourceUpdate($name, $base, $controller)
    {
        $this->addPutResourceUpdate($name, $base, $controller);

        return $this->addPatchResourceUpdate($name, $base, $controller);
    }

    /**
     * Add the update method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @return void
     */
    protected function addPutResourceUpdate($name, $base, $controller)
    {
        $uri = $this->getResourceUri($name).'/{'.$base.'}.{format?}';

        return $this->put($uri, $this->getResourceAction($name, $controller, 'update'));
    }

    /**
     * Add the update method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @return void
     */
    protected function addPatchResourceUpdate($name, $base, $controller)
    {
        $uri = $this->getResourceUri($name).'/{'.$base.'}.{format?}';

        $this->patch($uri, $controller.'@update');
    }

    /**
     * Add the destroy method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @return void
     */
    protected function addResourceDestroy($name, $base, $controller)
    {
        $uri = $this->getResourceUri($name).'/{'.$base.'}.{format?}';

        return $this->delete($uri, $this->getResourceAction($name, $controller, 'destroy'));
    }
}
