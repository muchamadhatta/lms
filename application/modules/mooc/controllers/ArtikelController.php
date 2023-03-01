<?php
class Admin_ArtikelController extends Zend_Controller_Action
{
	
	public function init()
	{ 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index', 'edit'));
	}
	
	public function preDispatch()
	{
		$this->ArtikelService = new ArtikelService();
		$this->ArtikelFileService = new ArtikelFileService();
		$this->SubtipeArtikelService = new SubtipeArtikelService();
		$this->ArtikelVisitorService = new ArtikelVisitorService();
		$this->TagCloudService = new TagCloudService();
	}
	
	public function indexAction() 
	{	
		$this->view->rows = $this->ArtikelService->getAllData();
	}

	public function addAction() 
	{	
		if ( $this->getRequest()->isPost() )
		{
			$judul = $this->getRequest()->getParam('judul');
			$konten = $this->getRequest()->getParam('konten');
			$tag = $this->getRequest()->getParam('tag');
			$tanggal = $this->_helper->CDate($this->getRequest()->getParam('tanggal'));
			$id_subtipe_artikel = $this->getRequest()->getParam('id_subtipe_artikel');
			$id_tipe_artikel = $this->getRequest()->getParam('id_tipe_artikel');
			$reporter = $this->getRequest()->getParam('reporter');
			$penulis = $this->getRequest()->getParam('penulis');
			$editor = $this->getRequest()->getParam('editor');
			$id = $this->ArtikelService->addData($judul, $konten, $tanggal, $tag, $id_subtipe_artikel, $id_tipe_artikel, $reporter, $penulis, $editor);
			
			$this->tagCloud();

			$this->_redirect('/admin/artikel/index');
		}
	}

	public function editAction() 
	{	
		$id = $this->getRequest()->getParam('id');

		if ( $this->getRequest()->isPost() )
		{
			$judul = $this->getRequest()->getParam('judul');
			$konten = $this->getRequest()->getParam('konten');
			$tanggal = $this->_helper->CDate($this->getRequest()->getParam('tanggal'));
			$tag = $this->getRequest()->getParam('tag');
			$id_subtipe_artikel = $this->getRequest()->getParam('id_subtipe_artikel');
			$id_tipe_artikel = $this->getRequest()->getParam('id_tipe_artikel');
			$reporter = $this->getRequest()->getParam('reporter');
			$penulis = $this->getRequest()->getParam('penulis');
			$editor = $this->getRequest()->getParam('editor');
			$status_artikel_utama = $this->getRequest()->getParam('status_artikel_utama');
			$status_pilihan = $this->getRequest()->getParam('status_pilihan');
			$status_publikasi = $this->getRequest()->getParam('status_publikasi');
			$status_komentar = $this->getRequest()->getParam('status_komentar');
			$this->ArtikelService->editData($id, $judul, $konten, $tanggal, $tag, $id_subtipe_artikel, $id_tipe_artikel, $reporter, $penulis, $editor, $status_artikel_utama, $status_pilihan, $status_publikasi, $status_komentar);		
			
			$this->tagCloud();

			$this->_redirect('/admin/artikel/index');
		} else {
			$this->view->row = $this->ArtikelService->getData($id);
			$this->view->ArtikelFileRows = $this->ArtikelFileService->getAllData($id);
		}
	}

	public function tagCloud()
	{
		$this->TagCloudService->deleteData();
		$row = $this->ArtikelService->getAllKeywordData();
		$arrTags = explode(',', $row->judul);
		foreach($arrTags as $key)
		{
			$this->TagCloudService->addData(strtolower(trim($key)));
		}
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->ArtikelService->softDeleteData($id);

		$this->_redirect('/admin/artikel/index');
	}

	public function searchSubtipeArtikelAction()
	{
		$this->_helper->getHelper('layout')->disableLayout();

		$indeks = $this->getRequest()->getParam('indeks');
		$this->view->indeks = $indeks;
		$this->view->rows = $this->SubtipeArtikelService->getAllData();
	}

	public function addFileAction() 
	{	
		$this->_helper->getHelper('layout')->disableLayout();
		$id = $this->getRequest()->getParam('id');
		if ( $this->getRequest()->isPost() )
		{
			$arrJenis = array(0 => 'image', 1 => 'file');
			for($i=1; $i<=5; $i++)
			{
				$jenis = $this->getRequest()->getParam('jenis'.$i);
				$judul = $this->getRequest()->getParam('judul'.$i);

				if ($judul <> '')
				{
					$last_id = $this->ArtikelFileService->addData($id, $jenis, $judul);

					$file_name = $_FILES['file'.$i]['name'];
					$file_type = $_FILES['file'.$i]['type'];
					$file_size = $_FILES['file'.$i]['size'];
					$file_tmp = $_FILES['file'.$i]['tmp_name'];

					if ($file_tmp) 
					{
						$path = "//172.16.30.157/www/diparlin/artikel";
						$path_info = pathinfo($file_name);
						$file_name = 'artikel-' . $arrJenis[$jenis] . '-' . $last_id . '.' . $path_info['extension'];

						move_uploaded_file($file_tmp, $path . "/" . $file_name);
						$this->ArtikelFileService->editFile($last_id, $file_name, $file_type, $file_size);			
					}
				}
			}

			$this->_redirect('/admin/artikel/edit/id/'.$id);
		} else {
			$this->view->id = $id;
		}
	}

	public function editFileAction() 
	{	
		$this->_helper->getHelper('layout')->disableLayout();
		$id = $this->getRequest()->getParam('id');
		$id_artikel = $this->getRequest()->getParam('id_artikel');
		if ( $this->getRequest()->isPost() )
		{
			$jenis = $this->getRequest()->getParam('jenis');
			$judul = $this->getRequest()->getParam('judul');
			$this->ArtikelFileService->editData($id, $jenis, $judul);

			$file_name = $_FILES['file']['name'];
			$file_type = $_FILES['file']['type'];
			$file_size = $_FILES['file']['size'];
			$file_tmp = $_FILES['file']['tmp_name'];

			$arrJenis = array(0 => 'image', 1 => 'file');
			if ($file_tmp) 
			{
				$path = "//172.16.30.157/www/diparlin/artikel";
				$path_info = pathinfo($file_name);
				$file_name = 'artikel-' . $arrJenis[$jenis] . '-' . $id . '.' . $path_info['extension'];

				move_uploaded_file($file_tmp, $path . "/" . $file_name);
				$this->ArtikelFileService->editFile($id, $file_name, $file_type, $file_size);			
			}

			$this->_redirect('/admin/artikel/edit/id/'.$id_artikel);
		} else {
			$this->view->row = $this->ArtikelFileService->getData($id);
		}
	}

	public function deleteFileAction()
	{
		$id = $this->getRequest()->getParam('id');
		$id_artikel = $this->getRequest()->getParam('id_artikel');
		
		$row = $this->ArtikelFileService->getData($id);
		$path = "//172.16.30.157/www/diparlin/artikel";
		unlink($path . "/" . $row->file_name);

		$this->ArtikelFileService->softDeleteData($id);

		$this->_redirect('/admin/artikel/edit/id/'.$id_artikel);
	}

}