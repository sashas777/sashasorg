<?php
class AdminController extends Zend_Controller_Action {
	
	public function init() {
		if (!Zend_Auth::getInstance()->getIdentity()) {
// 			$this->_helper->FlashMessenger->setNamespace('messages')->addMessage('Sorry, please Login to site');
			$this->_helper->redirector->gotoRoute(array(), 'default');
		}
	}
	public function indexAction(){
	
		$this->view->headTitle()->append('Admin Panel');
	}
	
	public function addarticleAction(){
		$this->view->headTitle()->append('Add New Article');
		$article_id=$this->_getParam('articleId');
	 
		if (!empty($article_id)) { // if update
			
			$db = new App_Model_Articles();
			$article=$db->getArticle($article_id);		 
			$this->view->article = $article;
		}
	}
	
	public function addarticlepostAction() {
	
		if ($this->_request->isPost()) {			
			$title = $this->_getParam('title');
			$content =  $this->_getParam('preview_text');
			$full_content =  $this->_getParam('full_text');
			$tags =  $this->_getParam('tags');
			$url =  $this->_getParam('url');
			$access= $this->_getParam('access');
			if (empty($access)){
				$access='homepage';
			} else {
				$access=implode(',', $access);
			}
			 
			
			$url_helper=new App_Model_UrlHelper();
			$update_article_id =  $this->_getParam('article_id');
		 
			if (empty($title)){
				$this->_helper->FlashMessenger->setNamespace('messages')->addMessage('Please add Title');
				$this->_helper->redirector->gotoRoute(array(), 'adm_add');
			}
			
			//add to articles					 
			$db = new App_Model_Articles();		
			if (empty($update_article_id)) {
				//check url
			
				if (empty($url)) {
					$url=$url_helper->url($title);
				}
				
				$article_id_check=$db->get_article_id($url);
				if (!empty($article_id_check)){
					$this->_helper->FlashMessenger->setNamespace('messages')->addMessage('Please add Uniq Url');
					$this->_helper->redirector->gotoRoute(array(), 'adm_add');								
				}
				
				// post to DB articles
				// then check DB tags and post tags or add
				$data = array('author_id'=> 15, //admin
						'title'=> $title,
						'text'=> $content,
						'full_text'=>$full_content,
						'date'=> date('d.m.Y'),
						'article_type'=>$access,
						'url'=> $url
				);
				 
			$db->addArticle($data); // enable check if it new 
			$article_id=$db->get_article_id($data['url']);
			// check tags
		 
			$tag = explode(", ", $tags);
			foreach ($tag as $value){		
				$tagDb = new App_Model_Tags();				 
				$tagDbres=$tagDb->tag_change($value,'plus',$article_id); //add tag 						
			}								
		
			/*POSTING TO TWITTER*/
// 				$token = 'p8gd7ho3LK7c3wEU3xEPrzhyJR4xRg14NTbKcIEcQ';		
// 				$key='	kKBZFHONfFGm2fmwR7gkA';		
// 				$twitter = new Zend_Service_Twitter(array(
// 						'username' => 'sashas777',
// 						'accessToken' => $token
// 				));			
// 				$response = $twitter->account->verifyCredentials();
// 				$result=$twitter->status->update($title.' (http://sashas.org)');
			/*END TWITTER*/
			$article_id=$db->get_article_id($data['url']);
			$this->_helper->redirector->gotoRoute(array('articleId'=>$article_id), 'articles');
			} else {	
				
				// DO update
				$data = array(
						'title'=> $title,
						'text'=> $content,
						'full_text'=>$full_content,												
				);				 				
				$db->update_article($update_article_id,$data);		
				$this->_helper->redirector->gotoRoute(array('articleId'=>$update_article_id), 'articles');				 
				// check tags for new ones
			}
			
		} else {
			$this->_helper->redirector->gotoRoute(array(), 'default');
		}					  	
	}
	
	public function deletarticleajaxAction() {
		if ($this->getRequest ()->isXmlHttpRequest ()) {
			$articleId = $this->_getParam ( 'artid' );
			$db = new App_Model_Articles();
			$db->delete_article($articleId);
			$comment_model=new App_Model_Comments();
			$comment_model->deletecommentByItemId($articleId);
			$tags=new App_Model_Tags();
			$tags->delete_by_article_id($articleId);	
			$this->_helper->layout->disableLayout ();
			$this->_helper->viewRenderer->setNoRender ();
			$this->_response->appendBody ( Zend_Json_Encoder::encode ( array ('result' => 'success' ) ) );
		} else {
			$this->_redirect ( '/' );
		}
	}
	
}