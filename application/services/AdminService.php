<?php
class AdminService {
	  
 	function __construct() {
		$this->admin = new Admin();
	}
	
	function getAllData() {
		$select = $this->admin->select()->where('status = 1');
		$result = $this->admin->fetchAll($select);
		return $result;
	}

	function getData($id) {
		$select = $this->admin->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->admin->fetchRow($select);
		return $result;
	}

	function addData($nama_admin, $identitas_admin, $instansi, $email, $no_telp, $fotoadmin_uri) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'nama_admin' => $nama_admin, 
			'identitas_admin' => $identitas_admin,
			'instansi' => $instansi,
			'email' => $email,
			'no_telp' => $no_telp,
			'fotoadmin_uri' => $fotoadmin_uri,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->admin->insert($params);
		$lastId = $this->admin->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $nama_admin, $identitas_admin, $instansi, $email, $no_telp, $fotoadmin_uri) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');
		$params = array(
			'nama_admin' => $nama_admin,
			'identitas_admin' => $identitas_admin, 	 		
			'instansi' => $instansi, 	
			'email' => $email, 	
			'no_telp' => $no_telp, 	
			'fotoadmin_uri' => $fotoadmin_uri,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->admin->getAdapter()->quoteInto('id = ?', $id);
		$this->admin->update($params, $where);

	}

	public function deleteFiles($id) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'fotoadmin_uri' => '',
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->admin->getAdapter()->quoteInto('id = ?', $id);
		$this->admin->update($params, $where);
	}

	public function deleteData($id) {
		$where = $this->admin->getAdapter()->quoteInto('id = ?', $id);
		$this->admin->delete($where);
	}

	public function softDeleteData($id) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'status' => 9,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		
		$where = $this->admin->getAdapter()->quoteInto('id = ?', $id);
		$this->admin->update($params, $where);
	}
}