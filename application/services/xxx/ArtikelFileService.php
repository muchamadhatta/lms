<?php
class ArtikelFileService 
{
	  
 	function __construct() 
	{
		$this->artikel_file = new ArtikelFile();
	}
	
	function getAllData($id_artikel)
	{
		$select = $this->artikel_file->select()->where('status = 1')->where('id_artikel = ?', $id_artikel);
		$result = $this->artikel_file->fetchAll($select);
		return $result;
	}

	function getData($id)
	{
		$select = $this->artikel_file->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->artikel_file->fetchRow($select);
		return $result;
	}

	function addData($id_artikel, $jenis, $judul) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(	
			'id_artikel' => $id_artikel, 	
			'jenis' => $jenis, 	
			'judul' => $judul, 
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->artikel_file->insert($params);
		$lastId = $this->artikel_file->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $jenis, $judul)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'jenis' => $jenis, 	
			'judul' => $judul,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->artikel_file->getAdapter()->quoteInto('id = ?', $id);
		$this->artikel_file->update($params, $where);

	}

	public function deleteData($id)
	{
		$where = $this->artikel_file->getAdapter()->quoteInto('id = ?', $id);
		$this->artikel_file->delete($where);
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
 		
		$where = $this->artikel_file->getAdapter()->quoteInto('id = ?', $id);
		$this->artikel_file->update($params, $where);
	}

	function editFile($id, $file_name, $file_type, $file_size)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'file_name' => $file_name,
			'file_type' => $file_type,
			'file_size' => $file_size,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->artikel_file->getAdapter()->quoteInto('id = ?', $id);
		$this->artikel_file->update($params, $where);
	}

	public function softDeleteFile($id)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'file_name' => null,
			'file_type' => null,
			'file_size' => null,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		
		$where = $this->artikel_file->getAdapter()->quoteInto('id = ?', $id);
		$this->artikel_file->update($params, $where);
	}

}