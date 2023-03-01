<?php
class Admin_KelasSilabusMateriController extends Zend_Controller_Action
{
	
	public function init() { 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index'));
	}
	
	public function preDispatch() {
		$this->KelasSilabusMateriService = new KelasSilabusMateriService();
	}
	
	public function indexAction()  {	
		$this->view->rows = $this->KelasSilabusMateriService->getAllData();
	}

	public function addAction() {	
		if ($this->getRequest()->isPost()) {
			$nama_materi = $this->getRequest()->getParam('nama_materi');
			$deskripsi_materi = $this->getRequest()->getParam('deskripsi_materi');

			// upload file gambar
			$file_image = $_FILES['file_image']['name'];
			$file_type = $_FILES['file_image']['type'];
			$file_size = $_FILES['file_image']['size'];
			$file_tmp = $_FILES['file_image']['tmp_name'];
			$error = $_FILES['file_image']['error'];

			// cek apakah user sudah upload gambar
			if($error === 4) { 
				echo "<script>
						alert('Upload gambar terlebih dahulu!');
						$this->_redirect('/admin/kelas-silabus-materi/index');
					</script>";
				return false;
			}
		
			//Cek ukuran gambar
			if($file_size > 2000000){
				echo "<script>
						alert('Ukuran gambar terlalu besar!');
						$this->_redirect('/admin/kelas-silabus-materi/index');
					</script>";
				return false; 
			}

			// upload file gambar
			if ($file_tmp) {
				$path = "//172.16.30.157/www/mooc/gambarmateri";
				$path_info = pathinfo($file_image);

				// get first three words of nama_materi
				$nama_materi_kata = explode(" ", $nama_materi);
				$nama_materi_kata = $nama_materi_kata[0] . " " . $nama_materi_kata[1];

				$file_image = 'gambarmateri-' . $nama_materi_kata . '.' . $path_info['extension'];

				move_uploaded_file($file_tmp, $path . "/" . $file_image);		
			}

			// upload file gambar
			$file_pdf = $_FILES['file_pdf']['name'];
			$file_pdf_type = $_FILES['file_pdf']['type'];
			$file_pdf_size = $_FILES['file_pdf']['size'];
			$file_pdf_tmp = $_FILES['file_pdf']['tmp_name'];
			$file_pdf_error = $_FILES['file_pdf']['error'];

			// cek apakah user sudah upload file pdf
			if($error === 4) { 
				echo "<script>
						alert('Upload gambar terlebih dahulu!');
						$this->_redirect('/admin/kelas-silabus-materi/index');
					</script>";
				return false;
			}
		
			//Cek ukuran file pdf
			if($file_size > 2000000){
				echo "<script>
						alert('Ukuran gambar terlalu besar!');
						$this->_redirect('/admin/kelas-silabus-materi/index');
					</script>";
				return false; 
			}

			if ($file_tmp) {
				$path = "//172.16.30.157/www/mooc/filemateri";
				$path_info = pathinfo($file_image);

				// get first three words of nama_materi
				$nama_materi_kata = explode(" ", $nama_materi);
				$nama_materi_kata = $nama_materi_kata[0] . " " . $nama_materi_kata[1];

				$file_image = 'documentmateri-' . $nama_materi_kata . '.' . $path_info['extension'];

				move_uploaded_file($file_tmp, $path . "/" . $file_image);		
			}

			// $ekstensiFileValid = ['pdf'];
			// $ekstensiFile = explode('.', $file_pdf); 
			// $ekstensiFile = strtolower(end($ekstensiFile)); 

			// if(!in_array($ekstensiFile, $ekstensiFileValid)) {
			// 	echo "<script>
			// 			alert('Yang diupload bukan file document!');
			// 			$this->_redirect('/admin/kelas-silabus-materi/index');
			// 		</script>";
			// 	return false;
			// } 
			
			// $pathdocument = "//172.16.30.157/www/mooc/filemateri";
			// $file_pdf_tmp_baru = uniqid(); 
			// $file_pdf_tmp_baru .= '.';
			// $file_pdf_tmp_baru .= $ekstensiFile;
			// move_uploaded_file($file_pdf_tmp, $pathdocument, '/' . $file_pdf_tmp_baru);

			$id=$this->KelasSilabusMateriService->addData($nama_materi, $deskripsi_materi, $file_image, $file_pdf);
		
			$this->_redirect('/admin/kelas-silabus-materi/index');
		} else {
			$this->view->rows = $this->KelasSilabusMateriService->getAllData();
		}
	}

	public function editAction() {
		$id = $this->getRequest()->getParam('id');
		$row=$this->KelasSilabusMateriService->getData($id);
		$this->view->row = $row;

		if ($this->getRequest()->isPost()) {
			$nama_materi = $this->getRequest()->getParam('nama_materi');
			$deskripsi_materi = $this->getRequest()->getParam('deskripsi_materi');

			$file_image = $this->getRequest()->getParam('file_image');
			if ($file_image == "") {
				$file_image = $_FILES['file_image']['name'];
				$file_type = $_FILES['file_image']['type'];
				$file_size = $_FILES['file_image']['size'];
				$file_tmp = $_FILES['file_image']['tmp_name'];
			}

			if ($file_tmp) {
				$path = "//172.16.30.157/www/mooc/gambarmateri";
				$path_info = pathinfo($file_image);

				// get first three words of nama_materi
				$materi = explode(" ", $nama_materi);
				$nama_materi_kata = $nama_materi_kata[0] . " " . $nama_materi_kata[1];

				$file_image = 'filemateri-' . $nama_materi_kata . '.' . $path_info['extension'];

				move_uploaded_file($file_tmp, $path . "/" . $file_image);		
			}

			try {
				$this->KelasSilabusMateriService->editData($id, $nama_materi, $deskripsi_materi, $file_image);
				$this->redirect('/admin/kelas-silabus-materi/index');
			} catch (Exception $e) {
				$this->view->error = $e->getMessage();
			}
				$this -> _redirect('/admin/kelas-silabus-materi/index');
		}	
				
	}

	public function deleteFilesAction() {
		$id = $this->getRequest()->getParam('id');
		$this->KelasSilabusMateriService->deleteFiles($id);
		$this->_redirect('/admin/kelas-silabus-materi/edit/id/' . $id);
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->KelasSilabusMateriService->deleteData($id);
		// $this->KelasSilabusMateriService->softDeleteData($id);

		$this->_redirect('/admin/kelas-silabus-materi/index');
	}

}