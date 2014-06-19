<?php
class TagController extends Zend_Controller_Action
{

	public function tagleftAction(){
		$limit=60;
		$tbl_tags = new App_Model_Tags();
		$tag = $tbl_tags->get_tags($limit);
		$max_min=$tbl_tags->get_max_min();
		$this->view->alltags=0;
		$this->view->tag = $tag;
		$this->view->max_min = $max_min;
		$this->view->headTitle()->append('Sashas.org | Теги (Tags) |');

	}
	public function alltagsAction(){
		$tbl_tags = new App_Model_Tags();
		$tag = $tbl_tags->get_tags();
		$max_min=$tbl_tags->get_max_min();
		$this->view->tag = $tag;
		$this->view->max_min = $max_min;
		$this->view->alltags=1;
		$this->view->headTitle()->append('Sashas.org | All tags');
		$this->_request->setActionName('tagleft');

	}
	
}