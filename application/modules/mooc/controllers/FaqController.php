<?php
class Admin_FaqController extends Zend_Controller_Action
{
	
	public function init()
	{ 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index', 'edit'));
	}
	
	public function preDispatch()
	{
		$this->FaqService = new FaqService();
	}
	
	public function indexAction() 
	{	
		$this->view->rows = $this->FaqService->getAllData();
	}

	public function addAction() 
	{	
		if ( $this->getRequest()->isPost() )
		{
			$pertanyaan = $this->getRequest()->getParam('pertanyaan');
			$jawaban = $this->getRequest()->getParam('jawaban');
			$id = $this->FaqService->addData($pertanyaan, $jawaban);

			$this->_redirect('/admin/faq/index');
		}
	}

	public function editAction() 
	{	
		$id = $this->getRequest()->getParam('id');

		if ( $this->getRequest()->isPost() )
		{
			$pertanyaan = $this->getRequest()->getParam('pertanyaan');
			$jawaban = $this->getRequest()->getParam('jawaban');
			$this->FaqService->editData($id, $pertanyaan, $jawaban);		

			$this->_redirect('/admin/faq/index');
		} else {
			$this->view->row = $this->FaqService->getData($id);
		}
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->FaqService->softDeleteData($id);

		$this->_redirect('/admin/faq/index');
	}

}