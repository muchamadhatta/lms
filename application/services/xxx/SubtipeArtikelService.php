<?php
class SubtipeArtikelService 
{
	  
 	function __construct() 
	{
		$this->subtipe_artikel = new SubtipeArtikel();
	}

	function getDefaultData($id)
	{
		$select = $this->subtipe_artikel->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->subtipe_artikel->fetchRow($select);
		return $result;
	}
	
	function getAllData()
	{
		$select = $this->subtipe_artikel->select()
			->setIntegrityCheck(false)
			->from(array('a' => 'subtipe_artikel'), array('*'))
			->joinLeft(array('b' => 'tipe_artikel'), 'a.id_tipe_artikel = b.id', array('tipe_artikel'))
			->where('a.status = 1');

		$result = $this->subtipe_artikel->fetchAll($select);
		return $result;
	}

	function getData($id)
	{
		$select = $this->subtipe_artikel->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->subtipe_artikel->fetchRow($select);
		return $result;
	}

	function addData($subtipe_artikel, $id_tipe_artikel, $konten) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'subtipe_artikel' => $subtipe_artikel, 
			'id_tipe_artikel' => $id_tipe_artikel, 
			'konten' => $konten, 
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->subtipe_artikel->insert($params);
		$lastId = $this->subtipe_artikel->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $subtipe_artikel, $id_tipe_artikel, $konten)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'subtipe_artikel' => $subtipe_artikel,
			'id_tipe_artikel' => $id_tipe_artikel,
			'konten' => $konten, 
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->subtipe_artikel->getAdapter()->quoteInto('id = ?', $id);
		$this->subtipe_artikel->update($params, $where);

	}

	public function deleteData($id)
	{
		$where = $this->subtipe_artikel->getAdapter()->quoteInto('id = ?', $id);
		$this->subtipe_artikel->delete($where);
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
 		
		$where = $this->subtipe_artikel->getAdapter()->quoteInto('id = ?', $id);
		$this->subtipe_artikel->update($params, $where);
	}

}