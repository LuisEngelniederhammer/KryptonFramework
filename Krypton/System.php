<?php

namespace Krypton;

require_once 'Database.php';

use Krypton\Database;

class System
{

	public static function setURL(int $pageID, int $seconds = 0, string $query = "")
	{
		echo "<meta http-equiv=\"refresh\" content=\"$seconds; URL=/index.php?pageid={$pageID}&{$query}\">";
	}

	public static function setURLEx(string $url, int $seconds = 0)
	{
		echo "<meta http-equiv=\"refresh\" content=\"$seconds; URL={$url}\">";
	}

	public static function getDefaultPage()
	{
		$db = new Database ();
		$result = $db->query ( 'SELECT value FROM system WHERE key="default_page"' );
		return $result->fetchArray () [0];
	}

}
?>