<?php

namespace Krypton;

require_once 'Route.php';
class RouteController
{
	private $routes;
	private $url;
	private $routeBase, $urlParameter;
	public function __construct(array $routes = [])
	{
		$this->routes = $routes;
		
		$this->urlParameter = explode ( '/', $_SERVER ['QUERY_STRING'] );
		$this->routeBase = $this->urlParameter [0];
		array_shift ( $this->urlParameter );
	}
	public function add(Route $newRoute)
	{
		$this->routes [] = $newRoute;
	}
	public function execute()
	{
		$valid_route = false;
		
		// Check if each route matches the query url
		foreach ( $this->routes as $route )
		{
			
			if ($route->base === $this->routeBase)
			{
				$patterns = explode ( '/', $route->path );
				for($i = 0; $i < count ( $patterns ); $i ++)
				{
					if (isset ( $this->urlParameter [$i] ))
					{
						preg_replace ( '/' . $patterns [$i] . '/', $this->urlParameter [$i], $route->path );
					}
					else
					{
						preg_replace ( $patterns [$i], 'null', $route->path );
					}
				}
				var_dump($route->path);
				
				$valid_route = true;
				// run the function that is bound to the route
				$route->run ();
			}
		}
		if (! $valid_route)
		{
			echo '404';
		}
	}
}