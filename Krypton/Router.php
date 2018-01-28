<?php

namespace Krypton;

class Router
{
	private $url;
	private $base;
	private $routes;
	private $parameter;
	public function __construct()
	{
		$this->url = $_SERVER ['QUERY_STRING'];
		$this->base = explode ( '/', $_SERVER ['QUERY_STRING'] ) [1];
		$this->query = explode ( '/', $this->url );
		
		array_shift ( $this->query );
		
		$this->routes = [ ];
	}
	public function add(string $path, callable $function)
	{
		$this->routes [] = [ 
				'base' => explode ( '/', $path )[1],
				'path' => $path,
				'func' => $function 
		
		];
	}
	public function run()
	{
		foreach ( $this->routes as $route )
		{
			
			if ($this->base == $route ['base'])
			{
				$route ['path'] = str_replace ( '/', '\/', $route ['path'] );
				$r = preg_match ( '/' . $route ['path'] . '/', $this->url, $matches );
				
				array_shift($matches);
				
				call_user_func_array($route['func'], $matches);
			}
		}
	}
}