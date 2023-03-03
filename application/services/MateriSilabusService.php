<?php
class MateriSilabusService {
	  
 	function __construct() {
		$this->materi_silabus = new MateriSilabus();
	}

	function getAllData() {
		$select = $this->materi_silabus->select()->where('status = 1');
		$result = $this->materi_silabus->fetchAll($select);
		return $result;
	}

	function getData($id) {
		$select = $this->materi_silabus->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->materi_silabus->fetchRow($select);
		return $result;
	}

	// function getDataByIdKelasSilabus($id_kelas_silabus) {
	// 	$select = $this->materi_silabus->select()->where('status = 1')->where('id_kelas_silabus = ?', $id_kelas_silabus);
	// 	$result = $this->materi_silabus->fetchAll($select);
	// 	return $result;
	// }

	function addData($id_pelatihan, $nama_materi, $deskripsi_materi, $gambar_materi_uri, $document_materi_uri, $audio_materi_uri, $video_materi_uri) {
		// $id_kelas_silabus
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'id_pelatihan' => $id_pelatihan, 		
			'nama_materi' => $nama_materi,
			'deskripsi_materi' => $deskripsi_materi,
			'gambar_materi_uri' => $gambar_materi_uri,
			'document_materi_uri' => $document_materi_uri,
			'audio_materi_uri' => $audio_materi_uri,
			'video_materi_uri' => $video_materi_uri,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->materi_silabus->insert($params);
		$lastId = $this->materi_silabus->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $nama_materi, $deskripsi_materi, $gambar_materi_uri, $document_materi_uri, $audio_materi_uri, $video_materi_uri) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		if($gambar_materi_uri == '' && $document_materi_uri == '' && $audio_materi_uri == '' && $video_materi_uri == '') {
			$params = array(		
				'id_pelatihan' => $id_pelatihan, 	
				'nama_materi' => $nama_materi,
				'deskripsi_materi' => $deskripsi_materi,
				'user_update' => $user_log,
				'tanggal_update' => $tanggal_log
			);
		} else {
			$params = array(		
				'id_pelatihan' => $id_pelatihan, 	
				'nama_materi' => $nama_materi,
				'deskripsi_materi' => $deskripsi_materi,
				'gambar_materi_uri' => $gambar_materi_uri,
				'document_materi_uri' => $document_materi_uri,
				'audio_materi_uri' => $audio_materi_uri,
				'video_materi_uri' => $video_materi_uri,
				'user_update' => $user_log,
				'tanggal_update' => $tanggal_log
			);
		}


 		$where = $this->materi_silabus->getAdapter()->quoteInto('id = ?', $id);
		$this->materi_silabus->update($params, $where);

	}

	public function deleteData($id) {
		$where = $this->materi_silabus->getAdapter()->quoteInto('id = ?', $id);
		$this->materi_silabus->delete($where);
	}

	public function deleteFiles($id) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'gambar_materi_uri' => '',
			'document_materi_uri' => '',
			'audio_materi_uri' => '',
			'video_materi_uri' => '',
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		
 		$where = $this->materi_silabus->getAdapter()->quoteInto('id = ?', $id);
		$this->materi_silabus->update($params, $where);
	}

	public function softDeleteData($id) {
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'status' => 9,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		
		$where = $this->materi_silabus->getAdapter()->quoteInto('id = ?', $id);
		$this->materi_silabus->update($params, $where);
	}

}