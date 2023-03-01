<?php
class KontenStatisService 
{
	  
 	function __construct() 
	{
		$this->konten_statis = new KontenStatis();
	}
	
	function getAllData()
	{
		$select = $this->konten_statis->select()->where('status = 1');
		$result = $this->konten_statis->fetchAll($select);
		return $result;
	}

	function getDefaultData($id)
	{
		$select = $this->konten_statis->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->konten_statis->fetchRow($select);
		return $result;
	}

	function getData($id)
	{
		$select = $this->konten_statis->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->konten_statis->fetchRow($select);
		return $result;
	}

	function addData($judul, $konten) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'judul' => $judul, 
			'konten' => $konten, 
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->konten_statis->insert($params);
		$lastId = $this->konten_statis->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $judul, $konten)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'judul' => $judul, 
			'konten' => $konten, 
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->konten_statis->getAdapter()->quoteInto('id = ?', $id);
		$this->konten_statis->update($params, $where);

	}

	public function deleteData($id)
	{
		$where = $this->konten_statis->getAdapter()->quoteInto('id = ?', $id);
		$this->konten_statis->delete($where);
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
 		
		$where = $this->konten_statis->getAdapter()->quoteInto('id = ?', $id);
		$this->konten_statis->update($params, $where);
	}

}