<?php

namespace Krypton;

/**
 *
 * @author Sepp
 *        
 */
class RouteFactory
{
	private $url, $server;
	public $query;
	
	public static function init(): self
	{
		$_ = new self ();
		
		$_->url = $_SERVER ['QUERY_STRING'];
		$_->query = explode ( '/', $_->url );
		$_->server = $_SERVER ['SERVER_NAME'];
		
		return $_;
	}
	public function get(bool $absolute = true)
	{
		if ($absolute)
		{
			return '//' . $this->server . '/?' . $this->url;
		}
		else
		{
			return $this->url;
		}
	}
	public function isset(string $query)
	{
		return in_array ( $query, $this->query );
	}
	public function build(array $queries, bool $absolute = true)
	{
		$route = '';
		
		foreach ( $queries as $data )
		{
			$route .= '/' . $data;
		}
		// return absolute url
		if ($absolute)
		{
			return '//' . $this->server . '/?' . $route;
		}
		else
		{
			return $route;
		}
	}
}

