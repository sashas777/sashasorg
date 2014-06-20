<?php
class App_Model_DbTable_Comments extends Zend_Db_Table_Abstract
{
	protected $_name = 'comments';
	
	public function getComments($articleId) {
		
		$select = $this->select ()
		->setIntegrityCheck(false)
		->where ( 'item_id = ?', $articleId )
		->order ( 'id DESC' );
		$stmt = $select->query ();
		$result = $stmt->fetchAll();
		return $result;
	}
	
	public function getLastComment( ){
		
		$articleId=Zend_Registry::get('article_id');		 
		$select = $this->select()
		->setIntegrityCheck(false)
		->where ( 'item_id = ?', $articleId )
		->order ( 'id DESC' )
		->limit(1);
		 
		$stmt = $select->query();
		$result = $stmt->fetchObject();
		return $result;		
	}
	
	public function addcomment($userData){	
		parent::insert($userData);
		return true;
	}
	
	public function deleteComment($commentId){
		$where=$this->getAdapter()->quoteInto('id = ?',$commentId);
		parent::delete($where);
	}
	
	public function deleteCommentBYitem($itemId){
		$where=$this->getAdapter()->quoteInto('item_id = ?',$itemId);
		parent::delete($where);
	}
}