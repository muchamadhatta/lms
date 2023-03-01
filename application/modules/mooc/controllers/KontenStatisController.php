<?php
class Admin_KontenStatisController extends Zend_Controller_Action
{
	
	public function init()
	{ 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index', 'edit'));
	}
	
	public function preDispatch()
	{
		$this->KontenStatisService = new KontenStatisService();
	}
	
	public function indexAction() 
	{	
		$this->view->rows = $this->KontenStatisService->getAllData();
	}

	public function addAction() 
	{	
		if ( $this->getRequest()->isPost() )
		{
			$judul = $this->getRequest()->getParam('judul');
			$konten = $this->getRequest()->getParam('konten');
			$id = $this->KontenStatisService->addData($judul, $konten);

			$this->_redirect('/admin/konten-statis/index');
		}
	}

	public function editAction() 
	{	
		$id = $this->getRequest()->getParam('id');

		if ( $this->getRequest()->isPost() )
		{
			$judul = $this->getRequest()->getParam('judul');
			$konten = $this->getRequest()->getParam('konten');
			$this->KontenStatisService->editData($id, $judul, $konten);		

			$this->_redirect('/admin/konten-statis/index');
		} else {
			$this->view->row = $this->KontenStatisService->getData($id);
		}
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->KontenStatisService->softDeleteData($id);

		$this->_redirect('/admin/konten-statis/index');
	}

}