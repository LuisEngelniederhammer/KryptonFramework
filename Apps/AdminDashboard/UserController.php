<?php

namespace Krypton\Apps\AdminDashboard;

require_once 'Controller.php';
require_once 'Krypton/HTMLTemplateParser.php';
require_once 'Krypton/URIQueryController.php';
require_once 'Krypton/Database.php';

use Krypton\Apps\AdminDashboard\Controller;
use Krypton\HTMLTemplateParser;
use Krypton\System;
use Krypton\URIQueryController;
use Krypton\Database;


class UserController extends Controller
{

	public function __construct(string &$output)
	{
		parent::__construct ( 'users' );
		
		if (isset ( $_GET ['action'] ))
		{
			if ($_GET ['action'] == 'edit' && isset ( $_GET ['id'] ))
			{
				/*
				 * Display user as Form
				 * Editable fields: name, content, roles
				 *
				 */
				
				$user = $this->get ( $_GET ['id'] );
				
				$HTMLTemplateParser = new HTMLTemplateParser ( __DIR__ . DIRECTORY_SEPARATOR . 'templates/editUser.tpl' );
				
				$uri = URIQueryController::get ();
				$uri->query ['action'] = 'process';
				
				$HTMLTemplateParser->assign ( 'POST_ACTION', $uri->build () );
				$HTMLTemplateParser->assign ( 'ID', $user ['id'] );
				$HTMLTemplateParser->assign ( 'NAME', $user ['name'] );
				// $HTMLTemplateParser->assign ( 'PASSWORD', $user['password'] );
				$HTMLTemplateParser->assign ( 'ROLE', $user ['role'] );
				

				unset ( $uri->query ['id'] );
				unset ( $uri->query ['action'] );
				
				$HTMLTemplateParser->assign ( 'LINK', $uri->build () );
				

				$output .= $HTMLTemplateParser->build ();
			}
			elseif ($_GET ['action'] == 'process')
			{
				/*
				 * Catch Form Submits
				 * Depending on the name of the Submit input field, POST Varaibles will be processed
				 *
				 */
				if (isset ( $_POST ['user_update'] ) && isset ( $_GET ['id'] ))
				{
					$name = $_POST ['user_name'];
					$password = $_POST ['user_password'];
					$role = $_POST ['user_role'];
					
					$db = new Database ();
					$queryAddition = '';
					if (! empty ( $password ))
					{
						$queryAddition = 'password=:password,';
					}
					
					$query = $db->prepare ( 'UPDATE users SET name=:name, ' . $queryAddition . ' role=:role WHERE id = :id' );
					
					$query->bindValue ( ':name', $name );
					if (! empty ( $queryAddition ))
					{
						$query->bindValue ( ':password', $password );
					}
					$query->bindValue ( ':role', $role );
					$query->bindParam ( ':id', $_GET ['id'] );
					

					$result = $query->execute ();
					$uri = URIQueryController::get ();
					$uri->query ['action'] = 'edit';
					System::setURLEx ( $uri->build () );
				}
				elseif (isset ( $_POST ['user_delete'] ) && isset ( $_GET ['id'] ))
				{
					$this->delete ( $_GET ['id'] );
					
					$uri = URIQueryController::get ();
					unset ( $uri->query ['id'] );
					unset ( $uri->query ['action'] );
					System::setURLEx ( $uri->build () );
				}
				elseif (isset ( $_POST ['user_create'] ))
				{
					$name = $_POST ['user_name'];
					$password = password_hash ( $_POST ['user_password'], PASSWORD_DEFAULT );
					$role = $_POST ['user_role'];
					
					$this->create ( $name, $password, $role );
					
					$uri = URIQueryController::get ();
					unset ( $uri->query ['action'] );
					System::setURLEx ( $uri->build () );
				}
				else
				{
					/*
					 * If no or unknown submit was passed, return to the Users overview
					 *
					 */
					$uri = URIQueryController::get ();
					unset ( $uri->query ['id'] );
					unset ( $uri->query ['action'] );
					
					System::setURLEx ( $uri->build () );
				}
			}
			elseif ($_GET ['action'] == 'create')
			{
				/*
				 * Display Form for user creation
				 * Editable fields: name,password,roles
				 */
				$HTMLTemplateParser = new HTMLTemplateParser ( __DIR__ . DIRECTORY_SEPARATOR . 'templates/createUser.tpl' );
				$uri = URIQueryController::get ();
				$uri->query ['action'] = 'process';
				
				$HTMLTemplateParser->assign ( 'POST_ACTION', $uri->build () );
				
				unset ( $uri->query ['id'] );
				unset ( $uri->query ['action'] );
				
				$HTMLTemplateParser->assign ( 'LINK', $uri->build () );
				
				$output .= $HTMLTemplateParser->build ();
			}
		}
		else
		{
			
			$HTMLTemplateParser_TABLE = new HTMLTemplateParser ( __DIR__ . DIRECTORY_SEPARATOR . 'templates/displayUsers.tpl' );
			$HTMLTemplateParser_ROWS = new HTMLTemplateParser ( __DIR__ . DIRECTORY_SEPARATOR . 'templates/displayRows.tpl', true );
			

			if (! isset ( $_GET ['offset'] ))
			{
				$_GET ['offset'] = 0;
			}
			
			$result = $this->getLimit ( ( int ) $_GET ['offset'], 10 );
			
			$ROWS = "";
			$uri = URIQueryController::get ();
			foreach ( $result as $token )
			{
				$HTMLTemplateParser_ROWS->assign ( 'ID', $token ['id'] );
				$HTMLTemplateParser_ROWS->assign ( 'NAME', $token ['name'] );
				
				$uri = URIQueryController::get ();
				$uri->query ['action'] = 'edit';
				$uri->query ['id'] = $token ['id'];
				
				$HTMLTemplateParser_ROWS->assign ( 'LINK', $uri->build () );
				
				$ROWS .= $HTMLTemplateParser_ROWS->build ();
				$HTMLTemplateParser_ROWS->reset ();
			}
			$uri->query ['action'] = 'create';
			unset ( $uri->query ['id'] );
			
			$HTMLTemplateParser_TABLE->assign ( 'LINK', $uri->build () );
			$HTMLTemplateParser_TABLE->assign ( 'ROWS', $ROWS );
			$output .= $HTMLTemplateParser_TABLE->build ( true );
		}
	}

}
