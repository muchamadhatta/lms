<?php
class KontenSettingService 
{
	  
 	function __construct() 
	{
		$this->konten_setting = new KontenSetting();
	}
	
	function getDefaultAllData()
	{
		$select = $this->konten_setting->select()->where('status = 1');
		$result = $this->konten_setting->fetchAll($select);
		return $result;
	}
	
	function getAllData()
	{
		$select = $this->konten_setting->select()->where('status = 1');
		$result = $this->konten_setting->fetchAll($select);
		return $result;
	}

	function getData($id)
	{
		$select = $this->konten_setting->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->konten_setting->fetchRow($select);
		return $result;
	}

	function addData($nama, $nilai) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'nama' => $nama, 
			'nilai' => $nilai, 
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->konten_setting->insert($params);
		$lastId = $this->konten_setting->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $nama, $nilai)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'nama' => $nama, 
			'nilai' => $nilai, 
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->konten_setting->getAdapter()->quoteInto('id = ?', $id);
		$this->konten_setting->update($params, $where);

	}

	public function deleteData($id)
	{
		$where = $this->konten_setting->getAdapter()->quoteInto('id = ?', $id);
		$this->konten_setting->delete($where);
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
 		
		$where = $this->konten_setting->getAdapter()->quoteInto('id = ?', $id);
		$this->konten_setting->update($params, $where);
	}

}