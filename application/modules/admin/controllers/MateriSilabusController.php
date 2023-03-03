<?php
class Admin_MateriSilabusController extends Zend_Controller_Action
{
	
	public function init() { 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index'));
	}
	
	public function preDispatch() {
		$this->MateriSilabusService = new MateriSilabusService();
		$this->PelatihanService = new PelatihanService();
	}
	
	public function indexAction()  {	
		$this->view->rows = $this->MateriSilabusService->getAllData();
		$this->view->rows2 = $this->PelatihanService->getAllData();
	}

	public function addAction() {	
		if ($this->getRequest()->isPost()) {
			$nama_materi = $this->getRequest()->getParam('nama_materi');
			$deskripsi_materi = $this->getRequest()->getParam('deskripsi_materi');
			$id_pelatihan = $this->getRequest()->getParam('id_pelatihan');

			// upload file gambar
			$file_image = $_FILES['file_image']['name'];
			$file_type = $_FILES['file_image']['type'];
			$file_size = $_FILES['file_image']['size'];
			$file_tmp = $_FILES['file_image']['tmp_name'];
			$file_error = $_FILES['file_image']['error'];

			// cek apakah user sudah upload gambar
			if($file_error === 4) { 
				echo "<script>
						alert('Upload gambar terlebih dahulu!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false;
			}
		
			//Cek ukuran gambar
			if($file_size > 2000000){
				echo "<script>
						alert('Ukuran gambar terlalu besar!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false; 
			}

			// upload file gambar
			if ($file_tmp) {
				$path = "//172.16.30.157/www/mooc/gambarmateri";
				
				$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
				$ekstensiGambar = explode('.', $file_image); 
				$ekstensiGambar = strtolower(end($ekstensiGambar)); 
	
				if(!in_array($ekstensiGambar, $ekstensiGambarValid)) {
					echo "<script>
							alert('Yang diupload bukan file gambar!');
							$this->_redirect('/admin/materi-silabus/index');
						</script>";
					return false;
				} 
				
				$file_gambar_tmp_baru = uniqid(); 
				$file_gambar_tmp_baru .= '.';
				$file_gambar_tmp_baru .= $ekstensiGambar;
				move_uploaded_file($file_tmp, $path . "/" . $file_gambar_tmp_baru);	
			}
			//----------------------------------------------------------

			// upload file document
			$file_pdf = $_FILES['file_pdf']['name'];
			$file_pdf_type = $_FILES['file_pdf']['type'];
			$file_pdf_size = $_FILES['file_pdf']['size'];
			$file_pdf_tmp = $_FILES['file_pdf']['tmp_name'];
			$file_pdf_error = $_FILES['file_pdf']['error'];

			// cek apakah user sudah upload file pdf
			if($file_pdf_error === 4) { 
				echo "<script>
						alert('Upload file document pdf terlebih dahulu!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false;
			}
		
			//Cek ukuran file pdf (maks 10mb)
			if($file_pdf_size > 10000000){ 
				echo "<script>
						alert('Ukuran file document pdf terlalu besar!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false; 
			}

			if($file_pdf_tmp) {
				$path_pdf = "//172.16.30.157/www/mooc/filemateri";
				
				$ekstensiDocumentValid = ['pdf', 'docx', 'doc'];
				$ekstensiDocument = explode('.', $file_pdf); 
				$ekstensiDocument = strtolower(end($ekstensiDocument)); 
	
				if(!in_array($ekstensiDocument, $ekstensiDocumentValid)) {
					echo "<script>
							alert('Yang diupload bukan file document!');
							$this->_redirect('/admin/materi-silabus/index');
						</script>";
					return false;
				} 
				
				$file_document_tmp_baru = uniqid(); 
				$file_document_tmp_baru .= '.';
				$file_document_tmp_baru .= $ekstensiDocument;
				move_uploaded_file($file_pdf_tmp, $path_pdf . "/" . $file_document_tmp_baru);		
			}
			//----------------------------------------------------------

			// upload file audio
			$file_audio = $_FILES['file_audio']['name'];
			$file_audio_type = $_FILES['file_audio']['type'];
			$file_audio_size = $_FILES['file_audio']['size'];
			$file_audio_tmp = $_FILES['file_audio']['tmp_name'];
			$file_audio_error = $_FILES['file_audio']['error'];

			// cek apakah user sudah upload file audio
			if($file_audio_error === 4) { 
				echo "<script>
						alert('Upload file audio terlebih dahulu!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false;
			}
		
			//Cek ukuran file audio (maks 10mb)
			if($file_audio_size > 10000000){ 
				echo "<script>
						alert('Ukuran file audio terlalu besar!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false; 
			}

			if($file_suara_tmp) {
				$path_audio = "//172.16.30.157/www/mooc/audiomateri";
				
				$ekstensiAudioValid = ['mp3', 'wav', 'acc'];
				$ekstensiAudio = explode('.', $file_audio); 
				$ekstensiAudio = strtolower(end($ekstensiAudio)); 
	
				if(!in_array($ekstensiAudio, $ekstensiAudioValid)) {
					echo "<script>
							alert('Yang diupload bukan file audio!');
							$this->_redirect('/admin/materi-silabus/index');
						</script>";
					return false;
				} 
				
				$file_audio_tmp_baru = uniqid(); 
				$file_audio_tmp_baru .= '.';
				$file_audio_tmp_baru .= $ekstensiAudio;
				move_uploaded_file($file_audio_tmp, $path_audio . "/" . $file_audio_tmp_baru);		
			}
			//----------------------------------------------------------

			// upload file video
			$file_video = $_FILES['file_video']['name'];
			$file_video_type = $_FILES['file_video']['type'];
			$file_video_size = $_FILES['file_video']['size'];
			$file_video_tmp = $_FILES['file_video']['tmp_name'];
			$file_video_error = $_FILES['file_video']['error'];

			// cek apakah user sudah upload file video
			if($file_video_error === 4) { 
				echo "<script>
						alert('Upload file video terlebih dahulu!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false;
			}
		
			//Cek ukuran file video (maks 100mb)
			if($file_video_size > 100000000){ 
				echo "<script>
						alert('Ukuran file video terlalu besar!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false; 
			}

			if($file_video_tmp) {
				$path_video = "//172.16.30.157/www/mooc/videomateri";
				
				$ekstensiVideoValid = ['mp4', 'mkv', 'avi', 'webm', 'wmv'];
				$ekstensiVideo = explode('.', $file_video); 
				$ekstensiVideo = strtolower(end($ekstensiVideo)); 
	
				if(!in_array($ekstensiVideo, $ekstensiVideoValid)) {
					echo "<script>
							alert('Yang diupload bukan file video!');
							$this->_redirect('/admin/materi-silabus/index');
						</script>";
					return false;
				} 
				
				$file_video_tmp_baru = uniqid(); 
				$file_video_tmp_baru .= '.';
				$file_video_tmp_baru .= $ekstensiVideo;
				move_uploaded_file($file_video_tmp, $path_video . "/" . $file_video_tmp_baru);		
			}




			$id=$this->MateriSilabusService->addData($id_pelatihan, $nama_materi, $deskripsi_materi, $file_gambar_tmp_baru, $file_document_tmp_baru, $file_audio_tmp_baru, $file_video_tmp_baru);
		
			$this->_redirect('/admin/materi-silabus/index');
		} else {
			$this->view->rows = $this->MateriSilabusService->getAllData();
		}
	}

	public function editAction() {
		$id = $this->getRequest()->getParam('id');
		$row=$this->MateriSilabusService->getData($id);
		$this->view->row = $row;

		if ($this->getRequest()->isPost()) {
			$id_pelatihan = $this->getRequest()->getParam('id_pelatihan');
			$nama_materi = $this->getRequest()->getParam('nama_materi');
			$deskripsi_materi = $this->getRequest()->getParam('deskripsi_materi');
			$file_image = $this->getRequest()->getParam('file_image');
			$file_pdf = $this->getRequest()->getParam('file_pdf');
			$file_audio = $this->getRequest()->getParam('file_audio');
			$file_video = $this->getRequest()->getParam('file_video');
			if ($file_image == "") {
				$file_image = isset($_FILES['file_image']['name']) ? $_FILES['file_image']['name'] : '';
				$file_type = $_FILES['file_image']['type'];
				$file_size = $_FILES['file_image']['size'];
				$file_tmp = $_FILES['file_image']['tmp_name'];
				$file_error = $_FILES['file_image']['error'];
			}

			// cek apakah user sudah upload gambar
			if($file_error === 4) { 
				echo "<script>
						alert('Upload gambar terlebih dahulu!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false;
			}
		
			//Cek ukuran gambar
			if($file_size > 2000000){
				echo "<script>
						alert('Ukuran gambar terlalu besar!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false; 
			}

			// upload file image
			if ($file_tmp) {
				$path = "//172.16.30.157/www/mooc/gambarmateri";
				$path_info = pathinfo($file_image);

				$nama_materi_kata = explode(" ", $nama_materi);
				$nama_materi_kata = $nama_materi_kata[0] . " " . $nama_materi_kata[1];
				$file_image = 'image-' . $nama_materi_kata . '-' . uniqid() . '.' . $path_info['extension'];

				move_uploaded_file($file_tmp, $path . "/" . $file_image);	
			}
			//----------------------------------------------

			if ($file_pdf == "") {
				$file_pdf = isset($_FILES['file_pdf']['name']) ? $_FILES['file_pdf']['name'] : '';
				$file_pdf_type = $_FILES['file_pdf']['type'];
				$file_pdf_size = $_FILES['file_pdf']['size'];
				$file_pdf_tmp = $_FILES['file_pdf']['tmp_name'];
				$file_pdf_error = $_FILES['file_pdf']['error'];
			}

			// cek apakah user sudah upload file pdf
			if($file_pdf_error === 4) { 
				echo "<script>
						alert('Upload file document pdf terlebih dahulu!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false;
			}
			
			//Cek ukuran file pdf (maks 10mb)
			if($file_pdf_size > 10000000){ 
				echo "<script>
						alert('Ukuran file document pdf terlalu besar!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false; 
			}

			// upload file pdf
			if ($file_pdf_tmp) {		
				$path_pdf = "//172.16.30.157/www/mooc/filemateri";
				$path_info = pathinfo($file_pdf);

				$nama_materi_kata = explode(" ", $nama_materi);
				$nama_materi_kata = $nama_materi_kata[0] . " " . $nama_materi_kata[1];
				$file_pdf = 'document-' . $nama_materi_kata . '-' . uniqid() . '.' . $path_info['extension'];

				move_uploaded_file($file_tmp, $path_pdf . "/" . $file_pdf);		
			}
			//----------------------------------------------

			if ($file_audio == "") {
				$file_audio = isset($_FILES['file_audio']['name']) ? $_FILES['file_audio']['name'] : '';
				$file_audio_type = $_FILES['file_audio']['type'];
				$file_audio_size = $_FILES['file_audio']['size'];
				$file_audio_tmp = $_FILES['file_audio']['tmp_name'];
				$file_audio_error = $_FILES['file_audio']['error'];
			}

			// cek apakah user sudah upload file audio
			if($file_audio_error === 4) { 
				echo "<script>
						alert('Upload file audio terlebih dahulu!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false;
			}
			
			//Cek ukuran file audio (maks 10mb)
			if($file_audio_size > 10000000){ 
				echo "<script>
						alert('Ukuran file audio terlalu besar!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false; 
			}

			// upload file audio
			if ($file_audio_tmp) {		
				$path_audio = "//172.16.30.157/www/mooc/audiomateri";
				$path_info = pathinfo($file_audio);

				$nama_materi_kata = explode(" ", $nama_materi);
				$nama_materi_kata = $nama_materi_kata[0] . " " . $nama_materi_kata[1];
				$file_audio = 'audio-' . $nama_materi_kata . '-' . uniqid() . '.' . $path_info['extension'];

				move_uploaded_file($file_tmp, $path_audio . "/" . $file_audio);		
			}
			//----------------------------------------------

			if ($file_video == "") {
				$file_video = isset($_FILES['file_video']['name']) ? $_FILES['file_video']['name'] : '';
				$file_video_type = $_FILES['file_video']['type'];
				$file_video_size = $_FILES['file_video']['size'];
				$file_video_tmp = $_FILES['file_video']['tmp_name'];
				$file_video_error = $_FILES['file_video']['error'];
			}

			// cek apakah user sudah upload file video
			if($file_video_error === 4) { 
				echo "<script>
						alert('Upload file video terlebih dahulu!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false;
			}
			
			//Cek ukuran file audio (maks 100mb)
			if($file_video_size > 100000000){ 
				echo "<script>
						alert('Ukuran file video terlalu besar!');
						$this->_redirect('/admin/materi-silabus/index');
					</script>";
				return false; 
			}

			// upload file video
			if ($file_video_tmp) {		
				$path_video = "//172.16.30.157/www/mooc/videomateri";
				$path_info = pathinfo($file_video);

				$nama_materi_kata = explode(" ", $nama_materi);
				$nama_materi_kata = $nama_materi_kata[0] . " " . $nama_materi_kata[1];
				$file_video = 'video-' . $nama_materi_kata . '-' . uniqid() . '.' . $path_info['extension'];

				move_uploaded_file($file_video_tmp, $path_video . "/" . $file_video);		
			}


			try {
				$this->MateriSilabusService->editData($id, $id_pelatihan, $nama_materi, $deskripsi_materi, $file_image, $file_pdf, $file_audio, $file_video);
				$this->redirect('/admin/materi-silabus/index');
			} catch (Exception $e) {
				$this->view->error = $e->getMessage();
			}
				$this -> _redirect('/admin/materi-silabus/index');
		}	
				
	}

	public function deleteFilesAction() {
		$id = $this->getRequest()->getParam('id');
		$this->MateriSilabusService->deleteFiles($id);
		$this->_redirect('/admin/materi-silabus/edit/id/' . $id);
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->MateriSilabusService->deleteData($id);
		// $this->KelasSilabusMateriService->softDeleteData($id);

		$this->_redirect('/admin/materi-silabus/index');
	}

}