<?php
class LoginController extends Zend_Controller_Action {
	
	public function init()
	{		
		$this->_helper->_acl->allow();
	}
	
	public function preDispatch() 
	{
	}
	
	public function indexAction()
	{		
		$this->_helper->getHelper('layout')->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
		
		$ivenc = $_COOKIE["mehong1"];
		$encrypted_strenc = $_COOKIE["mehong2"];
		$appname = "belajar";
		
		if (isset($ivenc) && isset($encrypted_strenc))
		{
			$iv = base64_decode($ivenc);
			$strenc = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, 'in1,k0nci g3rbang kenikm4tan! *5', base64_decode($encrypted_strenc), MCRYPT_MODE_CFB, $iv);	
			//$obj = unserialize($strenc);
			$obj = json_decode($strenc);
			$obj->peran = (array)$obj->peran;
			
			if(isset($obj->pengguna)) 
			{
				if ($obj->peran[$appname] == "") {
					$provider_auth_uri = 'http://portal.dpr.go.id/login?service='.$appname.'&t='.time();
					$this->_redirect($provider_auth_uri);
				}
				
				$data = new stdClass;
				$data->id = $obj->id;
				$data->pengguna = $obj->pengguna;
				$data->nama = $obj->nama;
				$data->nip = $obj->nip;
				$data->departemen = $obj->departemen;
				$data->peran = $obj->peran[$appname];

				$auth = Zend_Auth::getInstance();
				$auth->setStorage(new Zend_Auth_Storage_Session());
				$auth->getStorage()->write($data);

				$this->_redirect('/admin/index');
			}
		} else {
			$provider_auth_uri = 'http://portal.dpr.go.id/login?service='.$appname.'&t='.time();
			$this->_redirect($provider_auth_uri);
		}
	}

	public function loginAction()
	{
    }
	 
	public function logoutAction() 
	{
		Zend_Auth::getInstance()->clearIdentity();

		setcookie('mehong1', '', time() - 28800, '/', 'dpr.go.id');
		setcookie('mehong2', '', time() - 28800, '/', 'dpr.go.id');

		unset($_COOKIE["mehong1"]); 
		unset($_COOKIE["mehong2"]); 
		$this->_redirect('/');
	}
	
}
	