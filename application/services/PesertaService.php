<?php
class PesertaService 
{
	
 	function __construct() 
	{
		$this->peserta = new Peserta();
	}
	
	function getAllData()
	{
		$select = $this->peserta->select()->where('status = 1');
		$result = $this->peserta->fetchAll($select);
		return $result;
	}
	

	function getData($id)
	{
		$select = $this->peserta->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->peserta->fetchRow($select);
		return $result;
	}



	function addData($nama) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');
		$params = array(			
			'nama' => $nama, 
			'status' => 1, 
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->peserta->insert($params);
		$lastId = $this->peserta->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $nama)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');
		$params = array(
			'nama' => $nama,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$where = $this->peserta->getAdapter()->quoteInto('id = ?', $id);
		$this->peserta->update($params, $where);

	}

	public function deleteData($id)
	{
		$where = $this->peserta->getAdapter()->quoteInto('id = ?', $id);
		$this->peserta->delete($where);
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

		$where = $this->peserta->getAdapter()->quoteInto('id = ?', $id);
		$this->peserta->update($params, $where);
	}

}