<?php
class Admin_KontakController extends Zend_Controller_Action
{
	
	public function init()
	{ 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index', 'edit'));
	}
	
	public function preDispatch()
	{
		$this->KontakService = new KontakService();
	}
	
	public function indexAction() 
	{	
		$this->view->rows = $this->KontakService->getAllData();
	}

	public function addAction() 
	{	
		if ( $this->getRequest()->isPost() )
		{
			$nama = htmlspecialchars(strip_tags($this->getRequest()->getParam('nama', '')), ENT_QUOTES);
			$email = htmlspecialchars(strip_tags($this->getRequest()->getParam('email', '')), ENT_QUOTES);
			$judul = htmlspecialchars(strip_tags($this->getRequest()->getParam('judul', '')), ENT_QUOTES);
			$pesan = htmlspecialchars(strip_tags($this->getRequest()->getParam('pesan', '')), ENT_QUOTES);

			$id = $this->KontakService->addData($nama, $email, $judul, $pesan);

			$this->_redirect('/admin/kontak/index');
		}
	}

	public function editAction() 
	{	
		$id = $this->getRequest()->getParam('id');

		if ( $this->getRequest()->isPost() )
		{
			$nama = htmlspecialchars(strip_tags($this->getRequest()->getParam('nama', '')), ENT_QUOTES);
			$email = htmlspecialchars(strip_tags($this->getRequest()->getParam('email', '')), ENT_QUOTES);
			$judul = htmlspecialchars(strip_tags($this->getRequest()->getParam('judul', '')), ENT_QUOTES);
			$pesan = htmlspecialchars(strip_tags($this->getRequest()->getParam('pesan', '')), ENT_QUOTES);

			$this->KontakService->editData($id, $nama, $email, $judul, $pesan);

			$this->_redirect('/admin/kontak/index');
		} else {
			$this->view->row = $this->KontakService->getData($id);
		}
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->KontakService->softDeleteData($id);

		$this->_redirect('/admin/kontak/index');
	}

	public function replyAction() 
	{	
		$this->_helper->getHelper('layout')->disableLayout();
		$id = $this->getRequest()->getParam('id');
		if ( $this->getRequest()->isPost() )
		{
			$balasan = $this->getRequest()->getParam('balasan');

			if ($balasan != '')
			{
				$row = $this->KontakService->getData($id);
				$this->KontakService->updateData($id, $balasan);

				//kirim email otomatis..
				$config = array(
					'port' => '25252',
					'auth' => 'login',
					'username' => 'no_reply',
					'password' => 'norep13579'
				);
				$transport = new Zend_Mail_Transport_Smtp('172.17.3.23', $config);

				$mail = new Zend_Mail();
				$mail->setFrom('no_reply@dpr.go.id', 'PUSPANLAKUU DPR RI');
				$mail->setSubject('Hubungi Kami PUSPANLAKUU DPR RI');
				
				$mail->setBodyText(				
'Sdr/i. '.$row->nama.', 

Terimakasih telah mengunjungi website kami di http://puspanlakuu.dpr.go.id pada tanggal '. $this->_helper->FormatDate($row->tanggal_input) .', berikut penjelasannya :

'.$balasan.'

SEKRETARIAT PUSPANLAKUU DPR RI
'
				);
				$mail->addTo($row->email, $row->nama);
				$mail->send($transport);			
				//akhir kirim email
			}

			$this->_redirect('/admin/kontak/edit/id/'.$id);
		} else {
			$this->view->id = $id;
		}
	}

}