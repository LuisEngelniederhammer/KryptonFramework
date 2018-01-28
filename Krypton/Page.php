<?php

namespace Krypton;

require_once __DIR__ . DIRECTORY_SEPARATOR. 'Database.php';
require_once __DIR__ . DIRECTORY_SEPARATOR. 'System.php';


class Page
{
	private $pageID;
	private $db;

	public function __construct()
	{
		$this->db = new Database ();
		if (isset ( $_GET ['pageid'] ) && $this->exists ( $_GET ['pageid'] ))
		{
			$this->pageID = ( int ) $_GET ['pageid'];
		}
		else
		{
			$this->pageID = \Krypton\System::getDefaultPage ();
		}
		
		$result = $this->db->query ( 'SELECT * FROM pages WHERE id="' . $this->pageID . '"' );
		$arr = $result->fetchArray ();
		

		echo '<title>' . $arr ['name'] . '</title>';
		
		$roles = json_decode ( $arr ['roles'], true );
		
		if (in_array ( '*', $roles ) || (isset ( $_SESSION ['Client.role'] ) && @in_array ( $_SESSION ['Client.role'], $roles )))
		{
			preg_match_all ( '/{W:\s(.+)*}/', $arr ['content'], $matches );
			foreach ( $matches [1] as $value )
			{
				if (! file_exists ( 'Krypton/Apps/' . $value . '.php' ))
				{
					echo '<div class="toast toast-error col-12">
                          ' . $value . ':#ERROR:App not found.
                          </div>';
				}
				else
				{
					
					require_once 'Krypton/Apps/' . $value . '.php';
					$app_class = '\\Krypton\\Apps\\' . $value;
					$arr ['content'] = str_replace ( '{W: ' . $value . '}', $app_class::run (), $arr ['content'] );
				}
			}
			
			echo $arr ['content'];
		}
		else
		{
			echo '
          <div class="toast toast-error">
            <button class="btn btn-clear float-right"></button>
            no permission
          </div>
          ';
		}
	}

	private function exists($id): bool
	{
		// @FIXME always returns true
		$result = $this->db->query ( 'SELECT * FROM pages WHERE id="' . ( int ) $id . '"' );
		return ( bool ) $result->fetchArray ();
	}

}
?>