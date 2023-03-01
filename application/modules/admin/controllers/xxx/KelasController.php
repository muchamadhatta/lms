<?php
class Admin_KelasController extends Zend_Controller_Action
{

	public function init()
	{
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		//$this->_helper->_acl->allow('user', array('index', 'edit'));
	}

	public function preDispatch()
	{
		$this->KelasService = new KelasService();
		$this->KelasSilabusService = new KelasSilabusService();
		$this->KelasSilabusMateriService = new KelasSilabusMateriService();
	}

	public function indexAction()
	{
		$this->view->rows = $this->KelasService->getAllData();
	}

	public function addAction()
	{
		if ($this->getRequest()->isPost()) {
			$nama_kelas = $this->getRequest()->getParam('nama_kelas');
			$deskripsi = $this->getRequest()->getParam('deskripsi');
			$tentang = $this->getRequest()->getParam('tentang');
			$jenis_kelas = $this->getRequest()->getParam('jenis_kelas');
			$file_name = $_FILES['file_name']['name'];
					$file_type = $_FILES['file_name']['type'];
					$file_size = $_FILES['file_name']['size'];
					$file_tmp = $_FILES['file_name']['tmp_name'];

					if ($file_tmp) 
					{
						$path = "//172.16.30.157/www/mooc/thumbkelas";
						$path_info = pathinfo($file_name);

						// get first three words of nama_kelas
						$nama_kelas_kata = explode(" ", $nama_kelas);
						$nama_kelas_kata = $nama_kelas_kata[0] . " " . $nama_kelas_kata[1] . " " . $nama_kelas_kata[2];


						$file_name = 'thumbkelas-' . $nama_kelas_kata . '.' . $path_info['extension'];

						move_uploaded_file($file_tmp, $path . "/" . $file_name);
						// $this->ArtikelFileService->editFile($last_id, $file_name, $file_type, $file_size);			
					}


			$id = $this->KelasService->addData($nama_kelas, $deskripsi, $tentang, $jenis_kelas, $file_name);

			$this->_redirect('/admin/kelas/index');
		}
	}

	public function editAction()
	{
		$id = $this->getRequest()->getParam('id');

		if ($this->getRequest()->isPost()) {
			$nama_kelas = $this->getRequest()->getParam('nama_kelas');
			$deskripsi = $this->getRequest()->getParam('deskripsi');
			$tentang = $this->getRequest()->getParam('tentang');
			$jenis_kelas = $this->getRequest()->getParam('jenis_kelas');
			
			$file_name = $_FILES['file_name']['name'];
					$file_type = $_FILES['file_name']['type'];
					$file_size = $_FILES['file_name']['size'];
					$file_tmp = $_FILES['file_name']['tmp_name'];

					if ($file_tmp) 
					{
						$path = "//172.16.30.157/www/mooc/thumbkelas";
						$path_info = pathinfo($file_name);

						// get first three words of nama_kelas
						$nama_kelas_kata = explode(" ", $nama_kelas);
						$nama_kelas_kata = $nama_kelas_kata[0] . " " . $nama_kelas_kata[1] . " " . $nama_kelas_kata[2];


						$file_name = 'thumbkelas-' . $nama_kelas_kata . '.' . $path_info['extension'];

						move_uploaded_file($file_tmp, $path . "/" . $file_name);
						// $this->ArtikelFileService->editFile($last_id, $file_name, $file_type, $file_size);			
					}

			try {
				$this->KelasService->editData($id, $nama_kelas, $deskripsi, $tentang, $jenis_kelas, $file_name);
			} catch (Exception $e) {
				echo $e->getMessage();
				$this->_redirect('/admin/kelas/index/error/' . $e->getMessage());
			}

			$this->_redirect('/admin/kelas/index');
		} else {
			$this->view->row = $this->KelasService->getData($id);
			$this->view->rows = $this->KelasSilabusService->getAllData($id);
		}
	}

	public function deleteFilesAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->KelasService->deleteFiles($id);
		$this->_redirect('/admin/kelas/edit/id/' . $id);
	}


	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->KelasService->softDeleteData($id);

		$this->_redirect('/admin/kelas/index');
	}

	public function addSilabusAction()
	{
		$id = $this->getRequest()->getParam('id');
		if ($this->getRequest()->isPost()) {
			$nama_silabus = $this->getRequest()->getParam('nama_silabus');
			$last_id = $this->KelasSilabusService->addData($id, $nama_silabus);

			$this->_redirect('/admin/kelas/edit/id/' . $id);
		} else {
			$this->view->id = $id;
		}
	}

	public function editSilabusAction()
	{
		$id = $this->getRequest()->getParam('id');

		if ($this->getRequest()->isPost()) {
			$id_kelas = $this->getRequest()->getParam('id_kelas');
			$nama_silabus = $this->getRequest()->getParam('nama_silabus');
			$this->KelasSilabusService->editData($id, $nama_silabus);

			$this->_redirect('/admin/kelas/edit/id/' . $id_kelas);
		} else {
			$row = $this->KelasSilabusService->getData($id);
			$this->view->row = $row;
			// $this->view->row = $this->KelasSilabusService->getData($id);

			$this->view->rows = $this->KelasSilabusMateriService->getDataByIdKelasSilabus($row->id);
		}
	}

	public function deleteSilabusAction()
	{
		$id = $this->getRequest()->getParam('id');
		$id_kelas = $this->getRequest()->getParam('id_kelas');
		$this->KelasSilabusService->softDeleteData($id);

		$this->_redirect('/admin/kelas/edit/id/' . $id_kelas);
	}

	public function addMateriAction()
	{
		if ($this->getRequest()->isPost()) {
			$nama_materi = $this->getRequest()->getParam('nama_materi');
			$deskripsi_materi = $this->getRequest()->getParam('deskripsi_materi');
			$isi_materi = $this->getRequest()->getParam('isi_materi');
			$id_kelas_silabus = $this->getRequest()->getParam('id');

			$id = $this->KelasSilabusMateriService->addData($id_kelas_silabus, $nama_materi, $deskripsi_materi, $isi_materi);


			$this->_redirect('/admin/kelas/edit-silabus/id/' . $id_kelas_silabus);
		}

		$id = $this->getRequest()->getParam('id');
		$this->view->nama_silabus = $this->KelasSilabusService->getData($id)->nama_silabus;
		$this->view->id = $id;
		
		
	}


	public function editMateriAction()
	{
		$id = $this->getRequest()->getParam('id');

		if ($this->getRequest()->isPost()) {
			$id_kelas_silabus = $this->getRequest()->getParam('id_kelas_silabus');
			$nama_materi = $this->getRequest()->getParam('nama_materi');
			$deskripsi_materi = $this->getRequest()->getParam('deskripsi_materi');
			$isi_materi = $this->getRequest()->getParam('isi_materi');


			// $this->_redirect('/admin/kelas/edit-materi/id/'.$id_kelas_silabus);

			try {
				$this->KelasSilabusMateriService->editData($id, $nama_materi, $deskripsi_materi, $isi_materi);
			} catch (Exception $e) {
				echo $e->getMessage();
				$this->_redirect('/admin/kelas/index/error/' . $e->getMessage());
			}

			$this->_redirect('/admin/kelas/edit-silabus/id/' . $id_kelas_silabus);
		} else {
			$this->view->row = $this->KelasSilabusService->getData($id);
			$data = $this->KelasSilabusMateriService->getData($id);
			$this->view->data = $data;
			$this->view->nama_silabus = $this->KelasSilabusService->getData($data->id_kelas_silabus)->nama_silabus;
		}
	}

	public function deleteMateriAction()
	{
		$id = $this->getRequest()->getParam('id');
		$id_kelas_silabus = $this->getRequest()->getParam('id_kelas_silabus');
		$this->KelasSilabusMateriService->softDeleteData($id);

		$this->_redirect('/admin/kelas/edit-silabus/id/' . $id_kelas_silabus);
	}
}
