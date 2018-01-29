<?php

namespace Krypton\Apps;

require_once 'Krypton/App.php';
require_once 'Krypton/Database.php';
require_once 'Krypton/System.php';
require_once 'Krypton/HTMLTemplateParser.php';

use Krypton\App;

use Krypton\System;
use Krypton\HTMLTemplateParser;
use Krypton\Database;


class Login implements App
{
	// private:
	private $db;

	private function checkLogin() // :void
	{
		if (! isset ( $_POST ['user'] ) || ! isset ( $_POST ['password'] ))
		{
			System::setURL(System::getDefaultPage(),0,['response','login_fail_no_data_sent']);
		}
		$db = new Database ();
		
		$query = $db->prepare ( 'SELECT * FROM users WHERE name=:name' );
		$query->bindParam ( ':name', $_POST ['user'] );
		$result = $query->execute ();
		$arr = $result->fetchArray ();
		if (! $arr)
		{
			System::setURL ( System::getDefaultPage (), 0, ['response','login_fail_user_inexistent'] );
			die ();
		}
		
		if (password_verify ( $_POST ['password'], $arr ['password'] ))
		{
			$_SESSION ['Client.id'] = $arr ['id'];
			$_SESSION ['Client.password'] = $arr ['password'];
			$_SESSION ['Client.name'] = $arr ['name'];
			$_SESSION ['Client.role'] = $arr ['role'];
			System::setURL ( System::getDefaultPage (), 0, ['response','login_success'] );
			die ();
		}
		else
		{
			System::setURL ( System::getDefaultPage (), 0, ['response','login_fail_wrong_user_or_password']);
			die ();
		}
	}

	// public:
	public static function run(): string
	{
		$_this = new self ();
		
		$output = '';
		$HTMLTpl = new HTMLTemplateParser (  __DIR__.DIRECTORY_SEPARATOR.'Login/tpl/main.tpl' );
		
		if (! isset ( $_SESSION ['Client.id'] ))
		{
			if (isset ( $_POST ['login_process'] ))
			{
				$_this->checkLogin ();
			}
			else
			{
				
				$HTMLTpl_FORM = new HTMLTemplateParser ( __DIR__.DIRECTORY_SEPARATOR.'Login/tpl/loginForm.tpl' );
				$HTMLTpl_FORM->assign ( 'POST_ACTION', '' );
				

				$HTMLTpl->assign ( 'DISPLAY', $HTMLTpl_FORM->build () );

				
			}
		}
		if (isset ( $_GET ['response'] ))
		{
			
			$HTMLTpl_ERROR = new HTMLTemplateParser (  __DIR__.DIRECTORY_SEPARATOR.'Login/tpl/error.tpl' );
			$HTMLTpl_ERROR->assign ( 'ERROR_MESSAGE', addslashes ( $_GET ['response'] ) );
			
			$HTMLTpl->assign ( 'ERROR_DISPLAY', $HTMLTpl_ERROR->build () );
		}
		$output .= $HTMLTpl->build (true);
		return $output;
	}

}


