<?php
class App_Model_DbTable_TagRelation extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name    = 'tag_relation';
	
	public function is_exists($tag_id,$article_id) {
	 
		$select = $this->select()->where ( 'tag_id = ?', $tag_id )
								 ->where ( 'article_id = ?', $article_id );
		 
		$stmt = $select->query ();
		$result = $stmt->fetchObject();
 
		return $result->relation_id;

	}
		
	public function add_relation($tag_id,$article_id) {
		// check if we have relation 
		$exist=$this->is_exists($tag_id, $article_id);
		if ($exist==0) {						 
			$data=array('tag_id'=>$tag_id,'article_id'=>$article_id);		
				parent::insert($data);		
		}			
	} 
	
	public function get_tags_by_article_id($article_id){
		$select = $this->select()
		->from(array('tag_rel' => 'tag_relation'),
				array('tags'=>'GROUP_CONCAT(tag_id)'))
		->where ( 'article_id = ?', $article_id );			
		$stmt = $select->query ();
		$result = $stmt->fetchObject();
			
		 return $result->tags;
	}
}