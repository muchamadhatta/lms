<?php
class TagCloudService 
{
	  
 	function __construct() 
	{
		$this->tag_cloud = new TagCloud();
	}
	
	function getDefaultAllData()
	{
		$sql = "SELECT tag, COUNT(*) AS jumlah
				FROM tag_cloud
				GROUP BY tag";

		$db = Zend_Registry::get('db');
		$stmt = $db->query($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();	
		return $result;
	}
	
	function getAllData()
	{
		$select = $this->tag_cloud->select();
		$result = $this->tag_cloud->fetchAll($select);
		return $result;
	}

	function getData($tag)
	{
		$select = $this->tag_cloud->select()->where('tag = ?', $tag);
		$result = $this->tag_cloud->fetchRow($select);
		return $result;
	}

	function addData($tag) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'tag' => $tag, 		
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->tag_cloud->insert($params);
		$lastId = $this->tag_cloud->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $tag)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'tag' => $tag, 		
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->tag_cloud->getAdapter()->quoteInto('id = ?', $id);
		$this->tag_cloud->update($params, $where);

	}

	public function deleteData()
	{
		//$where = $this->tag_cloud->getAdapter()->quoteInto('id = ?', $id);
		//$this->tag_cloud->delete($where);
		$db = Zend_Registry::get('db');
		$sql = "DELETE FROM tag_cloud;";
		$db->query($sql);
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
 		
		$where = $this->tag_cloud->getAdapter()->quoteInto('id = ?', $id);
		$this->tag_cloud->update($params, $where);
	}

}