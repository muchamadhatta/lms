<?php
class Admin_BatchController extends Zend_Controller_Action
{

	public function init()
	{
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		// $this->_helper->_acl->allow('user', array('index', 'edit'));
	}

	public function preDispatch()
	{
		$this->BatchService = new BatchService();
		$this->KelasService = new KelasService();
		$this->PengajarService = new PengajarService();
	}

	public function indexAction()
	{
		$rows = $this->BatchService->getAllData();
		$this->view->rows = $rows;
	}

	public function addAction()
	{
		$this->view->rowsKelas2 = $this->KelasService->getAllData();
		if ($this->getRequest()->isPost()) {
			$judul_batch = $this->getRequest()->getParam('judul_batch');
			$deskripsi = $this->getRequest()->getParam('deskripsi');
			$id_kelas = $this->getRequest()->getParam('id_kelas');
			$tgl_awal = $this->_helper->CDate($this->getRequest()->getParam('tgl_awal'));
			$tgl_akhir = $this->_helper->CDate($this->getRequest()->getParam('tgl_akhir'));
			$id_pengajar = $this->getRequest()->getParam('id_pengajar');

			$jenis_batch = $this->getRequest()->getParam('jenis_batch');

			// if($jenis_batch == 1 ){

			// }
			// else{
			// 	$this->BatchService->addNonFreeData($jenis_batch, $id_kelas, $id_pengajar, $judul_batch, $deskripsi);				
			// }

			$id = $this->BatchService->addData($id_kelas, $id_pengajar, $judul_batch, $deskripsi, $tgl_awal, $tgl_akhir);

			$this->_redirect('/admin/batch/index');
		}
	}

	public function editAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->view->rowsKelas2 = $this->KelasService->getAllData();
		if ($this->getRequest()->isPost()) {
			$judul_batch = $this->getRequest()->getParam('judul_batch');
			$deskripsi = $this->getRequest()->getParam('deskripsi');
			$id_kelas = $this->getRequest()->getParam('id_kelas');
			$tgl_awal = $this->_helper->CDate($this->getRequest()->getParam('tgl_awal'));
			$tgl_akhir = $this->_helper->CDate($this->getRequest()->getParam('tgl_akhir'));
			$id_pengajar = $this->getRequest()->getParam('id_pengajar');
			
			$this->BatchService->editData($id, $id_kelas, $id_pengajar, $judul_batch, $deskripsi, $tgl_awal, $tgl_akhir);

			$this->_redirect('/admin/batch/index');
		}
		$row = $this->BatchService->getData($id);
		$this->view->row = $row;
		$this->view->nama_kelas = $this->KelasService->getData($row->id_kelas)->nama_kelas;
		$this->view->nama_pengajar = $this->PengajarService->getData($row->id_pengajar)->nama_pengajar;
	}

	public function deleteAction()
	{
	}
	public function searchKelasAction()
	{
		$this->_helper->getHelper('layout')->disableLayout();
		$this->view->rows = $this->KelasService->getAllData();
	}

	public function searchPengajarAction()
	{
		$this->_helper->getHelper('layout')->disableLayout();
		$this->view->rows = $this->PengajarService->getAllData();
	}

	public function searchPesertaAction()
	{
		$this->_helper->getHelper('layout')->disableLayout();
		$this->view->rows = $this->KelasService->getAllData();
	}
}
