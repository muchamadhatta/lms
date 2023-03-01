<?php
class KelasService 
{
	  
 	function __construct() 
	{
		$this->kelas = new Kelas();
	}
	
	function getAllData()
	{
		$select = $this->kelas->select()->where('status = 1');
		$result = $this->kelas->fetchAll($select);
		return $result;
	}

	function getData($id)
	{
		$select = $this->kelas->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->kelas->fetchRow($select);
		return $result;
	}

	function addData($nama_kelas, $deskripsi, $tentang, $jenis_kelas, $thumbnail_uri) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'nama_kelas' => $nama_kelas, 
			'deskripsi' => $deskripsi,
			'tentang' => $tentang,
			'jenis_kelas' => $jenis_kelas,
			'thumbnail_uri' => $thumbnail_uri,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->kelas->insert($params);
		$lastId = $this->kelas->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $nama_kelas, $deskripsi, $tentang, $jenis_kelas, $thumbnail_uri)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'nama_kelas' => $nama_kelas,
			'deskripsi' => $deskripsi,
			'tentang' => $tentang,
			'jenis_kelas' => $jenis_kelas,
			'thumbnail_uri' => $thumbnail_uri,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->kelas->getAdapter()->quoteInto('id = ?', $id);
		$this->kelas->update($params, $where);

	}

	public function deleteFiles($id)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');
		
		$params = array(
			'thumbnail_uri' => '',
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->kelas->getAdapter()->quoteInto('id = ?', $id);
		$this->kelas->update($params, $where);
	}

	public function deleteData($id)
	{
		$where = $this->kelas->getAdapter()->quoteInto('id = ?', $id);
		$this->kelas->delete($where);
	}

	public function softDeleteData($id)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'status' => 9,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		
		$where = $this->kelas->getAdapter()->quoteInto('id = ?', $id);
		$this->kelas->update($params, $where);
	}

}