<?php

namespace Krypton;


class Database extends \SQLite3
{

	public function __construct()
	{
		$this->open ( realpath ( dirname ( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'database.db', SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, '' );
		$this->exec ( 'PRAGMA journal_mode = wal;' );
	}

}
?>
