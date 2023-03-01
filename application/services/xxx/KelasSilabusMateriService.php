<?php
class KelasSilabusMateriService 
{
	  
 	function __construct() 
	{
		$this->kelas_silabus_materi = new KelasSilabusMateri();
	}
	
	// function getAllData($id_kelas)
	// {
	// 	$select = $this->kelas_silabus_materi->select()->where('status = 1')->where('id_kelas= ?', $id_kelas);
	// 	$result = $this->kelas_silabus_materi->fetchAll($select);
	// 	return $result;
	// }

	function getData($id)
	{
		$select = $this->kelas_silabus_materi->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->kelas_silabus_materi->fetchRow($select);
		return $result;
	}

	function getDataByIdKelasSilabus($id_kelas_silabus)
	{
		$select = $this->kelas_silabus_materi->select()->where('status = 1')->where('id_kelas_silabus = ?', $id_kelas_silabus);
		$result = $this->kelas_silabus_materi->fetchAll($select);
		return $result;
	}

	function addData($id_kelas_silabus, $nama_materi, $deskripsi_materi, $isi_materi) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'id_kelas_silabus' => $id_kelas_silabus, 		
			'nama_materi' => $nama_materi,
			'deskripsi_materi' => $deskripsi_materi,
			'isi_materi' => $isi_materi,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->kelas_silabus_materi->insert($params);
		$lastId = $this->kelas_silabus_materi->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $nama_materi, $deskripsi_materi, $isi_materi)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(		
			'nama_materi' => $nama_materi,
			'deskripsi_materi' => $deskripsi_materi,
			'isi_materi' => $isi_materi,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->kelas_silabus_materi->getAdapter()->quoteInto('id = ?', $id);
		$this->kelas_silabus_materi->update($params, $where);

	}

	public function deleteData($id)
	{
		$where = $this->kelas_silabus_materi->getAdapter()->quoteInto('id = ?', $id);
		$this->kelas_silabus_materi->delete($where);
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
 		
		$where = $this->kelas_silabus_materi->getAdapter()->quoteInto('id = ?', $id);
		$this->kelas_silabus_materi->update($params, $where);
	}

}