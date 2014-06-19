<?php
class App_Model_DbTable_Map extends Zend_Db_Table_Abstract {
	/**
	 * Table name
	 */
	protected $_name = 'map';
	
	public function getAll() 

	{		
		$select = $this->select()
		->order ( 'id ASC' );
		
		$stmt = $select->query();
		$result = $stmt->fetchAll ();
		
		return $result;
	}
}