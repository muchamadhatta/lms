<?php
class KontakService {
	  
 	function __construct() 
	{
  		$this->kontak = new Kontak();
	}

	function getAllData()
	{ 
		$select = $this->kontak->select()->where('status = 1');
		$result = $this->kontak->fetchAll($select);
		return $result;
	}

	function getData($id)
	{ 
		$select = $this->kontak->select()->where('id = ?', $id);
		$result = $this->kontak->fetchRow($select);
		return $result;
	}
  	
	function addData($nama, $email, $judul, $pesan) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'nama' => $nama, 
			'email' => $email,
			'judul' => $judul, 
			'pesan' => $pesan, 
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->kontak->insert($params);	
		$lastId = $this->kontak->getAdapter()->lastInsertId();
		return $lastId;
	}

	function editData($id, $nama, $email, $judul, $pesan)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

 		$params = array(
			'nama' => $nama, 
			'email' => $email,
			'judul' => $judul, 
			'pesan' => $pesan, 
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		
		$where = $this->kontak->getAdapter()->quoteInto('id = ?', $id);
		$this->kontak->update($params, $where);
	}

	function updateData($id, $balasan)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

 		$params = array(
			'balasan' => $balasan, 
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		
		$where = $this->kontak->getAdapter()->quoteInto('id = ?', $id);
		$this->kontak->update($params, $where);
	}

	public function deleteData($id)
	{
		$where = $this->kontak->getAdapter()->quoteInto('id = ?', $id);
		$this->kontak->delete($where);
	}

	public function softDeleteData($id)
	{
		$params = array(
			'status' => 9
		);
 		
		$where = $this->kontak->getAdapter()->quoteInto('id = ?', $id);
		$this->kontak->update($params, $where);
	}

}