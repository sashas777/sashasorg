<?php
class CommentsController extends Zend_Controller_Action {
	
	public function init() {
		$this->getResponse ()->setHeader ( "Cache-Control", "no-cache, no-store, max-age=0, " . "must-revalidate, post-check=0, pre-check=0" );
	}
	
	public function addcommentAction() {
		$articleId = $this->_getParam ( 'artid' );
		$comment = $this->_getParam ( 'comment' );
		$key1 = $this->_getParam ( 'key1' );
		$key2 = $this->_getParam ( 'key2' );
		$ip = $_SERVER ['REMOTE_ADDR'];
		
		// start comments
		if ($this->getRequest ()->isXmlHttpRequest ()) {
			// captcha
			$privatekey = "6LerpMgSAAAAAPq2TeQSg94hPT5OCgrHQHBuP5nh";
			$resp = recaptcha_check_answer ( $privatekey, $ip, $key1, $key2 );
			
			if (! $resp->is_valid) {
				$this->_helper->layout->disableLayout ();
				$this->_helper->viewRenderer->setNoRender ();
				
				$this->_response->appendBody ( Zend_Json_Encoder::encode ( array ('result' => 'captcha' ) ) );
				return;
			} else {
				// capthca true
				$this->_helper->layout->disableLayout ();
				$this->_helper->viewRenderer->setNoRender ();					
			    $user_id = 0; // anonymous								
				// function add comment
				$userData = array ('author_id' => $user_id, 'text' => $comment, 'ip' => $ip, 'date' => date ( 'd.m.Y H:m:s' ), 'item_id' => $articleId );
				$add_com = new App_Model_Comments();
				$add_com->addComment( $userData);								
				$this->_response->appendBody ( Zend_Json_Encoder::encode ( array ('result' => 'success' ) ) );
				return;
			
			}
			// end captcha		
		} else {
			$this->_helper->layout->disableLayout ();
			$this->_helper->viewRenderer->setNoRender ();
			$this->_response->appendBody ( Zend_Json_Encoder::encode ( array ('result' => 'error' ) ) );
			return;
		}
		$this->view->result = $result;
		if (! $this->getRequest ()->isXmlHttpRequest ()) {
			$this->_redirect ( '/' );
		}	
	}
	
	public function deleteAction(){
		$articleId = $this->_getParam ( 'artid' );
		$comment = $this->_getParam ( 'comId' );
		 
		if ($this->getRequest()->isXmlHttpRequest ()) {
			$this->_helper->layout->disableLayout ();
			$this->_helper->viewRenderer->setNoRender ();
			
			$comm_model = new App_Model_Comments();
			$comm_model->deletecomment($comment,$articleId);
			$this->_response->appendBody ( Zend_Json_Encoder::encode ( array ('result' => 'success' ) ) );
		} else {
				$this->_redirect ( '/' );
		}
		 
		
	}
	
}
