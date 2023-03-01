<?php
class LaporanKustomService {
	  
 	function __construct() {
  		$this->laporan_kustom = new LaporanKustom();
	}

	function getAllData()
	{ 
		$select = $this->laporan_kustom->select()
			->setIntegrityCheck(false)
			->from('laporan_kustom', array('id', 'judul', 'sql'))
			->where('status = 1');
		$result = $this->laporan_kustom->fetchAll($select);
		return $result;
	}

	function getData($id)
	{ 
		$select = $this->laporan_kustom->select()->where('id = ?', $id);
		$result = $this->laporan_kustom->fetchRow($select);
		return $result;
	}
  	
	function addData($judul, $sql) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'judul' => $judul,
			'sql' => $sql,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->laporan_kustom->insert($params);	
	}

	function editData($id, $judul, $sql)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

 		$params = array(
			'judul' => $judul,
			'sql' => $sql,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		
		$where = $this->laporan_kustom->getAdapter()->quoteInto('id = ?', $id);
		$this->laporan_kustom->update($params, $where);
	}

	public function deleteData($id)
	{
		$where = $this->laporan_kustom->getAdapter()->quoteInto('id = ?', $id);
		$this->laporan_kustom->delete($where);
	}

	function softDeleteData($id)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

 		$params = array(
			'status' => 9,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		
		$where = $this->laporan_kustom->getAdapter()->quoteInto('id = ?', $id);
		$this->laporan_kustom->update($params, $where);
	}

	public function viewData($id)
	{
		$select = $this->laporan_kustom->select()->where('id = ?', $id);
		$row = $this->laporan_kustom->fetchRow($select);

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($row->sql);;
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

}