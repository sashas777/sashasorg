<?php
class App_Model_DbTable_Articles extends Zend_Db_Table_Abstract {
	/**
	 * Table name
	 */
	protected $_name = 'articles';
	
	public function getArticle($url) {
		$select = $this->select ()
		->setIntegrityCheck(false)
		->from ( array('a'=>'articles'), array ('a.*' ) )
		->joinInner ( array('r'=>'tag_relation'), 'r.article_id = a.id', '' )
		->joinInner ( array('t'=>'tags'), 'r.tag_id = t.id' ,array('tag_urls' => 'GROUP_CONCAT(t.url)','tags'=>'GROUP_CONCAT(t.tag)' ))
		->where ( 'a.url = ?', $url )
		->group ( 'a.id' );	
		$stmt = $select->query ();
		$result = $stmt->fetchObject();
		return $result;	
	}
	
	public function get_article_id($url) {
		$select = $this->select ()
		->where ( 'url = ?', $url );
		$stmt = $select->query ();
		$result = $stmt->fetchObject();
		return $result;
	}
	
	public function addComment($articleId,$delete=0) {	 
		$where=$this->getAdapter()->quoteInto('id = ?',$articleId);
		if ($delete==0){
			$data=array('comments'=>new Zend_Db_Expr('comments+1'));
		} else {
			$data=array('comments'=>new Zend_Db_Expr('comments-1'));
		}
		 $this->update($data, $where);
	}
	
	public function addArticle($data){
		parent::insert($data);
	}
	
	public function update_article($ArticleId,$data){		 
		$where=$this->getAdapter()->quoteInto('id = ?',$ArticleId);
		parent::update($data, $where);
	}
	
	public function delete_article($art_id){
		$where=$this->getAdapter()->quoteInto('id = ?',$art_id);
		parent::delete($where);		
	}
}