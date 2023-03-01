<?php
class Admin_TipeArtikelController extends Zend_Controller_Action
{
	
	public function init()
	{ 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index', 'edit'));
	}
	
	public function preDispatch()
	{
		$this->TipeArtikelService = new TipeArtikelService();
	}
	
	public function indexAction() 
	{	
		$this->view->rows = $this->TipeArtikelService->getAllData();
	}

	public function addAction() 
	{	
		if ( $this->getRequest()->isPost() )
		{
			$tipe_artikel = $this->getRequest()->getParam('tipe_artikel');
			$konten = $this->getRequest()->getParam('konten');
			$id = $this->TipeArtikelService->addData($tipe_artikel, $konten);

			$this->_redirect('/admin/tipe-artikel/index');
		}
	}

	public function editAction() 
	{	
		$id = $this->getRequest()->getParam('id');

		if ( $this->getRequest()->isPost() )
		{
			$tipe_artikel = $this->getRequest()->getParam('tipe_artikel');
			$konten = $this->getRequest()->getParam('konten');
			$this->TipeArtikelService->editData($id, $tipe_artikel, $konten);		

			$this->_redirect('/admin/tipe-artikel/index');
		} else {
			$this->view->row = $this->TipeArtikelService->getData($id);
		}
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->TipeArtikelService->softDeleteData($id);

		$this->_redirect('/admin/tipe-artikel/index');
	}

}