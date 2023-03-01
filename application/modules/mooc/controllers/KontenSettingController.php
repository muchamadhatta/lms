<?php
class Admin_KontenSettingController extends Zend_Controller_Action
{
	
	public function init()
	{ 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index', 'edit'));
	}
	
	public function preDispatch()
	{
		$this->KontenSettingService = new KontenSettingService();
	}
	
	public function indexAction() 
	{	
		$this->view->rows = $this->KontenSettingService->getAllData();
	}

	public function addAction() 
	{	
		if ( $this->getRequest()->isPost() )
		{
			$nama = $this->getRequest()->getParam('nama');
			$nilai = $this->getRequest()->getParam('nilai');
			$id = $this->KontenSettingService->addData($nama, $nilai);

			$this->_redirect('/admin/konten-setting/index');
		}
	}

	public function editAction() 
	{	
		$id = $this->getRequest()->getParam('id');

		if ( $this->getRequest()->isPost() )
		{
			$nama = $this->getRequest()->getParam('nama');
			$nilai = $this->getRequest()->getParam('nilai');
			$this->KontenSettingService->editData($id, $nama, $nilai);		

			$this->_redirect('/admin/konten-setting/index');
		} else {
			$this->view->row = $this->KontenSettingService->getData($id);
		}
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->KontenSettingService->softDeleteData($id);

		$this->_redirect('/admin/konten-setting/index');
	}

}