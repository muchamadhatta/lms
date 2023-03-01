<?php
class ErrorController extends Zend_Controller_Action
{
	
  public function errorAction()
  {
  	$this->_helper->_acl->allow();
  	$this->_helper->getHelper('layout')->disableLayout();
  	$errors = $this->_getParam('error_handler');
  	switch ($errors->type) {
			case 'PageNotFoundException':
			case 'NotAuthorizedException':
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				$this->getResponse()->setHttpResponseCode(404);
				$this->view->message = 'The page could not be found';
				break;
			default:
			$this->getResponse()->setHttpResponseCode(500);
			$this->view->message = 'An application error has occurred';
				break;
    }
  }

}