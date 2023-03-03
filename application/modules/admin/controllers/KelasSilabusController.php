<?php
class Admin_KelasSilabusController extends Zend_Controller_Action {

	public function init() {
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		// $this->_helper->_acl->allow('user', array('index', 'edit'));
	}

	public function preDispatch() {
		$this->KelasService = new KelasService();
		$this->KelasSilabusService = new KelasSilabusService();
	}

	public function indexAction() {
		$kelas = $this->KelasService->getAllData();
		$kelasSilabus = $this->KelasSilabusService->getAllData();
		$this->view->kelas = $kelas;
		$this->view->kelasSilabus = $kelasSilabus;
	}

	public function addAction() {
		if ($this->getRequest()->isPost()) {
			$nama_silabus = $this->getRequest()->getParam('nama_silabus');
			$id_kelas = $this->getRequest()->getParam('id_kelas');
		
			$id = $this->KelasSilabusService->addData($nama_silabus, $id_kelas);
			$this->_redirect('/admin/kelas-silabus/edit/id/'.$id);
		} else {
			$this->view->rows = $this->KelasSilabusService->getAllData();
		}
	}
	
	public function editAction() {
		$id = $this->getRequest()->getParam('id');
		if ($this->getRequest()->isPost()) {
			$nama_silabus = $this->getRequest()->getParam('nama_silabus');
			$id_kelas = $this->getRequest()->getParam('id_kelas');
			
			$this->KelasSilabusService->editData($id, $nama_silabus, $id_kelas);
			$this->_redirect('/admin/kelas-silabus/index');
		}
		$row = $this->KelasSilabusService->getData($id);
		$this->view->row = $row;
		$this->view->nama_kelas = $this->KelasService->getData($row->id_kelas)->nama_kelas;
	}

	public function deleteAction() {
		$id = $this->getRequest()->getParam('id');
		$this->KelasSilabusService->deleteData($id);
		//  $this->KelasSilabusService->softDeleteData($id);

		$this->_redirect('/admin/kelas-silabus/index');
	}
}
