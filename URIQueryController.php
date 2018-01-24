<?php
namespace Krypton;

class URIQueryController
{
	// public:
	public $query;

	public static function get()
	{
		$_this = new self ();
		$_this->URI = $_SERVER ['REQUEST_URI'];
		$_this->query = [ ];
		$tmp = explode ( '?', $_this->URI );
		
		$_this->file = substr ( $tmp [0], 1 );
		
		if (count ( $tmp ) > 1)
		{
			$tmp = explode ( '&', $tmp [1] );
			
			foreach ( $tmp as $query )
			{
				$tmp_sub = explode ( '=', $query );
				
				if (count ( $tmp_sub ) > 1)
				{
					$_this->query [$tmp_sub [0]] = $tmp_sub [1];
				}
				else
				{
					$_this->query [] = $tmp_sub [0];
				}
			}
		}
		return $_this;
	}

	public function __toString()
	{
		return $this->build();
	}

	public function build()
	{
		$newURL = '/' . $this->file . '?';
		foreach ( $this->query as $key => $value )
		{
			if (is_string ( $key ))
			{
				$newURL .= $key . '=' . $value . '&';
			}else 
			{
				$newURL .= $value . '&';
			}
		}
		if ( $newURL[strlen($newURL)-1] === '&')
		{
			$newURL = substr($newURL, 0, strlen($newURL)-1);
		}
		return $newURL;
	}

	// private:
	private $URI;
	private $file;
	
	private function __construct()
	{
	}

}