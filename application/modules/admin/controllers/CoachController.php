<?php
class Admin_CoachController extends Zend_Controller_Action
{
	
	public function init()
	{ 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index'));
	}
	
	public function preDispatch()
	{
		$this->CoachService = new CoachService();
	}
	
	public function indexAction() 
	{	
		$this->view->rows = $this->CoachService->getAllData();
	}

	public function addAction() 
	{	
		if ( $this->getRequest()->isPost() )
		{
			$nama_coach = $this->getRequest()->getParam('nama_coach');
			$identitas_coach = $this->getRequest()->getParam('identitas_coach');
			$instansi = $this->getRequest()->getParam('instansi');
			$email = $this->getRequest()->getParam('email');
			$no_telp = $this->getRequest()->getParam('no_telp');

			// upload file
			$file_name = $_FILES['file_name']['name'];
			$file_type = $_FILES['file_name']['type'];
			$file_size = $_FILES['file_name']['size'];
			$file_tmp = $_FILES['file_name']['tmp_name'];

			if ($file_tmp) 
				{
					$path = "//172.16.30.157/www/mooc/fotocoach";
					$path_info = pathinfo($file_name);

					// get first three words of nama_coach
					$nama_coach_kata = explode(" ", $nama_coach);
					$nama_coach_kata = $nama_coach_kata[0] . " " . $nama_coach_kata[1];

					$file_name = 'fotocoach-' . $nama_coach_kata . '.' . $path_info['extension'];

					move_uploaded_file($file_tmp, $path . "/" . $file_name);		
				}

			// $id=$this->CoachService->addData($nama_coach, $instansi, $email, $no_telp, $identitas_coach);
			$last_id = $this->CoachService->addData($nama_coach, $instansi, $email, $no_telp, $identitas_coach, $file_name);

			// var_dump($file_name);
		
			$this->_redirect('/admin/coach/edit/id/'.$last_id);
		} else {
			$this->view->rows = $this->CoachService->getAllData();
		}
	}

	public function editAction() 
	{	
		$id = $this->getRequest()->getParam('id');
		$row=$this->CoachService->getData($id);
		$this->view->row = $row;

		if ( $this->getRequest()->isPost() )
		{
			$nama_coach = $this->getRequest()->getParam('nama_coach');
			$identitas_coach = $this->getRequest()->getParam('identitas_coach');
			$instansi = $this->getRequest()->getParam('instansi');
			$email = $this->getRequest()->getParam('email');
			$no_telp = $this->getRequest()->getParam('no_telp');

			$file_name = $this->getRequest()->getParam('file_name');
			if ($file_name == "") {
				$file_name = $_FILES['file_name']['name'];
				$file_type = $_FILES['file_name']['type'];
				$file_size = $_FILES['file_name']['size'];
				$file_tmp = $_FILES['file_name']['tmp_name'];
			}

			if ($file_tmp) {
				$path = "//172.16.30.157/www/mooc/fotocoach";
				$path_info = pathinfo($file_name);

				// get first three words of nama_coach
				$nama_coach_kata = explode(" ", $nama_coach);
				$nama_coach_kata = $nama_coach_kata[0] . " " . $nama_coach_kata[1];

				$file_name = 'fotocoach-' . $nama_coach_kata . '.' . $path_info['extension'];

				move_uploaded_file($file_tmp, $path . "/" . $file_name);		
			}
			
			try{
				$this->CoachService->editData($id, $nama_coach, $identitas_coach, $instansi, $email, $no_telp, $file_name);	
				$this->_redirect('/admin/coach/index');
			} catch (Exception $e) {
				$this->view->error = $e->getMessage();
			}
			$this->view->row = $this->CoachService->getData($id);
		}
	}

	public function deleteFilesAction() {
		$id = $this->getRequest()->getParam('id');
		$this->CoachService->deleteFiles($id);
		$this->_redirect('/admin/coach/edit/id/' . $id);
	}
	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->CoachService->deleteData($id);
		// $this->CoachService->softDeleteData($id);

		$this->_redirect('/admin/coach/index');
	}

}