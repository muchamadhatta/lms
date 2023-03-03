<?php
class PenilaiService {
	  
 	function __construct() {
		$this->penilai = new Penilai();
	}
	
	function getAllData() {
		$select = $this->penilai->select()->where('status = 1');
		$result = $this->penilai->fetchAll($select);
		return $result;
	}

	function getData($id) {
		$select = $this->penilai->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->penilai->fetchRow($select);
		return $result;
	}

	function addData($nama_penilai, $identitas_penilai, $instansi, $email, $no_telp, $fotopenilai_uri) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'nama_penilai' => $nama_penilai, 
			'identitas_penilai' => $identitas_penilai,
			'instansi' => $instansi,
			'email' => $email,
			'no_telp' => $no_telp,
			'fotopenilai_uri' => $fotopenilai_uri,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->penilai->insert($params);
		$lastId = $this->penilai->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $nama_penilai, $identitas_penilai, $instansi, $email, $no_telp, $fotopenilai_uri) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');
		$params = array(
			'nama_penilai' => $nama_penilai,
			'identitas_penilai' => $identitas_penilai, 	 		
			'instansi' => $instansi, 	
			'email' => $email, 	
			'no_telp' => $no_telp, 	
			'fotopenilai_uri' => $fotopenilai_uri,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->penilai->getAdapter()->quoteInto('id = ?', $id);
		$this->penilai->update($params, $where);

	}

	public function deleteFiles($id) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'fotopenilai_uri' => '',
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->penilai->getAdapter()->quoteInto('id = ?', $id);
		$this->penilai->update($params, $where);
	}

	public function deleteData($id) {
		$where = $this->penilai->getAdapter()->quoteInto('id = ?', $id);
		$this->penilai->delete($where);
	}

	public function softDeleteData($id) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'status' => 9,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		
		$where = $this->penilai->getAdapter()->quoteInto('id = ?', $id);
		$this->penilai->update($params, $where);
	}
}