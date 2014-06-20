<?php

class IndexController extends Zend_Controller_Action
{
 
    public function init()
    {
        /* Initialize action controller here */
    }
 
public function indexAction()
	{
		$routes='';
		$tag = $this->_getParam('tag');
		$keywords="Alex Lukyanov Blog, Sashas, Magento, Magento Extensions, Magento development, Blog, News, Articles, New York, PHP";
		$descr='Official blog  of Alex Lukyanov (Sashas)';
		
		if ( ($tag!=='All') && (!empty($tag)) ) {
			$head=$tag;
			$keywords.=",".$tag;
			$db = new App_Model_Articles();
			$main = $db->getIndex($tag);
			$descr.=' | '.$tag;
			$route='tagpages';
			$routes=$tag;
		} else {
			$route='tagpages';
			$routes='All';
			$head='Sashas.org';			 
			$tableMain = new App_Model_Articles();
			$main = $tableMain->getIndex();			  			
		}
		//add routers
		define('routes',$routes);
		define('route',$route);
		
		$this->view->headMeta()->appendName('keywords', $keywords);
		$this->view->headMeta()->appendName('description', $descr);
		$this->view->main = $main;
		$this->view->homepage=1;
		$this->view->headTitle()->append($head);

	}
	



	public function pageAction()
	{
	
		$routes='';
		$tag = $this->_getParam('tag');
		$keywords="Alex Lukyanov Blog, Sashas, Magento, Magento Extensions, Magento development, Blog, News, Articles, New York, PHP";
		$descr='Official blog  of Alex Lukyanov (Sashas)';
		
		if ( ($tag!=='All') and (!empty($tag)) ) {
			$head=$tag;
			$keywords.=",".$tag;
	        $db = new App_Model_Articles();
			$main = $db->getIndex($tag);;
			$descr.=' | '.$tag;
			$route='tagpages';
			$routes=$tag;
		} else {
			
			$route='tagpages';
			$routes='All';
			$head="Page: ".$this->_getParam('page');
			$tableMain = new App_Model_Articles();
			$main = $tableMain->getIndex();		
		}

		$main->setCurrentPageNumber($this->_getParam('page'));
		 
		define('page',$this->_getParam('page'));
		//adding routes
		define('routes',$routes);
		define('route',$route);
		
		$this->view->main = $main;
		$this->view->headMeta()->appendName('keywords', $keywords);
		$this->view->headMeta()->appendName('description', $descr);
		$this->view->headTitle()->append($head);
		$this->view->homepage=1;
		$this->_request->setActionName('index');
	}

	
	public function articleAction()
	{	
		$url = $this->_getParam('articleId');		  
		$tableMain = new App_Model_Articles();
		$main = $tableMain->getArticle($url);	 
		if (empty($main)) {
			$this->_helper->FlashMessenger->setNamespace('messages')->addMessage('This Article is not exist anymore. Sorry.');
			$this->_helper->redirector->gotoRoute(array(), 'default');
		}
		$articleId=$main->id;
		Zend_Registry::set('article_id', $articleId);
		$helper = new Zend_View_Helper_Url();	
// 		$main[0]->text=str_replace('public'.DIRECTORY_SEPARATOR.'images',DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'images',$main[0]->text);		
		//Keywords
		$add_keywords=str_replace(' ',',',$main->title);
		$add_keywords=str_replace("'","",$add_keywords);
		$add_keywords=str_replace('"','',$add_keywords);
		$this->view->headMeta()->appendName('keywords', $add_keywords.'Alex Lukyanov Blog, Magento development, Sashas, Magento, Magento Extensions, Blog, News, Articles, New York, PHP');
		$this->view->headMeta()->appendName('description', $main->title);
 
		$this->view->headTitle()->append($main->title);
		
		/* process links */
		$main->text=str_replace("{{website_url}}",Zend_Controller_Front::getInstance()->getBaseUrl(), $main->text);
		$main->full_text=str_replace("{{website_url}}",Zend_Controller_Front::getInstance()->getBaseUrl(), $main->full_text);
		$this->view->main = $main;
	 		 
		// pager and comments
		$comm= new App_Model_Comments();
 		$coments = $comm->getComments($articleId);
 		$this->view->comments=$coments;
	}
	
	public function previewAction(){
		 
		$content = $this->_getParam('intro_text');
		$full_content = $this->_getParam('full_text');
		$title = $this->_getParam('title');
		$tags = $this->_getParam('tags');
		
		$main = new App_Model_Articles();
		$main->id=-1;
		$main->text=$content;
		$main->full_text=$full_content;	
		$main->title = $title;
		$main->tags =$tags;
		$main->tag_urls =$tags;
		$main->article_type='preview';
		$this->view->headTitle()->append($title);
		
		$this->view->main = $main;
		 
		$this->_helper->viewRenderer('article');
	}
	
	public function lastfmAction(){
		$as = new Zend_Service_Audioscrobbler();
		// Set the user whose profile information we want to retrieve
		$as->setUser('sashas777');
		$artists = $as->userGetTopArtists();
		 	
		$this->view->artists=$artists;
		$this->view->headTitle()->append('LastFM');
	}
	
	
	public function androidpostAction(){
		if ($this->_request->isPost()) {
			$title = $this->_getParam('title');
			$url =  $this->_getParam('url');
			$full_content =  $this->_getParam('content');
			$access='homepage';
			$tags=$this->_getParam('tags');
			if (empty($tags)) {
				$tags="Android, Photo";
			}
			$url_helper=new App_Model_UrlHelper();
			if (empty($url)) {
				$url=$url_helper->url($title);
			}
			$db = new App_Model_Articles();
			$article_id_check=$db->get_article_id($url);
			if (!empty($article_id_check)){
				 die('Not unique url');
			}
			/*generate content*/
			$content="";
			if(move_uploaded_file($_FILES["picture"]["tmp_name"] , "images/android/" . $_FILES["picture"]["name"] )){
				 $pic_name=$_FILES["picture"]["name"];
				 $img_helper=new App_Model_ImageHelper();
				 $img_helper->load("images/android/" .$pic_name);
				// $img_helper->resizeToWidth(565);
				 $img_helper->save("images/android/" .$pic_name);
				
			}else {
				die('File saving error');
			}
			
			$content='<div  class="col-lg-12"><img alt="" src="/images/android/'.$pic_name.'" ></div> ';
			/*generate content*/
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
			$tag = explode(", ", $tags);
			foreach ($tag as $value){
				$tagDb = new App_Model_Tags();
				$tagDbres=$tagDb->tag_change($value,'plus',$article_id); //add tag
			}
		}
		
		$this->_helper->layout->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ();
	}

}