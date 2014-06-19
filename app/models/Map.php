<?php
class App_Model_Map {
	
	
	public function getAll() {
		$db = new App_Model_DbTable_Map();
		$result = $db->getAll ();
		return $result;	
	}

}