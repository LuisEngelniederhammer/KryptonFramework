<?php

namespace Krypton\Apps\AdminDashboard;

require_once 'Krypton/Database.php';

use Krypton\Database;


class Controller
{
	protected $db;
	private $table;

	public function __construct(string $table)
	{
		$this->db = new Database ();
		$this->table = $table;
	}

	
	/**
	 * use Format [entryname => value]
	 *
	 * @param array $fields        	
	 */
	protected function create(array $fields) // :void
	{
		$_queryFields = '';
		$_queryBinds = '';
		foreach ( $fields as $field => $value )
		{
			$_queryFields .= $field . ',';
			$_queryBinds .= ':' . $field . ',';
		}
		$_queryFields = rtrim ( $_queryFields, ',' );
		$_queryBinds = rtrim ( $_queryBinds, ',' );
		
		$query = $this->db->prepare ( 'INSERT INTO ' . $this->table . ' (' . $_queryFields . ') VALUES (' . $_queryBinds . ')' );
		
		foreach ( $fields as $field => $value )
		{
			$query->bindValue ( ':' . $field, $value );
		}
		
		$query->execute ();
	}

	protected function delete(int $id)
	{
		$query = $this->db->prepare ( 'DELETE FROM ' . $this->table . ' WHERE id=:id' );
		$query->bindValue ( ':id', $id );
		$query->execute ();
	}

	protected function get(int $id)
	{
		$query = $this->db->prepare ( 'SELECT * FROM ' . $this->table . ' WHERE id=:id' );
		$query->bindValue ( ':id', $id );
		$result = $query->execute ();
		return $result->fetchArray ( SQLITE3_ASSOC );
	}

	protected function update(int $id, array $fields)
	{
		$_queryBinds = '';
		foreach ( $fields as $field => $value )
		{
			$_queryBinds .= $field . '=:' . $field . ',';
		}
		$_queryBinds = rtrim ( $_queryBinds, ',' );
		

		$query = $this->db->prepare ( 'UPDATE ' . $this->table . ' SET ' . $_queryBinds . ' WHERE id=:id' );
		
		foreach ( $fields as $field => $value )
		{
			 $query->bindValue ( ':' . $field, $value );

		}
		
		$query->bindValue ( ':id', $id);
		$query->execute ();

	}

	protected function getLimit(int $start, int $limit): array
	{
		$query = $this->db->prepare ( 'SELECT * FROM ' . $this->table . ' LIMIT :limit, :offset' );
		$query->bindValue(':limit', $start);
		$query->bindValue(':offset', $limit);
		$result = $query->execute ();
		$rows = [ ];
		
		while ( $row = $result->fetchArray ( SQLITE3_ASSOC ) )
		{
			$rows [] = $row;
		}
		return $rows;
	}

}