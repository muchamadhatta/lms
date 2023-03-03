<?php
class BatchService
{

	function __construct()
	{
		$this->batch = new Batch();
	}

	function getAllData()
	{
		$select = $this->batch->select()->where('status = 1');
		$result = $this->batch->fetchAll($select);
		return $result;
	}

	function getData($id)
	{
		$select = $this->batch->select()->where('status = 1')->where('id = ?', $id);
		$result = $this->batch->fetchRow($select);
		return $result;
	}

	function addNonFreeData($jenis_batch, $id_kelas, $id_pengajar, $judul_batch, $deskripsi){
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'jenis_batch' => $jenis_batch,
			'id_kelas' => $id_kelas,
			'id_pengajar' => $id_pengajar,
			'judul_batch' => $judul_batch,
			'deskripsi' => $deskripsi,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log

		);
		$this->batch->insert($params);
		$lastId = $this->batch->getAdapter()->lastInsertId();
		return $lastId;

	}

	function addData($id_kelas, $id_pengajar, $judul_batch, $deskripsi, $tgl_awal, $tgl_akhir)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'id_kelas' => $id_kelas,
			'id_pengajar' => $id_pengajar,
			'judul_batch' => $judul_batch,
			'deskripsi' => $deskripsi,
			'tgl_awal' => $tgl_awal,
			'tgl_akhir' => $tgl_akhir,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log

		);
		$this->batch->insert($params);
		$lastId = $this->batch->getAdapter()->lastInsertId();
		return $lastId;
	}

	function editData($id, $id_kelas, $id_pengajar, $judul_batch, $deskripsi, $tgl_awal, $tgl_akhir)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'id_kelas' => $id_kelas,
			'id_pengajar' => $id_pengajar,
			'judul_batch' => $judul_batch,
			'deskripsi' => $deskripsi,
			'tgl_awal' => $tgl_awal,
			'tgl_akhir' => $tgl_akhir,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$where = $this->batch->getAdapter()->quoteInto('id = ?', $id);
		$this->batch->update($params, $where);
	}

	public function deleteData($id)
	{
		$where = $this->batch->getAdapter()->quoteInto('id = ?', $id);
		$this->batch->delete($where);
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

		$where = $this->batch->getAdapter()->quoteInto('id = ?', $id);
		$this->batch->update($params, $where);
	}
}
