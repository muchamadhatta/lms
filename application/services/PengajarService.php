<?php
class PengajarService 
{
	  
 	function __construct() 
	{
		$this->pengajar = new pengajar();
	}
	
	function getAllData()
	{
		$select = $this->pengajar->select()->where('status = 1');
		$result = $this->pengajar->fetchAll($select);
		return $result;
	}

	function getData($id)
	{
		$select = $this->pengajar->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->pengajar->fetchRow($select);
		return $result;
	}

	function addData($nama_pengajar, $status_asal, $email, $no_telp, $identitas_pengajar, $fotopengajar_uri) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'nama_pengajar' => $nama_pengajar, 
			'status_asal' => $status_asal,
			'email' => $email,
			'no_telp' => $no_telp,
			'identitas_pengajar' => $identitas_pengajar,
			'fotopengajar_uri' => $fotopengajar_uri,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->pengajar->insert($params);
		$lastId = $this->pengajar->getAdapter()->lastInsertId();
		return $lastId;	
	}


	function editdata ($id, $nama_pengajar, $status_asal, $email, $no_telp, $identitas_pengajar, $fotopengajar_uri)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'nama_pengajar' => $nama_pengajar,
			'status_asal' => $status_asal,
			'email' => $email,
			'no_telp' => $no_telp,
			'identitas_pengajar' => $identitas_pengajar,
			'fotopengajar_uri' => $fotopengajar_uri,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->pengajar->getAdapter()->quoteInto('id = ?', $id);
		$this->pengajar->update($params, $where);
	}

	public function deleteFiles($id)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'fotopengajar_uri' => '',
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->pengajar->getAdapter()->quoteInto('id = ?', $id);
		$this->pengajar->update($params, $where);
	}

	public function deleteData($id)
	{
		$where = $this->pengajar->getAdapter()->quoteInto('id = ?', $id);
		$this->pengajar->delete($where);
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
 		
		$where = $this->pengajar->getAdapter()->quoteInto('id = ?', $id);
		$this->pengajar->update($params, $where);
	}

}