<?php
namespace Krypton\Apps;

require_once 'Krypton/App.php';

require_once 'Krypton/HTMLTemplateParser.php';
require_once 'Krypton/URIQueryController.php';
require_once 'Krypton/Database.php';

require_once 'AdminDashboard/PageController.php';
require_once 'AdminDashboard/UserController.php';

//Header ( 'X-XSS-Protection: 0' );

use Krypton\App;

use Krypton\Database;
use Krypton\HTMLTemplateParser;
use Krypton\URIQueryController;

use Krypton\Apps\AdminDashboard\PageController;
use Krypton\Apps\AdminDashboard\UserController;

class AdminDashboard implements App
{

	public static function run(): string
	{
		$active_pages = '';
		$active_users = '';
		$active_system = '';
		$active_roles = '';
		$active_apps = '';
		$content = '';
		
		if (! isset ( $_GET ['view'] ))
		{
			$_GET ['view'] = 'system';
		}
		switch ($_GET ['view'])
		{
			case 'pages' :
				$active_pages = 'active';
				new PageController($content);
			break;
			//
			//
			//
			case 'users' :
				$active_users = 'active';
				new UserController($content);
			break;
			case 'system' :
				$active_system = 'active';
				$db = new Database ();
				$result = $db->query ( 'SELECT * FROM system' );
				while ( $row = $result->fetchArray ( SQLITE3_ASSOC ) )
				{
					$arr [] = $row;
				}
				$content .= print_r ( $arr, true );
			break;
			case 'roles' :
				$active_roles = 'active';
			break;
			case 'apps' :
				$active_apps = 'active';
			break;
			default :
				$content .= 'This administration page is not registered within the Dashboard widget';
			break;
		}
		

		$HTMLTemplateParser = new HTMLTemplateParser ( __DIR__.DIRECTORY_SEPARATOR.'AdminDashboard/templates/widget.tpl' );
		$uri = URIQueryController::get ();
		unset ( $uri->query ['action'] );
		unset ( $uri->query ['id'] );
		$uri->query ['view'] = 'pages';
		$HTMLTemplateParser->assign ( 'LINK_PAGES', $uri->build () );
		$HTMLTemplateParser->assign ( 'ACTIVE_PAGES', $active_pages );
		
		$uri->query ['view'] = 'users';
		$HTMLTemplateParser->assign ( 'LINK_USERS', $uri->build () );
		$HTMLTemplateParser->assign ( 'ACTIVE_USERS', $active_users );
		
		$uri->query ['view'] = 'system';
		$HTMLTemplateParser->assign ( 'LINK_SYSTEM', $uri->build () );
		$HTMLTemplateParser->assign ( 'ACTIVE_SYSTEM', $active_system );
		
		$uri->query ['view'] = 'roles';
		$HTMLTemplateParser->assign ( 'LINK_ROLES', $uri->build () );
		$HTMLTemplateParser->assign ( 'ACTIVE_ROLES', $active_roles );
		
		$uri->query ['view'] = 'apps';
		$HTMLTemplateParser->assign ( 'LINK_APPS', $uri->build () );
		$HTMLTemplateParser->assign ( 'ACTIVE_APPS', $active_apps );
		
		$HTMLTemplateParser->assign ( 'CONTENT', $content );
		
		return $HTMLTemplateParser->build ( true );
	}

}
