<?php

namespace Krypton\Apps;

require_once 'Krypton/App.php';

require_once 'Krypton/HTMLTemplateParser.php';
require_once 'Krypton/RouteFactory.php';
require_once 'Krypton/Router.php';
require_once 'Krypton/Database.php';

use Krypton\App;
use Krypton\HTMLTemplateParser;


class AdminDashboard implements App
{
	public static function run(): string
	{
		$content = '';

		
		$HTMLTemplateParser = new HTMLTemplateParser ( __DIR__ . DIRECTORY_SEPARATOR . 'AdminDashboard/templates/widget.tpl' );
		
		$HTMLTemplateParser->assign ( 'LINK_PAGES', '#' );
		$HTMLTemplateParser->assign ( 'ACTIVE_PAGES', '' );
		
		$HTMLTemplateParser->assign ( 'LINK_USERS', '#' );
		$HTMLTemplateParser->assign ( 'ACTIVE_USERS', '' );
		
		$HTMLTemplateParser->assign ( 'LINK_SYSTEM', '#' );
		$HTMLTemplateParser->assign ( 'ACTIVE_SYSTEM', '' );
		
		$HTMLTemplateParser->assign ( 'LINK_ROLES', '#' );
		$HTMLTemplateParser->assign ( 'ACTIVE_ROLES', '' );
		
		
		$HTMLTemplateParser->assign ( 'LINK_APPS', '#' );
		$HTMLTemplateParser->assign ( 'ACTIVE_APPS', '' );
		
		$HTMLTemplateParser->assign ( 'CONTENT', $content );
		
		return $HTMLTemplateParser->build ( true );
	}
}
