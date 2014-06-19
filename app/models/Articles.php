<?php
class App_Model_Articles {
 
	public function GetIndex($tag=0, $type='homepage', $limit="5") { //index pages
		
		$db = new App_Model_DbTable_Articles ();
		
		$select = $db->select ()
		->setIntegrityCheck(false)
		->from ( array('a'=>'articles'), array ('a.*' ) )
		->joinInner ( array('r'=>'tag_relation'), 'r.article_id = a.id', '' )
		->joinInner ( array('t'=>'tags'), 'r.tag_id = t.id' ,array('tag_urls' => 'GROUP_CONCAT(t.url)','tags'=>'GROUP_CONCAT(t.tag)' ))
		->where ( 'a.article_type LIKE "%'.$type.'%"' )
		->group ( 'a.id' )
		->order ( 'a.id DESC' );
		if($tag) {
			$select=$select->where("t.url = '".$tag."'");
		}
// 		print_r($select->__toString());
  
		$adapter = new Zend_Paginator_Adapter_DbSelect ( $select );
	
		$paginator = new Zend_Paginator ( $adapter );
		$paginator->setCurrentPageNumber ( 1 )->setItemCountPerPage ( $limit )->setPageRange ( 10 );
		$paginator->setDefaultScrollingStyle ( 'Sliding' );
		
		return $paginator;
	}
	
	public function addArticle($data){
		$db = new App_Model_DbTable_Articles ();
		$result = $db->addArticle($data);
	}
	public function get_article_id($url) {
		$db = new App_Model_DbTable_Articles ();
		$result = $db->get_article_id($url);
		if (isset( $result->id)){
			$res= $result->id;
		} else {
			$res="";
		}
		return $res;		
	}
	public function getArticle($url) { //article page
		$db = new App_Model_DbTable_Articles ();
		$result = $db->getArticle($url);
		return $result;
	}
	
    public function addComment($articleId,$delete=0){
    	$db = new App_Model_DbTable_Articles ();
    	$db->addComment($articleId,$delete);    	       
    }
    
    public function update_article($articleId,$data){
    	$db = new App_Model_DbTable_Articles ();
    	$db->update_article($articleId,$data);
    }
    
    public function delete_article($art_id) {
    	$db = new App_Model_DbTable_Articles ();
    	$db->delete_article($art_id);    
    		
    }       
    
}