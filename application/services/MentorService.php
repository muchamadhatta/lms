<?php
class MentorService {
	  
 	function __construct() {
		$this->mentor = new Mentor();
	}
	
	function getAllData() {
		$select = $this->mentor->select()->where('status = 1');
		$result = $this->mentor->fetchAll($select);
		return $result;
	}

	function getData($id) {
		$select = $this->mentor->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->mentor->fetchRow($select);
		return $result;
	}

	function addData($nama_mentor, $instansi, $email, $no_telp, $identitas_mentor, $fotomentor_uri) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'nama_mentor' => $nama_mentor, 
			'identitas_mentor' => $identitas_mentor,
			'instansi' => $instansi,
			'email' => $email,
			'no_telp' => $no_telp,
			'fotomentor_uri' => $fotomentor_uri,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->mentor->insert($params);
		$lastId = $this->mentor->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $nama_mentor, $identitas_mentor, $instansi, $email, $no_telp, $fotomentor_uri) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');
		$params = array(
			'nama_mentor' => $nama_mentor,
			'identitas_mentor' => $identitas_mentor, 	 		
			'instansi' => $instansi, 	
			'email' => $email, 	
			'no_telp' => $no_telp, 	
			'fotomentor_uri' => $fotomentor_uri,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->mentor->getAdapter()->quoteInto('id = ?', $id);
		$this->mentor->update($params, $where);

	}

	public function deleteFiles($id) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'fotomentor_uri' => '',
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->mentor->getAdapter()->quoteInto('id = ?', $id);
		$this->mentor->update($params, $where);
	}

	public function deleteData($id) {
		$where = $this->mentor->getAdapter()->quoteInto('id = ?', $id);
		$this->mentor->delete($where);
	}

	public function softDeleteData($id) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'status' => 9,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		
		$where = $this->mentor->getAdapter()->quoteInto('id = ?', $id);
		$this->mentor->update($params, $where);
	}
}