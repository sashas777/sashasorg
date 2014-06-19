<?php

class App_Model_Tags {
	
	// return all tags
	public function get_tags($limit=0) {
		$db = new App_Model_DbTable_Tags ();
		$result = $db->get_tags ($limit);
		return $result;
	}
	
	public function get_max_min() {
		$db = new App_Model_DbTable_Tags ();
		$result = $db->get_max_min ();
		return $result;
	}
	public function tag_change($tag,$action,$article_id) {
		$db = new App_Model_DbTable_Tags ();
		$db->tag_change($tag,$action,$article_id);
		 
	}
	
	public function delete_by_article_id($article_id){
		$db = new App_Model_DbTable_Tags ();
		$db->delete_by_article_id($article_id);
	}

}