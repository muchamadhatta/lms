<?php
class Admin_SubtipeArtikelController extends Zend_Controller_Action
{
	
	public function init()
	{ 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index', 'edit'));
	}
	
	public function preDispatch()
	{
		$this->SubtipeArtikelService = new SubtipeArtikelService();
		$this->TipeArtikelService = new TipeArtikelService();
	}
	
	public function indexAction() 
	{	
		$this->view->rows = $this->SubtipeArtikelService->getAllData();
	}

	public function addAction() 
	{	
		if ( $this->getRequest()->isPost() )
		{
			$subtipe_artikel = $this->getRequest()->getParam('subtipe_artikel');
			$id_tipe_artikel = $this->getRequest()->getParam('id_tipe_artikel');
			$konten = $this->getRequest()->getParam('konten');
			$id = $this->SubtipeArtikelService->addData($subtipe_artikel, $id_tipe_artikel, $konten);

			$this->_redirect('/admin/subtipe-artikel/index');
		} else {
			$this->view->TipeArtikelRows = $this->TipeArtikelService->getAllData();
		}
	}

	public function editAction() 
	{	
		$id = $this->getRequest()->getParam('id');

		if ( $this->getRequest()->isPost() )
		{
			$subtipe_artikel = $this->getRequest()->getParam('subtipe_artikel');
			$id_tipe_artikel = $this->getRequest()->getParam('id_tipe_artikel');
			$konten = $this->getRequest()->getParam('konten');
			$this->SubtipeArtikelService->editData($id, $subtipe_artikel, $id_tipe_artikel, $konten);		

			$this->_redirect('/admin/subtipe-artikel/index');
		} else {
			$this->view->row = $this->SubtipeArtikelService->getData($id);
			$this->view->TipeArtikelRows = $this->TipeArtikelService->getAllData();
		}
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->SubtipeArtikelService->softDeleteData($id);

		$this->_redirect('/admin/subtipe-artikel/index');
	}

}