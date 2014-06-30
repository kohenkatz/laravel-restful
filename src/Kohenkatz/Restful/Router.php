<?php namespace Kohenkatz\Restful;

use Illuminate\Routing\Router as LaravelRouter;

class Router extends LaravelRouter {
	/**
	 * Add the index method for a resourceful route.
	 *
	 * @param  string  $name
	 * @param  string  $base
	 * @param  string  $controller
	 * @param  array   $options
	 * @return Route
	 */
	protected function addResourceIndex($name, $base, $controller, $options)
	{
		$action = $this->getResourceAction($name, $controller, 'index', $options);

		return $this->get($this->getResourceUri($name).'.{format?}', $action);
	}

	/**
	 * Add the create method for a resourceful route.
	 *
	 * @param  string  $name
	 * @param  string  $base
	 * @param  string  $controller
	 * @param  array   $options
	 * @return Route
	 */
	protected function addResourceCreate($name, $base, $controller, $options)
	{
		$action = $this->getResourceAction($name, $controller, 'create', $options);

		return $this->get($this->getResourceUri($name).'/create.{format?}', $action);
	}

	/**
	 * Add the store method for a resourceful route.
	 *
	 * @param  string  $name
	 * @param  string  $base
	 * @param  string  $controller
	 * @param  array   $options
	 * @return Route
	 */
	protected function addResourceStore($name, $base, $controller, $options)
	{
		$action = $this->getResourceAction($name, $controller, 'store', $options);

		return $this->post($this->getResourceUri($name).'.{format?}', $action);
	}

	/**
	 * Add the show method for a resourceful route.
	 *
	 * @param  string  $name
	 * @param  string  $base
	 * @param  string  $controller
	 * @param  array   $options
	 * @return Route
	 */
	protected function addResourceShow($name, $base, $controller, $options)
	{
		$uri = $this->getResourceUri($name).'/{'.$base.'}.{format?}';

		return $this->get($uri, $this->getResourceAction($name, $controller, 'show', $options));
	}

	/**
	 * Add the edit method for a resourceful route.
	 *
	 * @param  string  $name
	 * @param  string  $base
	 * @param  string  $controller
	 * @param  array   $options
	 * @return Route
	 */
	protected function addResourceEdit($name, $base, $controller, $options)
	{
		$uri = $this->getResourceUri($name).'/{'.$base.'}/edit.{format?}';

		return $this->get($uri, $this->getResourceAction($name, $controller, 'edit', $options));
	}

	/**
	 * Add the update method for a resourceful route.
	 *
	 * @param  string  $name
	 * @param  string  $base
	 * @param  string  $controller
	 * @param  array   $options
	 * @return void
	 */
	protected function addResourceUpdate($name, $base, $controller, $options)
	{
		$this->addPutResourceUpdate($name, $base, $controller, $options);

		return $this->addPatchResourceUpdate($name, $base, $controller);
	}

	/**
	 * Add the update method for a resourceful route.
	 *
	 * @param  string  $name
	 * @param  string  $base
	 * @param  string  $controller
	 * @param  array   $options
	 * @return Route
	 */
	protected function addPutResourceUpdate($name, $base, $controller, $options)
	{
		$uri = $this->getResourceUri($name).'/{'.$base.'}.{format?}';

		return $this->put($uri, $this->getResourceAction($name, $controller, 'update', $options));
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
	 * @param  array   $options
	 * @return Route
	 */
	protected function addResourceDestroy($name, $base, $controller, $options)
	{
		$action = $this->getResourceAction($name, $controller, 'destroy', $options);

		return $this->delete($this->getResourceUri($name).'/{'.$base.'}.{format?}', $action);
	}
}
