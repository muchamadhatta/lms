<?php
class TipeService 
{
	  
 	function __construct() 
	{
		$this->tipe = new Tipe();
	}
	
	function getAllData()
	{
		/*$select = $this->subtipe_artikel->select()
			->setIntegrityCheck(false)
			->from(array('a' => 'tipe'), array('*'))
			->joinLeft(array('b' => 'artikel'), 'a.id = b.id_tipe', array('nama'))
			->where('a.status = 1');*/

		$select = $this->tipe->select()->where('status = 1');
		$result = $this->tipe->fetchAll($select);
		return $result;
	}
	
	function getAllData2()
	{
		$sql = "SELECT *
				FROM tipe
				WHERE status = 1";

		$db = Zend_Registry::get('db');
		$stmt = $db->query($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();	
		return $result;
	}

	function getData($id)
	{
		$select = $this->tipe->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->tipe->fetchRow($select);
		return $result;
	}

	function getData2($id)
	{
		$sql = "SELECT *
				FROM tipe
				WHERE status = 1 AND id = ?";

		$db = Zend_Registry::get('db');
		$stmt = $db->query($sql, array($id));
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetch();	
		return $result;
	}

	function addData($tipe) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'tipe' => $tipe, 		
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->tipe->insert($params);
		$lastId = $this->tipe->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function addData2($tipe) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$sql = "INSERT INTO tipe (tipe, user_input, tanggal_input, user_update, tanggal_update) VALUES (?, ?, ?, ?, ?);";

		$db = Zend_Registry::get('db');
		$db->query($sql, array($id, $user_log, $tanggal_log, $user_log, $tanggal_log));
	}

	function editData($id, $tipe)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'tipe' => $tipe, 		
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->tipe->getAdapter()->quoteInto('id = ?', $id);
		$this->tipe->update($params, $where);

	}

	public function deleteData($id)
	{
		$where = $this->tipe->getAdapter()->quoteInto('id = ?', $id);
		$this->tipe->delete($where);
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
 		
		$where = $this->tipe->getAdapter()->quoteInto('id = ?', $id);
		$this->tipe->update($params, $where);
	}

}