<?php
class UserController extends Zend_Controller_Action {
	
	public function loginAction() {
		if ($this->getRequest ()->isXmlHttpRequest ()) {
			$this->_helper->layout->disableLayout ();
			$this->_helper->viewRenderer->setNoRender ();
			
			$password = sha1 ( $this->_getParam ( 'password' ) . 'jdh37dgvs' );
			$email = $this->_getParam ( 'login' );
			$res = $this->auth ( $password, $email );
			
			$this->_response->appendBody ( Zend_Json_Encoder::encode ( array ('result' => $res ) ) );
			return;
		} 
	}
	
	public function auth($password, $email) {
		
		$authAdapter = new Zend_Auth_Adapter_DbTable ( );
		
		$authAdapter->setTableName ( 'users' )->setIdentityColumn ( 'email' )->setCredentialColumn ( 'password' );
		
		$authAdapter->setIdentity ( $email )->setCredential ( $password );
		
		$result = $authAdapter->authenticate ();
		
		$user_info = $authAdapter->getResultRowObject ();
		
		$code = $result->getCode ();
		
		switch ($code) {
			default :
			case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND :
				$result = 'email';
				break;
			
			case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID :
				$result = 'password';
				break;
			
			case Zend_Auth_Result::SUCCESS :
				Zend_Auth::getInstance ()->getStorage ()->write ( $authAdapter->getResultRowObject ( null, array ('password' ) ) );
				$result = 'success';
				break;
		}
		return $result;
	}
	
	public function logoutAction() {	 
		Zend_Auth::getInstance()->clearIdentity();
		$this->_helper->redirector->gotoRoute(array(), 'default');
	}

}