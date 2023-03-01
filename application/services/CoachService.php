<?php
class CoachService 
{
	  
 	function __construct() 
	{
		$this->coach = new Coach();
	}
	
	function getAllData()
	{
	
		$select = $this->coach->select()->where('status = 1');
		$result = $this->coach->fetchAll($select);
		return $result;
	}
	
	
	function getData($id)
	{
		$select = $this->coach->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->coach->fetchRow($select);
		return $result;
	}

	function addData($nama_coach, $instansi, $email, $no_telp, $identitas_coach, $fotocoach_uri) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'nama_coach' => $nama_coach, 
			'identitas_coach' => $identitas_coach,
			'instansi' => $instansi,
			'email' => $email,
			'no_telp' => $no_telp,
			'fotocoach_uri' => $fotocoach_uri,
			'status' => 1, 
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->coach->insert($params);
		$lastId = $this->coach->getAdapter()->lastInsertId();
		return $lastId;	
	}


	function editData($id, $nama_coach, $identitas_coach, $instansi, $email, $no_telp, $fotocoach_uri)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');
		$params = array(
			'nama_coach' => $nama_coach,
			'identitas_coach' => $identitas_coach, 	 		
			'instansi' => $instansi, 	
			'email' => $email, 	
			'no_telp' => $no_telp, 	
			'fotocoach_uri' => $fotocoach_uri,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->coach->getAdapter()->quoteInto('id = ?', $id);
		$this->coach->update($params, $where);

	}

	public function deleteFiles($id) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'fotocoach_uri' => '',
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->coach->getAdapter()->quoteInto('id = ?', $id);
		$this->coach->update($params, $where);
	}
	
	public function deleteData($id)
	{
		$where = $this->coach->getAdapter()->quoteInto('id = ?', $id);
		$this->coach->delete($where);
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
 		
		$where = $this->coach->getAdapter()->quoteInto('id = ?', $id);
		$this->coach->update($params, $where);
	}

}