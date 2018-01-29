<?php

namespace Krypton\Apps;

require_once 'Krypton/App.php';
require_once 'Krypton/Database.php';
require_once 'Krypton/HTMLTemplateParser.php';

require_once 'Krypton/RouteFactory.php';

require_once 'Login.php';

use Krypton\App;
use Krypton\Database;
use Krypton\HTMLTemplateParser;
use Krypton\RouteFactory;

class Menu implements App
{
	// private:
	private $db;
	
	// public:
	public static function run(): string
	{
		$inst = new self ();
		$inst->db = new Database ();
		$result = $inst->db->query ( 'SELECT id,name,roles FROM pages' );
		$menu = [ ];
		while ( $row = $result->fetchArray ( SQLITE3_ASSOC ) )
		{
			$menu [] = $row;
		}
		
		$items = '';
		
		$HTMLtpl_ITEM = new HTMLTemplateParser ( __DIR__ . DIRECTORY_SEPARATOR . 'Menu/tpl/item.tpl', true );
    	
    	foreach ( $menu as $token )
		{
			if (in_array ( '*', json_decode ( $token ['roles'], true ) ) || @in_array ( $_SESSION ['Client.role'], json_decode ( $token ['roles'], true ) ))
			{
				
				$HTMLtpl_ITEM->assign ( 'ITEM_LINK', RouteFactory::init()->build(['page',$token['id']]) );
				$HTMLtpl_ITEM->assign ( 'ITEM_NAME', $token ['name'] );
				
				$items .= $HTMLtpl_ITEM->build ();
				$HTMLtpl_ITEM->reset ();
			}
		}
		
		$HTMLtpl = new HTMLTemplateParser ( __DIR__ . DIRECTORY_SEPARATOR . 'Menu/tpl/menu.tpl' );
		$HTMLtpl->assign ( 'MENU_ITEMS', $items );
		$HTMLtpl->assign ( 'LOGIN_APP', Login::run () );
		return $HTMLtpl->build ( true );
	}
}
