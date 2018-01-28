<?php

namespace Krypton;

/**
 *
 * @author Luis Engelniederhammer
 *        
 */
class Route
{
	public $path;
	private $base;
	private $function;
	public function __construct(string $path, callable $_function)
	{
		$this->path = $path;
		$this->base = explode ( '/', $path )[0];
		$this->function = $_function;
	}
	public function __get($ATTRIBUTE)
	{
		switch ($ATTRIBUTE)
		{
			case 'function' :
				return $this->function;
				break;
			case 'base' :
				return $this->base;
				break;
			case 'path' :
				return $this->path;
				break;
			default :
				return null;
				break;
		}
	}
	public function run()
	{
		$params = explode ( '/', $this->path );
		array_shift($params);
		
		call_user_func_array ( $this->function, $params );
	}
}

