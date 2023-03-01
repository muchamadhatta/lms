<?php
class ArtikelImageService 
{
	  
 	function __construct() 
	{
		$this->artikel_image = new ArtikelImage();
	}
	
	function getAllData($id_artikel)
	{
		$select = $this->artikel_image->select()->where('status = 1')->where('id_artikel = ?', $id_artikel);
		$result = $this->artikel_image->fetchAll($select);
		return $result;
	}

	function getData($id)
	{
		$select = $this->artikel_image->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->artikel_image->fetchRow($select);
		return $result;
	}

	function addData($judul) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'judul' => $judul, 
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->artikel_image->insert($params);
		$lastId = $this->artikel_image->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $judul)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'judul' => $judul,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->artikel_image->getAdapter()->quoteInto('id = ?', $id);
		$this->artikel_image->update($params, $where);
	}

	public function deleteData($id)
	{
		$where = $this->artikel_image->getAdapter()->quoteInto('id = ?', $id);
		$this->artikel_image->delete($where);
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
 		
		$where = $this->artikel_image->getAdapter()->quoteInto('id = ?', $id);
		$this->artikel_image->update($params, $where);
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
 		$where = $this->artikel_image->getAdapter()->quoteInto('id = ?', $id);
		$this->artikel_image->update($params, $where);
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
 		
		$where = $this->artikel_image->getAdapter()->quoteInto('id = ?', $id);
		$this->artikel_image->update($params, $where);
	}

}