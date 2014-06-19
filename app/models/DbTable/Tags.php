<?php
class App_Model_DbTable_Tags extends Zend_Db_Table_Abstract
{
	/** Table name */
	protected $_name    = 'tags';

	public function get_tags($limit)
	{
		$select = $this->select();	
		if ($limit>0){		 
			$select=$select->order('number DESC')->limit($limit);
		}
// 		print_r($select->__toString());
		$stmt = $select->query();	
		$result = $stmt->fetchAll();
		return $result;
	
	}
	
	public function get_max_min()
	{
		$select = $this->select()
		->from('tags', array('max'=>'MAX(number)', 'min'=>'MIN(number)','diff'=>'MAX(number) - MIN(number)' ))
		;		 
		$stmt = $select->query();
		$result = $stmt->fetchAll();
		return $result;	
	}
	
	public function get_tag_id($tag){
		$select = $this->select()->where ( 'tag = ?', $tag );
		$stmt = $select->query ();
		$result = $stmt->fetchObject();	
		if (isset($result->id)){
			
		  $return=$result->id;
		} else {
		 $return=null;
		}
		return $return;
	}
	
	public function add_tag($data){
		parent::insert($data);
	}
	
	public function get_tag_number_by_id($tag_id){
		$select=$this->select()->where ( 'id = ?', $tag_id );		
		$stmt = $select->query ();
		$result = $stmt->fetchObject();	
		return $result->number;
	}
	
	public function plus($tag_id){
		$where=$this->getAdapter()->quoteInto('id = ?',$tag_id);
		$data=array('number'=>new Zend_Db_Expr('number+1'));
		parent::update($data, $where);
	}
	
	
	public function minus($tag_id,$article_id){		
		$where=$this->getAdapter()->quoteInto('id = ?',$tag_id);
		$data=array('number'=>new Zend_Db_Expr('number-1'));
		parent::update($data, $where);
		//check if 0 		 
		$total=$this->get_tag_number_by_id($tag_id);
		if ($total==0) {			
			parent::delete($where);
		}
		
		$rel_base= new App_Model_DbTable_TagRelation ();
		$rel_id=$rel_base->is_exists($tag_id, $article_id);
		 
		 
		 
		if ($rel_id) {
			
		$where_rel=$rel_base->getAdapter()->quoteInto('relation_id = ?',$rel_id);
		$rel_base->delete($where_rel);
		}
 
	}
	
	public function tag_change($tag,$action,$article_id){	
		
		$tag_id=$this->get_tag_id($tag);		
		 		
		if ( (empty($tag_id)) && ($action=='plus') ){ // if new tag
			$url_helper=new App_Model_UrlHelper();
			$tag_data=array(
					'tag'=>$tag,
					'number'=> 0,
					'url'=>$url_helper->url($tag),
					);			
			$this->add_tag($tag_data);
			$tag_id=$this->get_tag_id($tag);
		}
		if ($action=='plus') {
		//plus one existing one
	    	$this->plus($tag_id);
	    	//add relation
	    	$rel_base= new App_Model_DbTable_TagRelation ();
	    	$rel_base->add_relation($tag_id, $article_id);
		}  
			
 
	}
	
	public function delete_by_article_id($article_id){
		$tag_rel=new App_Model_DbTable_TagRelation();
		$tag_ids=$tag_rel->get_tags_by_article_id($article_id);
		$tag_ids_array=explode(',', $tag_ids);
		
		foreach ($tag_ids_array as $tag_id) {
				$this->minus($tag_id,$article_id);
		}
			
	}
}