<?php
class Admin_PengajarController extends Zend_Controller_Action
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
		$rows=$this->PengajarService->getAllData();
		$this->view->rows = $rows;

	}

	// fotopengajar_uri
	// identitas_pengajar
	// nama_pengajar
	// status_asal
	// email
	// no_telp
	
	public function addAction()
	{
		if ($this->getRequest()->isPost()) {
			$nama_pengajar = $this->getRequest()->getParam('nama_pengajar');
			$status_asal = $this->getRequest()->getParam('status_asal');
			$email = $this->getRequest()->getParam('email');
			$no_telp = $this->getRequest()->getParam('no_telp');
			$identitas_pengajar = $this->getRequest()->getParam('identitas_pengajar');
			$kelas_id = $this->getRequest()->getParam('kelas_id');
			$batch_id = $this->getRequest()->getParam('batch_id');
			$file_name = $_FILES['file_name']['name'];
					$file_type = $_FILES['file_name']['type'];
					$file_size = $_FILES['file_name']['size'];
					$file_tmp = $_FILES['file_name']['tmp_name'];

					if ($file_tmp) 
					{
						$path = "//172.16.30.157/www/mooc/fotopengajar";
						$path_info = pathinfo($file_name);

						// get first three words of nama_pengajar
						$nama_pengajar_kata = explode(" ", $nama_pengajar);
						$nama_pengajar_kata = $nama_pengajar_kata[0] . " " . $nama_pengajar_kata[1];

						$file_name = 'fotopengajar-' . $nama_pengajar_kata . '.' . $path_info['extension'];

						move_uploaded_file($file_tmp, $path . "/" . $file_name);		
					}
					
			$id=$this->PengajarService->addData($nama_pengajar, $status_asal, $email, $no_telp, $identitas_pengajar, $file_name);

			$this->_redirect('/admin/pengajar/index');
		}
	}

	public function editAction()
	{
		$id = $this->getRequest()->getParam('id');
		$row=$this->PengajarService->getData($id);
		$this->view->row = $row;

		if ($this->getRequest()->isPost()) {
			$nama_pengajar = $this->getRequest()->getParam('nama_pengajar');
			$status_asal = $this->getRequest()->getParam('status_asal');
			$email = $this->getRequest()->getParam('email');
			$no_telp = $this->getRequest()->getParam('no_telp');
			$identitas_pengajar = $this->getRequest()->getParam('identitas_pengajar');
			$kelas_id = $this->getRequest()->getParam('kelas_id');
			$batch_id = $this->getRequest()->getParam('batch_id');

			$file_name = $this->getRequest()->getParam('file_name');
			if ($file_name == "") {
				$file_name = $_FILES['file_name']['name'];
				$file_type = $_FILES['file_name']['type'];
				$file_size = $_FILES['file_name']['size'];
				$file_tmp = $_FILES['file_name']['tmp_name'];
			}

			if ($file_tmp) {
				$path = "//172.16.30.157/www/mooc/fotopengajar";
				$path_info = pathinfo($file_name);

				// get first three words of nama_pengajar
				$nama_pengajar_kata = explode(" ", $nama_pengajar);
				$nama_pengajar_kata = $nama_pengajar_kata[0] . " " . $nama_pengajar_kata[1];

				$file_name = 'fotopengajar-' . $nama_pengajar_kata . '.' . $path_info['extension'];

				move_uploaded_file($file_tmp, $path . "/" . $file_name);		
			}

			try {
				$this->PengajarService->editData($id, $nama_pengajar, $status_asal, $email, $no_telp,$identitas_pengajar, $file_name);
				$this->redirect('/admin/pengajar/index');
			} catch (Exception $e) {
				$this->view->error = $e->getMessage();
			}

				$this -> _redirect('/admin/pengajar/index');
		}	
				
	}

	public function deleteFilesAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->PengajarService->deleteFiles($id);
		$this->_redirect('/admin/pengajar/edit/id/' . $id);
	}

	public function deleteAction()
	{
		
	}
}
