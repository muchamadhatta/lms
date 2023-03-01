<?php
class Admin_PesertanonasnController extends Zend_Controller_Action
{
	
	public function init()
	{ 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index'));
	}
	
	public function preDispatch()
	{
		$this->PesertanonasnService = new PesertanonasnService();
	}
	
	public function indexAction() 
	{	
		$this->view->rows = $this->PesertanonasnService->getAllData();
	}

	public function addAction() 
	{	
		if ( $this->getRequest()->isPost() )
		{
			$nama = $this->getRequest()->getParam('nama');
			$last_id = $this->PesertanonasnService->addData($nama);
			
		$this->_redirect('/admin/pesertanonasn/edit/id/'.$last_id);
		} else {
			$this->view->rows = $this->PesertanonasnService->getAllData();
		}
	}

	public function editAction() 
	{	
		$id = $this->getRequest()->getParam('id');

		if ( $this->getRequest()->isPost() )
		{
			$nama = $this->getRequest()->getParam('nama');
			
			$this->PesertanonasnService->editData($id, $nama);	
			
			$this->_redirect('/admin/pesertanonasn/index');
		} else {
			$this->view->row = $this->PesertanonasnService->getData($id);
			//$this->view->JenisRows = $this->JenisService->getAllData();
			//$this->view->KelompokRows = $this->KelompokService->getAllData();
		}
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		// $this->PesertanonasnService->deleteData($id);
		$this->PesertanonasnService->softDeleteData($id);

		$this->_redirect('/admin/pesertanonasn/index');
	}

}