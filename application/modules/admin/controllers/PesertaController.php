<?php
class Admin_PesertaController extends Zend_Controller_Action
{
	
	public function init()
	{ 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index'));
	}
	
	public function preDispatch()
	{
		$this->PesertaService = new PesertaService();
	}
	
	public function indexAction() 
	{	
		$this->view->rows = $this->PesertaService->getAllData();
	}

	public function addAction() 
	{	
		if ( $this->getRequest()->isPost() )
		{
			$nama = $this->getRequest()->getParam('nama');
			$last_id = $this->PesertaService->addData($nama);
			
		$this->_redirect('/admin/peserta/edit/id/'.$last_id);
		} else {
			$this->view->rows = $this->PesertaService->getAllData();
		}
	}

	public function editAction() 
	{	
		$id = $this->getRequest()->getParam('id');

		if ( $this->getRequest()->isPost() )
		{
			$nama = $this->getRequest()->getParam('nama');
			
			$this->PesertaService->editData($id, $nama);	
			
			$this->_redirect('/admin/peserta/index');
		} else {
			$this->view->row = $this->PesertaService->getData($id);
			//$this->view->JenisRows = $this->JenisService->getAllData();
			//$this->view->KelompokRows = $this->KelompokService->getAllData();
		}
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		// $this->PesertaService->deleteData($id);
		$this->PesertaService->softDeleteData($id);

		$this->_redirect('/admin/peserta/index');
	}

}