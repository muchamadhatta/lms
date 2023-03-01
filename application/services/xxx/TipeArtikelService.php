<?php
class TipeArtikelService 
{
	  
 	function __construct() 
	{
		$this->tipe_artikel = new TipeArtikel();
	}

	function getDefaultTopStoriesGroupData()
	{ 
		$sql = "SELECT a.*
				FROM tipe_artikel a
				WHERE a.status_artikel_utama = 1";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultMenuData()
	{ 
		$sql = "SELECT b.id, a.tipe_artikel, GROUP_CONCAT(b.id, '|', b.subtipe_artikel) AS subtipe_artikel, COUNT(*) AS jumlah
				FROM tipe_artikel a
				JOIN subtipe_artikel b ON a.id = b.id_tipe_artikel
				GROUP BY a.id";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultAllData()
	{ 
		$sql = "SELECT a.id, b.subtipe_artikel, a.tipe_artikel
				FROM tipe_artikel a
				JOIN subtipe_artikel b ON a.id = b.id_tipe_artikel
				WHERE a.status = 1
				ORDER BY a.tipe_artikel";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultData($id)
	{
		$select = $this->tipe_artikel->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->tipe_artikel->fetchRow($select);
		return $result;
	}
	
	function getAllData()
	{
		$select = $this->tipe_artikel->select()->where('status = 1');
		$result = $this->tipe_artikel->fetchAll($select);
		return $result;
	}

	function getData($id)
	{
		$select = $this->tipe_artikel->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->tipe_artikel->fetchRow($select);
		return $result;
	}

	function addData($tipe_artikel, $konten) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'tipe_artikel' => $tipe_artikel, 
			'konten' => $konten, 
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->tipe_artikel->insert($params);
		$lastId = $this->tipe_artikel->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $tipe_artikel, $konten)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'tipe_artikel' => $tipe_artikel,
			'konten' => $konten, 
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->tipe_artikel->getAdapter()->quoteInto('id = ?', $id);
		$this->tipe_artikel->update($params, $where);

	}

	public function deleteData($id)
	{
		$where = $this->tipe_artikel->getAdapter()->quoteInto('id = ?', $id);
		$this->tipe_artikel->delete($where);
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
 		
		$where = $this->tipe_artikel->getAdapter()->quoteInto('id = ?', $id);
		$this->tipe_artikel->update($params, $where);
	}

}