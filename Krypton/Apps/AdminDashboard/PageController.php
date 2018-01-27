<?php

namespace Krypton\Apps\AdminDashboard;

require_once 'Controller.php';
require_once 'Krypton/HTMLTemplateParser.php';
require_once 'Krypton/URIQueryController.php';
require_once 'Krypton/System.php';


use Krypton\Apps\AdminDashboard\Controller;
use Krypton\HTMLTemplateParser;
use Krypton\URIQueryController;
use Krypton\System;


class PageController extends Controller
{

	public function __construct(string &$output)
	{
		parent::__construct ( 'pages' );
		
		if (isset ( $_GET ['action'] ))
		{
			if ($_GET ['action'] == 'edit' && isset ( $_GET ['id'] ))
			{
				/*
				 * Display page as Form
				 * Editable fields: name, content, roles
				 *
				 */
				$page = $this->get ( $_GET ['id'] );
				$HTMLTemplateParser = new HTMLTemplateParser ( __DIR__ . DIRECTORY_SEPARATOR . 'templates/editPage.tpl' );
				
				$uri = URIQueryController::get ();
				$uri->query ['action'] = 'process';
				
				$HTMLTemplateParser->assign ( 'POST_ACTION', $uri->build () );
				$HTMLTemplateParser->assign ( 'ID', $page ['id'] );
				$HTMLTemplateParser->assign ( 'NAME', $page ['name'] );
				$HTMLTemplateParser->assign ( 'CONTENT', $page ['content'] );
				$HTMLTemplateParser->assign ( 'ROLES', $page ['roles'] );
				

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
				if (isset ( $_POST ['page_update'] ) && isset ( $_GET ['id'] ))
				{
					$name = $_POST ['page_name'];
					$content = $_POST ['page_content'];
					$roles = $_POST ['page_roles'];
					
					$this->update ( $_GET ['id'], [ 
							'name' => $name,
							'content' => $content,
							'roles' => $roles 
					] );
					
					$uri = URIQueryController::get ();
					$uri->query ['action'] = 'edit';
					

					System::setURLEx ( $uri->build () );
				}
				elseif (isset ( $_POST ['page_delete'] ) && isset ( $_GET ['id'] ))
				{
					$this->delete ( $_GET ['id'] );
					
					$uri = URIQueryController::get ();
					unset ( $uri->query ['id'] );
					unset ( $uri->query ['action'] );
					
					System::setURLEx ( $uri->build () );
				}
				elseif (isset ( $_POST ['page_create'] ))
				{
					$name = $_POST ['page_name'];
					$content = $_POST ['page_content'];
					$roles = $_POST ['page_roles'];
					
					$this->create ( [ 
							'name' => $name,
							'content' => $content,
							'roles' => $roles 
					] );
					
					$uri = URIQueryController::get ();
					unset ( $uri->query ['action'] );
					
					System::setURLEx ( $uri->build () );
				}
				else
				{
					/*
					 * If no or unknown submit was passed, return to the Pages overview
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
				 * Display Form for page creation
				 * Editable fields: name,content,roles
				 */
				$HTMLTemplateParser = new HTMLTemplateParser ( __DIR__ . DIRECTORY_SEPARATOR . 'templates/createPage.tpl' );
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
			

			$HTMLTemplateParser_TABLE = new HTMLTemplateParser ( __DIR__ . DIRECTORY_SEPARATOR . 'templates/displayPages.tpl' );
			$HTMLTemplateParser_ROWS = new HTMLTemplateParser ( __DIR__ . DIRECTORY_SEPARATOR . 'templates/displayRows.tpl', true );
			
			if ( !isset($_GET['offset']))
			{
				$_GET['offset'] = 0;
			}
			
			$result = $this->getLimit((int)$_GET['offset'], 10);
			
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
