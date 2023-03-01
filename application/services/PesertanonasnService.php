<?php
class PesertanonasnService 
{
	
 	function __construct() 
	{
		$this->pesertanonasn = new Pesertanonasn();
	}
	
	function getAllData()
	{
		$select = $this->pesertanonasn->select()->where('status = 1');
		$result = $this->pesertanonasn->fetchAll($select);
		return $result;
	}
	

	function getData($id)
	{
		$select = $this->pesertanonasn->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->pesertanonasn->fetchRow($select);
		return $result;
	}



	function addData($nama) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');
		$params = array(			
			'fotopesertanonasn_uri' => $fotopesertanonasn_uri, 
			'nama' => $nama, 
			'identitas' => $identitas, 
			'tempat_lahir' => $tempat_lahir, 
			'tanggal_lahir' => $tanggal_lahir, 
			'agama' => $agama, 
			'status_' => $status_perkawinan, 
			'status' => 1, 
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->pesertanonasn->insert($params);
		$lastId = $this->pesertanonasn->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $nama)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');
		$params = array(
			'nama' => $nama,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$where = $this->pesertanonasn->getAdapter()->quoteInto('id = ?', $id);
		$this->pesertanonasn->update($params, $where);

	}

	public function deleteData($id)
	{
		$where = $this->pesertanonasn->getAdapter()->quoteInto('id = ?', $id);
		$this->pesertanonasn->delete($where);
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

		$where = $this->pesertanonasn->getAdapter()->quoteInto('id = ?', $id);
		$this->pesertanonasn->update($params, $where);
	}

}