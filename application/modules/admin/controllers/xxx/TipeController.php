<?php
class Admin_TipeController extends Zend_Controller_Action
{
	
	public function init()
	{ 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index'));
	}
	
	public function preDispatch()
	{
		$this->TipeService = new TipeService();
	}
	
	public function indexAction() 
	{	
		$this->view->rows = $this->TipeService->getAllData();
	}

	public function addAction() 
	{	
		if ( $this->getRequest()->isPost() )
		{
			$tipe = $this->getRequest()->getParam('tipe');
			$last_id = $this->TipeService->addData($tipe);

			$this->_redirect('/admin/tipe/edit/id/'.$last_id);
		} else {
			$this->view->rows = $this->TipeService->getAllData();
		}
	}

	public function editAction() 
	{	
		$id = $this->getRequest()->getParam('id');

		if ( $this->getRequest()->isPost() )
		{
			$tipe = $this->getRequest()->getParam('tipe');
			$this->TipeService->editData($id, $tipe);		

			$this->_redirect('/admin/tipe/index');
		} else {
			$this->view->row = $this->TipeService->getData($id);
			//$this->view->JenisRows = $this->JenisService->getAllData();
			//$this->view->KelompokRows = $this->KelompokService->getAllData();
		}
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		//$this->TipeService->deleteData($id);
		$this->TipeService->softDeleteData($id);

		$this->_redirect('/admin/tipe/index');
	}

}