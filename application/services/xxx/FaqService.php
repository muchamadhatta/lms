<?php
class FaqService 
{
	  
 	function __construct() 
	{
		$this->faq = new Faq();
	}
	
	function getAllData()
	{
		$select = $this->faq->select()->where('status = 1');
		$result = $this->faq->fetchAll($select);
		return $result;
	}

	function getData($id)
	{
		$select = $this->faq->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->faq->fetchRow($select);
		return $result;
	}

	function addData($pertanyaan, $jawaban) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'pertanyaan' => $pertanyaan, 		
			'jawaban' => $jawaban,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->faq->insert($params);
		$lastId = $this->faq->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $pertanyaan, $jawaban)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'pertanyaan' => $pertanyaan, 		
			'jawaban' => $jawaban,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->faq->getAdapter()->quoteInto('id = ?', $id);
		$this->faq->update($params, $where);

	}

	public function deleteData($id)
	{
		$where = $this->faq->getAdapter()->quoteInto('id = ?', $id);
		$this->faq->delete($where);
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
 		
		$where = $this->faq->getAdapter()->quoteInto('id = ?', $id);
		$this->faq->update($params, $where);
	}

}