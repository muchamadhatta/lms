<?php
class KelasSilabusService 
{
	  
 	function __construct() 
	{
		$this->kelas_silabus = new KelasSilabus();
	}
	
	function getAllData($id_kelas)
	{
		$select = $this->kelas_silabus->select()->where('status = 1')->where('id_kelas = ?', $id_kelas);
		$result = $this->kelas_silabus->fetchAll($select);
		return $result;
	}

	function getData($id)
	{
		$select = $this->kelas_silabus->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->kelas_silabus->fetchRow($select);
		return $result;
	}

	function addData($id_kelas, $nama_silabus) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'id_kelas' => $id_kelas, 		
			'nama_silabus' => $nama_silabus,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->kelas_silabus->insert($params);
		$lastId = $this->kelas_silabus->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $nama_silabus)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(		
			'nama_silabus' => $nama_silabus,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->kelas_silabus->getAdapter()->quoteInto('id = ?', $id);
		$this->kelas_silabus->update($params, $where);

	}

	public function deleteData($id)
	{
		$where = $this->kelas_silabus->getAdapter()->quoteInto('id = ?', $id);
		$this->kelas_silabus->delete($where);
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
 		
		$where = $this->kelas_silabus->getAdapter()->quoteInto('id = ?', $id);
		$this->kelas_silabus->update($params, $where);
	}

}