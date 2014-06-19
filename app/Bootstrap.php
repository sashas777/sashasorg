<?php 

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initDoctype()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('XHTML1_STRICT');
		// Set the initial title and separator:
		$view->headTitle('Alex Lukyanov')
		->setSeparator(' :: ');
		//router
		$router = $this->setRouter();
		$front = Zend_Controller_Front::getInstance();
		$front->setRouter($router);
		 
	}
	
	public function setRouter()
	{
		require('routes.php');
			
		if (!($router instanceof Zend_Controller_Router_Abstract)) {
			throw new Exception('Incorrect config file: routes');
		}	
		return $router;
	}
	
	 
}