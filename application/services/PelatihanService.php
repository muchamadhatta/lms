<?php
class PelatihanService 
{
	  
 	function __construct() 
	{
		$this->pelatihan = new Pelatihan();
	}
	
	function getAllData()
	{
		/*$select = $this->subpelatihan_artikel->select()
			->setIntegrityCheck(false)
			->from(array('a' => 'pelatihan'), array('*'))
			->joinLeft(array('b' => 'artikel'), 'a.id = b.id_pelatihan', array('nama'))
			->where('a.status = 1');*/

		$select = $this->pelatihan->select()->where('status = 1');
		$result = $this->pelatihan->fetchAll($select);
		return $result;
	}
	
	// function getAllData2()
	// {
	// 	$sql = "SELECT *
	// 			FROM pelatihan
	// 			WHERE status = 1";

	// 	$db = Zend_Registry::get('db');
	// 	$stmt = $db->query($sql);
	// 	$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
	// 	$result = $stmt->fetchAll();	
	// 	return $result;
	// }

	function getData($id)
	{
		$select = $this->pelatihan->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->pelatihan->fetchRow($select);
		return $result;
	}

	function getData2($id)
	{
		$sql = "SELECT *
				FROM pelatihan
				WHERE status = 1 AND id = ?";

		$db = Zend_Registry::get('db');
		$stmt = $db->query($sql, array($id));
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetch();	
		return $result;
	}

	function addData($nama_pelatihan, $deskripsi, $tipe_pelatihan, $sampul_pelatihan) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'nama_pelatihan' => $nama_pelatihan, 	
			'deskripsi' => $deskripsi, 	
			'tipe_pelatihan' => $tipe_pelatihan, 
			'sampul_pelatihan' => $sampul_pelatihan, 	
			'status' => 1, 	
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->pelatihan->insert($params);
		$lastId = $this->pelatihan->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function addData2($nama_pelatihan, $deskripsi,$tipe_pelatihan) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$sql = "INSERT INTO pelatihan (nama_pelatihan, user_input, tanggal_input, user_update, tanggal_update) VALUES (?, ?, ?, ?, ?);";

		$db = Zend_Registry::get('db');
		$db->query($sql, array($id, $user_log, $tanggal_log, $user_log, $tanggal_log));
	}

	function editData($id, $nama_pelatihan, $deskripsi,$tipe_pelatihan,$sampul_pelatihan)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');
		
		$params = array(
			'nama_pelatihan' => $nama_pelatihan, 	
			'deskripsi' => $deskripsi, 	
			'tipe_pelatihan' => $tipe_pelatihan, 		
			'sampul_pelatihan' => $sampul_pelatihan, 
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->pelatihan->getAdapter()->quoteInto('id = ?', $id);
		$this->pelatihan->update($params, $where);

	}

	public function deleteFiles($id) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'sampul_pelatihan' => '',
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->pelatihan->getAdapter()->quoteInto('id = ?', $id);
		$this->pelatihan->update($params, $where);
	}

	public function deleteData($id)
	{
		$where = $this->pelatihan->getAdapter()->quoteInto('id = ?', $id);
		$this->pelatihan->delete($where);
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
 		
		$where = $this->pelatihan->getAdapter()->quoteInto('id = ?', $id);
		$this->pelatihan->update($params, $where);
	}

}