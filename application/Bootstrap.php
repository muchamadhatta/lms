<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	private $_acl = null;
	private $_auth = null;
	
    protected function _initAutoload() {
		$modelLoader = Zend_Loader_Autoloader::getInstance();
		$modelLoader->registerNamespace('Dpr_');
		$modelLoader->setFallbackAutoloader(auto);

        $this->_auth = Zend_Auth::getInstance();
        
        $frontController = Zend_Controller_Front::getInstance();
		$frontController->throwExceptions(true);
        
        return $modelLoader;
    }

	protected function _initRoutesAndControllers() 
	{
		$frontController = Zend_Controller_Front::getInstance();
	}
	
	function _initViewHelpers() {
		Zend_Layout::startMvc();

		$view = Zend_Layout::getMvcInstance()->getView();
		$view->addHelperPath(LIBS_PATH . '/Dpr/View/Helper','Dpr_View_Helper');
		$view->doctype('XHTML1_STRICT');
		
		$acl = new Dpr_Acl();
		$aclHelper = new Dpr_Controller_Action_Helper_Acl(null, array('acl'=>$acl));
		Zend_Controller_Action_HelperBroker::addHelper($aclHelper);
		Zend_Controller_Action_HelperBroker::addPrefix('Dpr_Helper');
		Zend_Controller_Action_HelperBroker::addPath(LIBS_PATH . '/Dpr/Controller/Action/Helper', 'Dpr_Controller_Action_Helper');
	}

	public function _initDbRegistry()
    {
        $this->bootstrap('multidb');
        $multidb = $this->getPluginResource('multidb');
        Zend_Registry::set('db', $multidb->getDb('db_mooc'));
        Zend_Registry::set('db_diparlin', $multidb->getDb('db_diparlin'));
        //Zend_Registry::set('db_ppnpn', $multidb->getDb('db_ppnpn'));
    }
	
}

